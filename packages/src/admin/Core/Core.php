<?php namespace Admin\Core;

use Admin\Core\Html;
use App\Models\Menu;
use App\Models\MenuMethod;
use App\Models\Method;
use Cache;

class Core
{
    protected $loadMenu;
    protected $menu;
    protected $method;
    protected $menuMethod;
    protected $menuRepo;
    protected $prefix;
    public $html;

    public function __construct()
    {
        $this->loadMenu    = config('admin_menu');
        $this->menu        = new Menu();
        $this->modelMethod = new Method();
        $this->menuMethod  = new MenuMethod();
        $this->prefix      = config('admin.prefix');
        $this->html        = new Html();
    }

    public function readMenus()
    {
        $result = [];
        $no     = 0;
        foreach ($this->loadMenu as $parent => $valParent) {
            $no++;
            $result[] = [
                'parent_slug' => null,
                'label'       => $valParent['label'],
                'slug'        => $parent,
                'controller'  => $valParent['controller'],
                'methods'     => @$valParent['methods'],
                'order'       => $no,
                'is_active'   => 'true',
                'icon'   => @$valParent['icon'],
            ];

            if (isset($valParent['child'])) {
                foreach ($valParent['child'] as $child => $valChild) {
                    $no++;
                    $result[] = [
                        'parent_slug' => $parent,
                        'label'       => $valChild['label'],
                        'slug'        => $child,
                        'controller'  => $valChild['controller'],
                        'methods'     => @$valChild['methods'],
                        'order'       => $no,
                        'is_active'   => 'true',
                    ];
                }

                if (isset($valChild['child'])) {
                    foreach ($valChild['child'] as $grandChild => $valGrandChild) {
                        $no++;
                        $result[] = [
                            'parent_slug' => $child,
                            'label'       => $valGrandChild['label'],
                            'slug'        => $grandChild,
                            'controller'  => $valGrandChild['controller'],
                            'methods'     => @$valGrandChild['methods'],
                            'order'       => $no,
                            'is_active'   => 'true',
                        ];
                    }
                }
            }

        }

        return $result;
    }

    public function generateMenu()
    {
        $menus = $this->readMenus();
        $slugs = array_pluck($menus, 'slug');
        \DB::beginTransaction();
        try
        {
            $this->menu->whereNotIn('slug', $slugs)->delete();
            $getMethod = [];
            $loop      = 0;
            foreach ($menus as $row) {
                $loop++;
                $methods = [];
                if (isset($row['methods'])) {
                    $methods = $row['methods'];

                    foreach ($row['methods'] as $m) {
                        $modelMethod = $this->modelMethod->updateOrCreate(['method' => $m]);
                    }
                }

                unset($row['methods']);
                $row['order'] = $loop;
                $modelMenu    = $this->menu->where('slug', $row['slug'])->first();
                if (!empty($modelMenu->id)) {
                    $modelMenu->update($row);
                } else {
                    $modelMenu = $this->menu->create($row);
                    //dd($modelMenu);
                }

                if ($methods != []) {
                    $getMethod[] = $methods;
                    foreach ($this->modelMethod->whereIn('method', $methods)->get() as $m2) {
                        $this->menuMethod->updateOrCreate(['menu_id' => $modelMenu->id, 'method_id' => @$m2->id]);
                    }
                }
            }
            $getMethod = array_unique(array_flatten($getMethod));
            if ($getMethod != []) {
                $this->modelMethod->whereNotIn('method', $getMethod)->delete();
            }

            \DB::commit();

            return true;

        } catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }
    }

    public function activeChild($slug = "")
    {
        $rawMenu = $this->rawMenu();

        $menu = $this->getMenu($slug);

        if ($menu->childs()->count()) {
            $cek = $menu->childs()->where('slug', $this->rawMenu())->first();

            if (!empty($cek->id)) {
                return 'active';
            }
        }

    }

    public function displayMenuChilds($row)
    {
        $html = '<ul class="treeview-menu">';
        foreach ($row->childs()->orderBy('order', 'asc')->get() as $c) {
            $active = $this->activeChild($c->slug);
            $count  = $c->childs()->count();
            $url    = $count == 0 ? $this->urlBackend("$c->slug/index") : '#';
            $html .= "<li class='" . $active . "'>";
            $html .= '<a href="' . $url . '"><i class="fa fa-circle-o"></i> ' . $c->label;
            if ($count > 0) {
                $html .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';
            }
            $html .= "</a>";
            if ($count > 0) {
                $html .= $this->displayMenuChilds($c);
            }
            $html .= "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    public function active($slug)
    {
        $result = "";
        if ($this->rawMenu() == $slug) {
            $result = 'active';
        } else {
            $menu = $this->getMenu();
            if (!empty($menu->parent->parent->id)) {
                if ($slug == $menu->parent->parent->slug) {
                    $result = 'active';
                }
            } else {
                if (!empty($menu->parent->id)) {
                    if ($slug == $menu->parent->slug) {
                        $result = 'active';
                    }
                }
            }
        }

        return $result;
    }

    public function convertQueryMenuToHtml()
    {
        $menus = $this->menu->with('childs')->getParents()->get();
        $html  = "";
        foreach ($menus as $row) {
            $icon = !empty($row->icon) ? $row->icon : 'fa fa-file';
               
            $countChild = $row->childs()->count();
            $class      = $countChild > 0 ? 'treeview' : ' ';
            $active     = $this->active($row->slug);
            $url        = $countChild == 0 ? $this->urlBackend("$row->slug/index") : '#';

            $html .= '<li class = "' . $class . ' ' . $active . '">';

            $html .= "<a href='$url'>";
            
            $html .= '<i class="'.$icon.'"></i> <span>' . $row->label . '</span>';
            if ($countChild > 0) {
                $html .= ' <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';
            }
            $html .= "</a>";

            if ($countChild > 0) {
                $html .= $this->displayMenuChilds($row);
            }

            $html .= "</li>";
        }

        return $html;
    }

    public function ifCache($key, $var, $remember)
    {
        if (Cache::has($key)) {
            $result = Cache::get($key);
        } else {
            $result = $var;
            Cache::put($key, $result, $remember);
        }
        return $result;
    }

    public function displayMenus()
    {
        // if(Cache::has('displayMenus'))
        // {
        //  $result=Cache::get('displayMenus');
        // }else{
        //  $result=$this->convertQueryMenuToHtml();
        //  Cache::put('displayMenus',$result,1);
        // }

        $result = $this->convertQueryMenuToHtml();
        return $result;
    }

    public function controllerPath($controller)
    {
        $fixController = str_replace("\\", '/', $controller);

        return $c = app_path('Http/Controllers/' . $fixController . '.php');
    }

    public function displayRoutes()
    {
        \Route::group(['prefix' => $this->prefix], function () {
            \Route::get('/', function () {
                return redirect('login');
            });

            \Route::group(['middleware' => ['auth', 'permission']], function () {
                if (\Schema::hasTable('menus')) {
                    $model = Cache::remember('displayRoutes', 5, function () {
                        return $this->menu->where('controller', '!=', '#')->get();
                    });
                    routeController('profile', 'Admin\ProfileController');
                    foreach ($model as $route) {
                        if (file_exists($this->controllerPath($route->controller))) {
                            routeController($route->slug, $route->controller);
                        }
                    }
                }
            });
        });
    }

    public function explodeControllerMethod()
    {
        $route = \Route::currentRouteAction();
        $exp   = explode("@", $route);
        return $exp;
    }

    public function getAction()
    {
        return $this->explodeControllerMethod()[1];
    }

    public function getMethod($action = "")
    {
        $method = !empty($action) ? $action : $this->rawAction();
        $model  = $this->modelMethod
            ->where('method', $method)
            ->first();

        return $model;
    }

    public function getController()
    {
        $fullController = $this->explodeControllerMethod()[0];
        $exp            = explode("Controllers", $fullController);
        return $exp[1];
    }

    public function getMenu($slug = "", $relation = [])
    {
        $model = $this->menu;

        if (!empty($relation)) {
            $model->with($relation);
        }

        if (!empty($slug)) {
            $model = $model->whereSlug($slug);
        } else {
            $model = $model->whereSlug($this->rawMenu());
        }

        return $model->first();
    }

    public function getParentMenu($slug = "")
    {
        $relation = ['parent'];

        $menu = $this->getMenu($slug, $relation);

        return $menu->parent;
    }

    public function injectModel($model)
    {
        $model = "App\Models\\$model";

        return new $model;
    }

    public function getId()
    {
        $url = request()->url();
        $ex  = explode("/", $url);
        return end($ex);
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function rawAction()
    {
        $url   = request()->url();
        $arr   = explode("/", $url);
        $count = count($arr);
        $end   = end($arr);
        $min   = is_numeric($end) ? 2 : 1;
        return $arr[$count - $min];
    }

    public function rawMenu()
    {
        $url   = request()->url();
        $arr   = explode("/", $url);
        $count = count($arr);
        $end   = end($arr);
        $min   = is_numeric($end) ? 3 : 2;
        return $arr[$count - $min];
    }

    public function labelMenu($slug = "")
    {
        $resultSlug = !empty($slug) ? $slug : $this->rawMenu();

        return !empty($this->getMenu($resultSlug)->label) ? $this->getMenu($resultSlug)->label : '';
    }

    public function labelParentMenu($slug = "")
    {
        $parent = $this->getParentMenu($slug);

        if (!empty($parent)) {
            $result = $parent->label;
        } else {
            $result = "";
        }
        return $result;
    }

    public function labelAction()
    {
        $action = $this->rawAction();

        $result = ucwords($action);

        return $result;
    }

    public function urlBackend($menu)
    {
        $prefix = $this->prefix;

        if ($prefix == '/') {
            $prefix = "";
        }

        return url($prefix . '/' . $menu);
    }

    public function urlBackendAction($action)
    {
        $prefix = $this->getPrefix();
        if ($prefix == '/') {
            $menu   = request()->segment(1);
            $result = $menu . '/' . $action;
        } else {
            $menu   = request()->segment(2);
            $result = $prefix . '/' . $menu . '/' . $action;
        }

        return url($result);
    }

    public function breadCrumbs()
    {
        return [
            $this->urlBackend('/')           => $this->labelMenu(),
            $this->urlBackendAction('index') => ucwords($this->rawAction()),

        ];
    }

    public function publicContents($file)
    {
        return public_path('contents/' . $file);
    }

    public function getUser()
    {
        return auth()->user();
    }

    public function imageUser()
    {
        $auth = $this->getUser();

        if ($auth->avatar == 'user.png') {
            return asset('admin/user.png');
        } else {
            return asset('contents/' . $auth->avatar);
        }
    }

}

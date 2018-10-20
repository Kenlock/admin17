<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Menu;
use Admin;
use Table;
use DB;

class RoleController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->view.='user_administration.role.';
		$this->model = new Role();
	}

    public function getIndex()
    {
    	$role = Admin::getUser()->role;

    	return $this->makeView('index');
    }

    public function getData()
    {
    	$model = $this->model->select('id','code','role')
    		->whereNotIn('id',[Admin::getUser()->role->id,1]);
		return	Table::of($model)
	    		->addColumn('action',function($model){
	    			return admin()->html->linkActions($model);
	    		})
	    		->make(true);
	}

	public function getCreate()
	{
		$menus = Menu::where('parent_slug',null)->get();
		$cek = function($m){
			return false;
		};
		return $this->makeView('_form',[
			'model'=>$this->model,
			'menus'=>$menus,
			'cek'=>$cek,
		]);
	}

	public function postCreate(Requests\Admin\RoleRequest $request)
	{
		DB::beginTransaction();
		try
		{
			$data = $this->beforeSave($request->all());
	        $model = $this->model->create($data);

			$methods = count($request->method);
			$permission = [];
			for($a=0;$a<$methods;$a++)
			{
				$method=$request->method[$a];
				if(!empty($method))
				{
					$code=$model->code.'_can_'.$request->method_code[$a].'_'.$request->menu_slug[$a];
					$permission[] = [
						'role_id'=>$model->id,
						'menu_method_id'=>$method,
						'code'=>$code,
					];
				}
			}
			Permission::insert($permission);
			DB::commit();
			return $this->redirectActionSuccess('Data has been saved');

		}catch(\Exception $e){
			DB::rollback();
			return $this->redirectActionInfo('Error Transaction Query : '.$e->getMessage());
		}

	}

	public function getUpdate($id)
	{
		if($id == 1 || $id == \Admin::getUser()->role->id)
    	{
    		return $this->redirectActionInfo('This data cannot be updated!');
    	}

    	$model = $this->model->findOrFail($id);

		$cek = function($method)use($model){
    		$menu_method = $model->menu_methods()
    			->where('menu_method_id',$method->pivot->id)
    			->first();
    		if(!empty($menu_method->id))
    		{
    			return true;
    		}
        };

		$menus = Menu::where('parent_slug',null)->get();

		return $this->makeView('_form',compact('model','menus','cek'));
	}

	public function postUpdate(Requests\Admin\RoleRequest $request,$id)
	{
		DB::beginTransaction();
		try
		{
			$data = $this->beforeSave($request->all());
	    $model = $this->model->find($id);
			$model->update($data);

			$deletePermission = $model->permissions()->delete();

			$methods = count($request->method);
			$permission = [];
			for($a=0;$a<$methods;$a++)
			{
				$method=$request->method[$a];
				if(!empty($method))
				{
					$code=$model->code.'_can_'.$request->method_code[$a].'_'.$request->menu_slug[$a];
					$permission[] = [
						'role_id'=>$model->id,
						'menu_method_id'=>$method,
						'code'=>$code,
					];
				}
			}
			Permission::insert($permission);
			\Cache::forget('admin_menu_array'.$model->id);
			DB::commit();
			return $this->redirectActionSuccess('Data has been updated');

		}catch(\Exception $e){
			DB::rollback();
			return $this->redirectActionInfo('Error Transaction Query : '.$e->getMessage());
		}
	}

	public function getDelete($id)
    {
    	if($id == 1 || $id == \Admin::getUser()->role->id)
    	{
    		return $this->redirectActionInfo('This data cannot be deleted!');
    	}
    	return $this->delete($this->model->findOrFail($id));

    }

	public function beforeSave($request)
    {
    	$inputs = $request;

        $inputs['code']=kebab_case(ucwords($inputs['role']));

        return $inputs;
    }
}

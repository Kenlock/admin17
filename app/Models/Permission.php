<?php

namespace App\Models;

use Admin;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $fillable = ['code', 'menu_method_id'];

    public function roleHasPermissionThisMethod($menu = "", $method = "")
    {
        $menu   = Admin::getMenu($menu);
        $result = 'method_found';
        if (!empty($menu)) {
            $method = $menu->methods()->where('method', $method)->first();
            if (!empty($menu->id) && !empty($method->id)) {
                $role       = Admin::getUser()->role;
                $menuMethod = $role->menu_methods()
                    ->where('menu_id', $menu->id)
                    ->where('method_id', $method->id)
                    ->first();
                if (!empty($menuMethod->id) || Admin::getUser()->role->code == 'superadmin')
                // if(!empty($menuMethod->id))
                {
                    $result = 'method_found';
                } else {
                    $result = 'method_not_found_on_role';
                }
            } else {
                $result = 'method_not_protected';
            }
        }

        return $result;

    }
}

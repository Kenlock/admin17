<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenuMethod;
use Admin;

class Permission extends Model
{
    public $fillable = ['code','menu_method_id'];

    public function roleHasPermissionThisMethod($menu="",$method="")
    {
    	$menu = Admin::getMenu($menu);
    	$method=Admin::getMethod($method);
    	if(!empty($menu->id) && !empty($method->id))
    	{
    		$role=Admin::getUser()->role;
	    	$menuMethod = $role->menu_methods()
	    		->where('menu_id',$menu->id)
	    		->where('method_id',$method->id)
	    		->first();
	    	
	    	if(!empty($menuMethod->id) || Admin::getUser()->role->code == 'superadmin')
	    	{
	    		return 'method_found';
	    	}else{
	    		return 'method_not_found_on_role';
	    	}
	    }else{
	    		return 'method_not_protected';
	    }
	    	
    }
}

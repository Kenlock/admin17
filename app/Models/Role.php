<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\MenuMethod;
use App\User;

class Role extends Model
{
    protected $fillable = ['code','role'];

    public function users()
    {
    	return $this->hasMany(User::class,'role_id');
    }

    public function menu_methods()
    {
        return $this->belongsToMany(MenuMethod::class,'permissions','role_id','menu_method_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class,'role_id');
    }

    public function comboBox()
    {
    	$model = $this
    		->select('id','role')
    		->pluck('role','id')
    		->toArray();

    	return [''=>'Select Role'] + $model;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use Admin;

class Menu extends Model
{
    public $fillable = ['slug','parent_slug','label','controller','order','is_active'];

    public function parent()
    {
    	return $this->belongsTo(Menu::class,'parent_slug','slug');
    }

    public function childs()
    {
    	return $this->hasMany(Menu::class,'parent_slug','slug');
    }
    
    public function methods()
    {
    	return $this->belongsToMany(\App\Models\Method::class,'menu_methods','menu_id','method_id')
            ->withPivot('id');
    }

    public function scopeGetParents($query)
    {
        return $query->where('parent_slug',null)
            ->orderBy('id','asc');
    }
}

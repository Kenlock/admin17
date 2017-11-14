<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuMethod extends Model
{
    public $fillable = ['method_id','menu_id'];

    public function menu()
    {
    	return $this->belongsTo(\App\Models\Menu::class,'menu_id');
    }

    public function method()
    {
    	return $this->belongsTo(\App\Models\Method::class,'method_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $guarded = [];

    public function scopeDeleteGroup($query,$group)
    {
       return $query->whereGroup($group)->delete();
    }

    public function scopeByGroup($query,$group)
    {
    	$model = $query
    		->select('key','value')
    		->whereGroup($group)
    		->get();
    	$result=[];
    	foreach($model as $row)
    	{
    		$result[$row->key]=$row->value;
    	}

    	return $result;
    }
}

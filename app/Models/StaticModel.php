<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticModel extends Model  {

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'statics';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['group', 'key', 'value', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public function getByGroup($group)
    {
        $model = $this->where('group',$group)
            ->get();

        $result = [];

        foreach($model as $row)
        {
            $result[$row->key] = isJson($row->value) == true ? json_decode($row->value) : $row->value;
        }

        return (object)$result;
    }

}
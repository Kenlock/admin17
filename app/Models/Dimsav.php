<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Dimsav\Translatable\Translatable;
use \Admin\Translation;

class Dimsav extends Model  {

    use Translatable,Translation;

    public $translatedAttributes = ['name'];
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dimsavs';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['order', 'status', 'created_at', 'updated_at'];

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

}
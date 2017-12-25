<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dimsav extends Model  {

    use \Dimsav\Translatable\Translatable;

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

    public function scopeDatatablesTranslations($query)
    {
        return $query->select('dimsavs.id', 'dimsav_translations.name', 'status', 'order')
            
            ->join('dimsav_translations', function ($join) {
            
                $join->on('dimsav_translations.dimsav_id', '=', 'dimsavs.id')
            
                    ->where('dimsav_translations.locale', 'en');
            
            })
            
            ->orderBy('order', 'asc');
    }

}
<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class Car
 * @package App\Models
 * @version December 6, 2019, 2:04 pm UTC
 *
 * @property string rendszam
 * @property string tipus
 * @property string motorszam
 * @property string alvazszam
 * @property string karbantarto
 * @property string hatter,
 * @property string kep
 * @property integer felhasznalo
  */
class Car extends Model
{
    use SoftDeletes;

    public $table = 'cars';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'rendszam',
        'tipus',
        'motorszam',
        'alvazszam',
        'karbantarto',
        'hatter',
        'kep',
        'felhasznalo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'rendszam' => 'string',
        'tipus' => 'string',
        'motorszam' => 'string',
        'alvazszam' => 'string',
        'karbantarto' => 'string',
        'hatter' => 'string',
        'kep' => 'string',
        'felhasznalo' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'rendszam' => 'required',
        'tipus' => 'required'
    ];

    public static function getCarFelhasznalo($id){
        $car = DB::table('cars')->where('id', '=', $id)->get();
        return $car[0]->felhasznalo;
    }

}

<?php

namespace App\Models;

use DB;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Account
 * @package App\Models
 * @version December 6, 2019, 5:01 pm UTC
 *
 * @property integer partner
 * @property string bizszam
 * @property string leiras
 */
class Account extends Model
{
    use SoftDeletes;

    public $table = 'accounts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'auto',
        'partner',
        'tipus',
        'bizszam',
        'datum',
        'osszeg',
        'leiras'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'auto' => 'integer',
        'tipus' => 'integer',
        'partner' => 'integer',
        'bizszam' => 'string',
        'datum' => 'date',
        'osszeg' => 'integer',
        'leiras' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'auto' => 'required',
        'partner' => 'required',
        'tipus' => 'required',
        'datum' => 'required',
        'osszeg' => 'required'
    ];

    public static function SzamlakIdoszak($kezdo, $veg, $db){
        $data = DB::table('accounts')
                ->join('cars', 'cars.id', '=', 'accounts.auto')
                ->join('costs', 'costs.id', '=', 'accounts.tipus')
                ->select('cars.rendszam as rendszam', 'costs.nev as ktg', 'accounts.*')
                ->whereBetween('datum', [$kezdo, $veg])
                ->whereNull('accounts.deleted_at')
                ->orderby('accounts.datum', 'desc')
                ->orderby('cars.rendszam')
                ->orderby('costs.nev')
                ->paginate($db);
        return $data;
   }
}

<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;


/**
 * Class Partner
 * @package App\Models
 * @version December 6, 2019, 3:44 pm UTC
 *
 * @property string nev
 * @property string leiras
 */
class Partner extends Model
{
    use SoftDeletes;

    public $table = 'partners';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'nev',
        'leiras'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nev' => 'string',
        'leiras' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nev' => 'required'
    ];

    public static function getParnerName($id){
        $partner = DB::table('partners')->where('id', '=', $id)->get();
        return $partner[0]->nev;
    }

}

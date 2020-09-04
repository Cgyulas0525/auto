<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;


/**
 * Class Cost
 * @package App\Models
 * @version December 6, 2019, 3:06 pm UTC
 *
 * @property string nev
 * @property string leiras
 */
class Cost extends Model
{
    use SoftDeletes;

    public $table = 'costs';

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

    public static function getCostName($id){
        $tipus = DB::table('costs')->where('id', '=', $id)->get();
        return $tipus[0]->nev;
    }


}

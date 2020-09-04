<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ioaccounts
 * @package App\Models
 * @version December 29, 2019, 8:32 am UTC
 *
 * @property integer partner
 * @property integer tipus
 * @property string datum
 * @property number osszeg
 * @property string leiras
 * @property integer io
 */
class Ioaccounts extends Model
{
    use SoftDeletes;

    public $table = 'ioaccounts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'partner',
        'tipus',
        'datum',
        'osszeg',
        'leiras',
        'io'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'partner' => 'integer',
        'tipus' => 'integer',
        'datum' => 'date',
        'osszeg' => 'float',
        'leiras' => 'string',
        'io' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'partner' => 'required',
        'tipus' => 'required',
        'datum' => 'required',
        'osszeg' => 'required'
    ];


}

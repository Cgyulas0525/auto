<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Document
 * @package App\Models
 * @version December 6, 2019, 4:24 pm UTC
 *
 * @property string nev
 * @property integer auto
 * @property integer tipus
 * @property integer partner
 * @property string leiras
 */
class Document extends Model
{
    use SoftDeletes;

    public $table = 'documents';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'nev',
        'auto',
        'tipus',
        'partner',
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
        'auto' => 'integer',
        'tipus' => 'integer',
        'partner' => 'integer',
        'leiras' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nev' => 'required',
        'auto' => 'required',
        'tipus' => 'required'
    ];

    
}

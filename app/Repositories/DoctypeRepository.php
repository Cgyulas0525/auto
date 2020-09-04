<?php

namespace App\Repositories;

use App\Models\Doctype;
use App\Repositories\BaseRepository;

/**
 * Class DoctypeRepository
 * @package App\Repositories
 * @version December 6, 2019, 3:57 pm UTC
*/

class DoctypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nev',
        'leiras'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Doctype::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\Ioaccounts;
use App\Repositories\BaseRepository;

/**
 * Class IoaccountsRepository
 * @package App\Repositories
 * @version December 29, 2019, 8:32 am UTC
*/

class IoaccountsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'partner',
        'tipus',
        'datum',
        'osszeg',
        'leiras',
        'io'
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
        return Ioaccounts::class;
    }
}

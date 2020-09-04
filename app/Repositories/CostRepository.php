<?php

namespace App\Repositories;

use App\Models\Cost;
use App\Repositories\BaseRepository;

/**
 * Class CostRepository
 * @package App\Repositories
 * @version December 6, 2019, 3:06 pm UTC
*/

class CostRepository extends BaseRepository
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
        return Cost::class;
    }
}

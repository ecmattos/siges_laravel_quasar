<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CompanySectorRepository;
use App\Entities\CompanySector;
use App\Validators\CompanySectorValidator;

/**
 * Class CompanySectorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CompanySectorRepositoryEloquent extends BaseRepository implements CompanySectorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CompanySector::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CompanySectorValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

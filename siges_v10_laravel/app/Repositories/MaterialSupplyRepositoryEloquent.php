<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MaterialSupplyRepository;
use App\Entities\MaterialSupply;
use App\Validators\MaterialSupplyValidator;
use App\Presenters\MaterialSupplyPresenter;

/**
 * Class MaterialSupplyRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MaterialSupplyRepositoryEloquent extends BaseRepository implements MaterialSupplyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MaterialSupply::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MaterialSupplyValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return MaterialSupplyPresenter::class;
    }
    
}

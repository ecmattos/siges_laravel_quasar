<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MeetingTypeRepository;
use App\Entities\MeetingType;
use App\Validators\MeetingTypeValidator;

/**
 * Class MeetingTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MeetingTypeRepositoryEloquent extends BaseRepository implements MeetingTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MeetingType::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MeetingTypeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MeetingRepository;
use App\Entities\Meeting;
use App\Validators\MeetingValidator;

/**
 * Class MeetingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MeetingRepositoryEloquent extends BaseRepository implements MeetingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Meeting::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MeetingValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

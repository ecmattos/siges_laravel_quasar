<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Warehouse.
 *
 * @package namespace App\Entities;
 */
class Warehouse extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = 'tenant';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description'
    ];

}
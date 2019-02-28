<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Provider.
 *
 * @package namespace App\Entities;
 */
class Provider extends Model implements Transformable
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
        'cpfcnpj',
        'name',
        'address',
        'zip_code',
        'neighborhood',
        'city',
        'state',
        'phone',
        'mobile',
        'email',
        'comments',
        'lat',
        'lng'
    ];
}

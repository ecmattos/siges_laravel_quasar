<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MaterialSupply.
 *
 * @package namespace App\Entities;
 */
class MaterialSupply extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = 'tenant';

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'material_id',
        'warehouse_id',
        'qty'
    ];

    public function materials()
    {
        return $this->belongsToMany('App\Entities\Material', 'material_supplies', 'warehouse_id', 'material_id');
    }
}

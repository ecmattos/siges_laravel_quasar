<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MaterialSupply;

/**
 * Class MaterialSupplyTransformer.
 *
 * @package namespace App\Transformers;
 */
class MaterialSupplyTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    protected $defaultIncludes = [
        'materials'
    ];
    
    /**
     * Transform the MaterialSupply entity.
     *
     * @param \App\Entities\MaterialSupply $model
     *
     * @return array
     */
    public function transform(MaterialSupply $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */
            'material_id' => $model->material_id,
            'warehouse_id' => $model->warehouse_id,
            'qty' => $model->qty,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeMaterials(MaterialUnit $material_unit)
    {
        return $this->collection($material_unit->materials, new MaterialTransformer);
    }
}

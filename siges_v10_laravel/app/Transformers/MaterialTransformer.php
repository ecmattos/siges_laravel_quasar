<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Material;

/**
 * Class MaterialTransformer.
 *
 * @package namespace App\Transformers;
 */
class MaterialTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    protected $defaultIncludes = [
        'material_unit',
        'material_supply'
    ];
    
    /**
     * Transform the Material entity.
     *
     * @param \App\Entities\Material $material
     *
     * @return array
     */
    public function transform(Material $model)
    {
        return [
            'id' => (int) $model->id,
            'material_code' => $model->code,
            'material_descripion' => $model->description,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeMaterialUnit(Material $model)
    {
        return $this->item($model->material_unit, new MaterialUnitTransformer());
    }

    public function includeMaterialSupply(Material $model)
    {
        return $this->item($model->material_supply, new MaterialSupplyTransformer());
    }
}

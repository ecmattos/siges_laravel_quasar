<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MaterialUnit;

/**
 * Class MaterialUnitTransformer.
 *
 * @package namespace App\Transformers;
 */
class MaterialUnitTransformer extends TransformerAbstract
{
    
    protected $availableIncludes = [
        'materials'
    ];

    protected $defaultIncludes = [];
    
    /**
     * Transform the MaterialUnit entity.
     *
     * @param \App\Entities\MaterialUnit $model
     *
     * @return array
     */
    public function transform(MaterialUnit $model)
    {
        return [
            'id' => (int) $model->id,

            'material_unit_code' => $model->code,
            'material_unit_description' => $model->description,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeMaterials(MaterialUnit $material_unit)
    {
        return $this->collection($material_unit->materials, new MaterialTransformer);
    }

}

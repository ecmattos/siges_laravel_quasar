<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CompanySector;

/**
 * Class CompanySectorTransformer.
 *
 * @package namespace App\Transformers;
 */
class CompanySectorTransformer extends TransformerAbstract
{
    /**
     * Transform the CompanySector entity.
     *
     * @param \App\Entities\CompanySector $model
     *
     * @return array
     */
    public function transform(CompanySector $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

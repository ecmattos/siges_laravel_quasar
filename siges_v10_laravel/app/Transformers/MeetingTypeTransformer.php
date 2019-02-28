<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MeetingType;

/**
 * Class MeetingTypeTransformer.
 *
 * @package namespace App\Transformers;
 */
class MeetingTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the MeetingType entity.
     *
     * @param \App\Entities\MeetingType $model
     *
     * @return array
     */
    public function transform(MeetingType $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

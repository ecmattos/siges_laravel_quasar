<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Meeting;

/**
 * Class MeetingTransformer.
 *
 * @package namespace App\Transformers;
 */
class MeetingTransformer extends TransformerAbstract
{
    /**
     * Transform the Meeting entity.
     *
     * @param \App\Entities\Meeting $model
     *
     * @return array
     */
    public function transform(Meeting $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

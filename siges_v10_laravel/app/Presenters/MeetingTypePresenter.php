<?php

namespace App\Presenters;

use App\Transformers\MeetingTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MeetingTypePresenter.
 *
 * @package namespace App\Presenters;
 */
class MeetingTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MeetingTypeTransformer();
    }
}

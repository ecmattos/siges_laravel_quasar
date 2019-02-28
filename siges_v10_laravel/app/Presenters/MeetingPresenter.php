<?php

namespace App\Presenters;

use App\Transformers\MeetingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MeetingPresenter.
 *
 * @package namespace App\Presenters;
 */
class MeetingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MeetingTransformer();
    }
}

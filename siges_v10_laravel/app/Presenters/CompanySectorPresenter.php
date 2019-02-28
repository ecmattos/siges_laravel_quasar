<?php

namespace App\Presenters;

use App\Transformers\CompanySectorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompanySectorPresenter.
 *
 * @package namespace App\Presenters;
 */
class CompanySectorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanySectorTransformer();
    }
}

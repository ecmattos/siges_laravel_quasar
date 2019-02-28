<?php

namespace App\Presenters;

use App\Transformers\MaterialSupplyTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MaterialSupplyPresenter.
 *
 * @package namespace App\Presenters;
 */
class MaterialSupplyPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MaterialSupplyTransformer();
    }
}

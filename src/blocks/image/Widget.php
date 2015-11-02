<?php
/**
 *
 */

namespace nullref\cms\blocks\image;

use nullref\cms\components\Widget as BaseWidget;
use yii\helpers\Html;


class Widget extends BaseWidget
{
    public $image;
    public $alt = '';
    public $width = 100;
    public $height = 100;

    public function run()
    {
        return
            Html::beginTag('img', [
                'src' => $this->image,
                'alt' => $this->alt,
                'width' => $this->width,
                'height' => $this->height,
            ]) .
            Html::endTag('img');
    }
}
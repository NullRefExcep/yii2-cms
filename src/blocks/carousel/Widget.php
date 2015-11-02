<?php
/**
 *
 */

namespace nullref\cms\blocks\carousel;

use nullref\cms\blocks\text\Widget as BaseWidget;
use yii\helpers\Html;
use sersid\owlcarousel\Asset;


class Widget extends BaseWidget
{
    public $carouselName;
    public function run()
    {
        Asset::register($this->view);
        $this->view->registerJs(<<<JS
            jQuery(function(){
                var selector = "."+"$this->carouselName";
                jQuery(selector).owlCarousel({
                    loop:true,
                    center: true,
                    margin:0,
                    nav:true,
                    items: 1
                });
            });
JS
       );

        return
            Html::beginTag($this->tag, ['class' => $this->tagClass]) .
                Html::beginTag('div', ['class' => $this->carouselName]) .
                    $this->content.
                Html::endTag('div') .
            Html::endTag($this->tag);
    }
}
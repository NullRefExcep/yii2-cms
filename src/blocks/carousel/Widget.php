<?php
/**
 *
 */

namespace nullref\cms\blocks\carousel;

use nullref\cms\blocks\text\Widget as BaseWidget;
use yii\helpers\Html;
use nullref\cms\assets\owlCarousel\OwlCarousel2;


class Widget extends BaseWidget
{
    public $sliderWrapperName;
    public $defaultSliderName;
    public $carouselId;
    public $sliderConfig;

    public function run()
    {
        OwlCarousel2::register($this->view);
        $this->view->registerJs(<<<JS
            jQuery(function(){
                var selector = "#"+"$this->carouselId";
                jQuery(selector).owlCarousel($this->sliderConfig);
            });
JS
        );

        return
            Html::beginTag($this->tag, ['class' => $this->sliderWrapperName]) .
                Html::beginTag('div', [
                    'class' => $this->defaultSliderName . ' owl-carousel',
                    'id' => $this->carouselId
                    ]) .
                    $this->content .
                Html::endTag('div') .
            Html::endTag($this->tag);
    }
}
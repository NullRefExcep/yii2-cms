<?php

namespace nullref\cms\blocks\carousel;

use nullref\cms\components\Block as BaseBlock;
/**
 * Class Block
 */
class Block extends BaseBlock
{
    public $content;
    public $sliderWrapperName = 'cms-slider-wrapper';
    public $defaultSliderName = 'cms-slider';
    public $carouselId = 'carousel-slider';

    public function getName()
    {
        return 'Carousel Block';
    }

    public function rules()
    {
        return [
            [['content','sliderWrapperName', 'defaultSliderName', 'carouselId'],'required'],
        ];
    }

}
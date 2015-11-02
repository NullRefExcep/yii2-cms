<?php

namespace nullref\cms\blocks\carousel;

use nullref\cms\components\Block as BaseBlock;
/**
 * Class Block
 */
class Block extends BaseBlock
{
    public $content;
    public $tag = 'div';
    public $tagClass = 'container';
    public $carouselName = 'cms-slider carousel-slider';

    public function getName()
    {
        return 'Carousel Block';
    }

    public function rules()
    {
        return [
            [['content','tag','tagClass', 'carouselName'],'required'],
        ];
    }

}
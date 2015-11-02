<?php

namespace nullref\cms\blocks\image;

use nullref\cms\components\Block as BaseBlock;
/**
 * Class Block
 */
class Block extends BaseBlock
{
    public $image;
    public $alt = '';
    public $width = 100;
    public $height = 100;

    public function getName()
    {
        return 'Image Block';
    }

    public function rules()
    {
        return [
            [['image','alt', 'width','height'],'required'],
        ];
    }
}
<?php

namespace nullref\cms\blocks\text;

use nullref\cms\components\Block as BaseBlock;

/**
 * Class Block
 */
class Block extends BaseBlock
{
    public $content;
    public $tag = 'div';
    public $tagClass = 'alert alert-success';

    public function getName()
    {
        return 'Text Block';
    }

    public function rules()
    {
        return [
            [['content', 'tag'], 'required'],
            [['tagClass'], 'string'],
        ];
    }
}
<?php

namespace nullref\cms\blocks\html;

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
        return 'HTML Block';
    }

    public function rules()
    {
        return [
            [['content', 'tag'], 'required'],
            [['tagClass'], 'string'],
        ];
    }

}
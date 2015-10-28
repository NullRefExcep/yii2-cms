<?php

namespace nullref\cms\blocks\text;

use nullref\cms\components\Block as BaseBlock;
/**
 * Class Block
 */
class Block extends BaseBlock
{
    public  $content;

    public function getName()
    {
        return 'Text Block';
    }

    public function rules()
    {
        return [
            [['content'],'required'],
        ];
    }


    public function getConfig()
    {
        return [
            'content'=>$this->content,
        ];
    }
}
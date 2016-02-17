<?php

namespace nullref\cms\blocks\text;

use nullref\cms\components\Block as BaseBlock;
use Yii;

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

    public function attributeLabels()
    {
        return [
            'content' => Yii::t('cms', 'Content'),
            'tag' => Yii::t('cms', 'Tag'),
            'tagClass' => Yii::t('cms', 'Tag class'),
        ];
    }

    public function rules()
    {
        return [
            [['content', 'tag'], 'required'],
            [['tagClass'], 'string'],
        ];
    }
}
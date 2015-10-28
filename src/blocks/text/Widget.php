<?php
/**
 *
 */

namespace nullref\cms\blocks\text;

use nullref\cms\components\Widget as BaseWidget;
use yii\helpers\Html;


class Widget extends BaseWidget
{
    public $content;
    public $tag = 'div';
    public $tagClass = 'alert alert-success';


    public function run()
    {
        return Html::tag($this->tag, $this->content,['class'=>$this->tagClass]);
    }
}
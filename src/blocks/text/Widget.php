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
    public $tag = '';
    public $tagClass = '';


    public function run()
    {
        if (!empty($this->tag)) {
            return Html::tag($this->tag, $this->content, empty($this->tagClass) ? [] : ['class' => $this->tagClass]);
        }
        return $this->content;
    }
}
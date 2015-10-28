<?php
/**
 *
 */

namespace nullref\cms\blocks\html;

use nullref\cms\components\Widget as BaseWidget;
use yii\helpers\Html;


class Widget extends BaseWidget
{
    public  $content;

    public function run()
    {
        return Html::encode($this->content);
    }
}
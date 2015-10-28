<?php
/**
 *
 */

namespace nullref\cms\blocks\html;

use nullref\cms\blocks\text\Widget as BaseWidget;
use yii\helpers\Html;


class Widget extends BaseWidget
{
    public function run()
    {
        return
            Html::beginTag($this->tag,['class'=>$this->tagClass]).
            Html::encode($this->content).
            Html::endTag($this->tag);
    }
}
<?php
/**
 *
 */

namespace nullref\cms\blocks;

use nullref\cms\blocks\text\Widget as BaseWidget;
use Yii;
use yii\helpers\Html;


class EmptyBlock extends BaseWidget
{
    public function run()
    {
        return Html::tag('span', Yii::t('cms', 'Block "{id}" not found', ['id' => $this->id]));
    }
}
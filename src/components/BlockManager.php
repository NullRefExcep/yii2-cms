<?php

namespace nullref\cms\components;

use nullref\cms\models\Block;
use yii\base\Component;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class BlockManager extends Component
{
    public function getList()
    {
        return [
            'text' => 'nullref\cms\blocks\text',
            'html' => 'nullref\cms\blocks\html',
        ];
    }

    public function getBlock($id)
    {
        return \Yii::createObject($this->getList()[$id].'\Block');
    }

    /**
     * @param $id
     * @param $config
     * @return Widget
     * @throws \yii\base\InvalidConfigException
     */
    public function getWidget($id, $config = [])
    {
        /** @var Block $block */
        $block = Block::find()->where(['class_name'=>$id])->one();
        $config = ArrayHelper::merge($config,$block->getData());
        $config['class'] = $this->getList()[$id].'\Widget';
        $widget = \Yii::createObject($config);
        return $widget;
    }

    public function getDropDownArray()
    {
        $list = [];
        foreach ($this->getList() as $id => $path) {
            /** @var \nullref\cms\components\Block $block */
            $block = \Yii::createObject($path.'\Block');
            $list[$id] = $block->getName();
        }
        return $list;
    }
}
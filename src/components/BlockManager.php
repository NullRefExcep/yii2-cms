<?php

namespace nullref\cms\components;

use nullref\cms\models\Block as BlockModel;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class BlockManager extends Component
{
    const CLASS_WIDGET = '\Widget';
    const CLASS_BLOCK = '\Block';

    protected $blocks = [];

    public function register($id, $namespace)
    {
        if (class_exists($namespace . self::CLASS_BLOCK) && class_exists($namespace . self::CLASS_WIDGET)) {
            $this->blocks[$id] = $namespace;
        } else {
            throw new InvalidConfigException("Classes Widget and Block must be present in namespace '$namespace'");
        }
    }

    public function getList()
    {
        return array_merge($this->blocks,[
            'text' => 'nullref\cms\blocks\text',
            'html' => 'nullref\cms\blocks\html',
        ]);
    }

    /**
     * @param $id
     * @return \nullref\cms\components\Block
     * @throws \yii\base\InvalidConfigException
     */
    public function getBlock($id)
    {
        return \Yii::createObject($this->getList()[$id] . self::CLASS_BLOCK);
    }

    /**
     * @param $id
     * @param $config
     * @return Widget
     * @throws \yii\base\InvalidConfigException
     */
    public function getWidget($id, $config = [])
    {
        /** @var BlockModel $block */
        $block = BlockModel::find()->where(['id' => $id])->one();
        $config = ArrayHelper::merge($config, $block->getData());
        $config['class'] = $this->getList()[$block->class_name] . self::CLASS_WIDGET;
        $widget = \Yii::createObject($config);
        return $widget;
    }

    public function getDropDownArray()
    {
        $list = [];
        foreach ($this->getList() as $id => $path) {
            /** @var \nullref\cms\components\Block $block */
            $block = \Yii::createObject($path . self::CLASS_BLOCK);
            $list[$id] = $block->getName();
        }
        return $list;
    }
}
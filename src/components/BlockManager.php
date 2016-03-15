<?php

namespace nullref\cms\components;

use nullref\cms\models\Block as BlockModel;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use Yii;

class BlockManager extends Component
{
    const CLASS_WIDGET = '\Widget';
    const CLASS_BLOCK = '\Block';

    public $blocks = [];

    public $emptyBlockClass = 'nullref\cms\blocks\EmptyBlock';

    protected $_blocks = [];

    /**
     * Register new block type
     *
     * @param $id
     * @param $namespace
     * @throws InvalidConfigException
     */
    public function register($id, $namespace)
    {
        if (class_exists($namespace . self::CLASS_BLOCK) && class_exists($namespace . self::CLASS_WIDGET)) {
            $this->_blocks[$id] = $namespace;
        } else {
            throw new InvalidConfigException("Classes Widget and Block must be present in namespace '$namespace'");
        }
    }

    /**
     * @param $id
     * @return \nullref\cms\components\Block
     * @throws \yii\base\InvalidConfigException
     */
    public function getBlock($id)
    {
        return Yii::createObject($this->getList()[$id] . self::CLASS_BLOCK);
    }

    public function getList()
    {
        return array_merge($this->blocks, $this->_blocks, [
            'text' => 'nullref\cms\blocks\text',
            'html' => 'nullref\cms\blocks\html',
            'php' => 'nullref\cms\blocks\php',
            'image' => 'nullref\cms\blocks\image',
            'carousel' => 'nullref\cms\blocks\carousel',
        ]);
    }

    /**
     * @param $id
     * @param $config
     * @return \nullref\cms\components\Widget
     * @throws \yii\base\InvalidConfigException
     */
    public function getWidget($id, $config = [])
    {
        /** @var BlockModel $block */
        $block = BlockModel::getDb()->cache(function () use ($id) {
            return BlockModel::find()->where(['id' => $id])->one();
        });
        if ($block) {
            $config = ArrayHelper::merge($config, $block->getData());
            $config['class'] = $this->getList()[$block->class_name] . self::CLASS_WIDGET;
        } else {
            $config = [
                'class' => $this->emptyBlockClass,
                'id' => $id,
            ];
        }
        $widget = Yii::createObject($config);
        return $widget;
    }

    /**
     * Get list for dropdown of possible block types
     * @return array
     * @throws InvalidConfigException
     */
    public function getDropDownArray()
    {
        $list = [];
        foreach ($this->getList() as $id => $path) {
            /** @var \nullref\cms\components\Block $block */
            $block = Yii::createObject($path . self::CLASS_BLOCK);
            $list[$id] = $block->getName();
        }
        return $list;
    }
}
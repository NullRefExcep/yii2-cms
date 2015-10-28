<?php

namespace nullref\cms\models;

use Yii;

/**
 * This is the model class for table "{{%cms_block}}".
 *
 * @property string $id
 * @property string $class_name
 * @property string $config
 * @property integer $createdAt
 * @property integer $updatedAt
 */
class Block extends \yii\db\ActiveRecord
{
    public $blockId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_block}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'blockId'], 'required'],
            [['config'], 'string'],
            [['createdAt', 'updatedAt'], 'integer'],
            [['id', 'class_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'class_name' => Yii::t('cms', 'Class Name'),
            'config' => Yii::t('cms', 'Config'),
            'createdAt' => Yii::t('cms', 'Created At'),
            'updatedAt' => Yii::t('cms', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return BlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlockQuery(get_called_class());
    }

    public function getData()
    {
        return unserialize($this->config);
    }

    public function setData(\nullref\cms\components\Block $block)
    {
        $this->config = serialize($block->getConfig());
        $this->class_name = $this->blockId;
    }
}

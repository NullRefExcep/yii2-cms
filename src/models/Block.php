<?php

namespace nullref\cms\models;

use nullref\cms\components\Widget;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use nullref\cms\components\Block as CMSBlock;

/**
 * This is the model class for table "{{%cms_block}}".
 *
 * @property string $id
 * @property string $class_name
 * @property string $config
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Page[] $pages
 */
class Block extends ActiveRecord
{
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
    public function behaviors()
    {
        return [
            'timestamp'=>[
                'class'=>TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'class_name'], 'required'],
            [['config'], 'string'],
            [['id'], 'unique'],
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
            'class_name' => Yii::t('cms', 'Block Type'),
            'config' => Yii::t('cms', 'Config'),
            'pages' => Yii::t('cms', 'Pages'),
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

    public function getTypeName()
    {
        return CMSBlock::getManager()->getBlock($this->class_name)->getName();
    }

    public function getData()
    {
        return unserialize($this->config);
    }

    public function setData(CMSBlock $block)
    {
        $this->config = serialize($block->getConfig());
    }

    public function getFullName()
    {
        return $this->id . ' ('.$this->getTypeName().')';
    }

    /**
     * @return Widget
     */
    public function getWidget()
    {
        return CMSBlock::getManager()->getWidget($this->id);
    }

    /**
     * @return $this
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(),['id'=>'page_id'])->viaTable(PageHasBlock::tableName(),['block_id'=>'id']);
    }
}

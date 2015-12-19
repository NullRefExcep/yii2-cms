<?php

namespace nullref\cms\models;

use nullref\cms\components\Block as CMSBlock;
use nullref\cms\components\Widget;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cms_block}}".
 *
 * @property string $id
 * @property string $name
 * @property string $class_name
 * @property string $config
 * @property integer $visibility
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Page[] $pages
 */
class Block extends ActiveRecord
{
    /**
     * Visibility levels
     */
    const VISIBILITY_PUBLIC = 1;
    const VISIBILITY_PROTECTED = 2;

    /**
     * @return array
     */
    public static function getVisibilityList()
    {
        return [
            self::VISIBILITY_PUBLIC => Yii::t('cms', 'Public visibility'),
            self::VISIBILITY_PROTECTED => Yii::t('cms', 'Protected visibility'),
        ];
    }

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
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'class_name', 'name'], 'required'],
            [['config'], 'string'],
            [['id'], 'unique'],
            [['visibility', 'created_at', 'updated_at'], 'integer'],
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
            'name' => Yii::t('cms', 'Block Name'),
            'config' => Yii::t('cms', 'Config'),
            'pages' => Yii::t('cms', 'Pages'),
            'visibility' => Yii::t('cms', 'Visibility'),
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
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

    /**
     * @return mixed
     */
    public function getTypeName()
    {
        return CMSBlock::getManager()->getBlock($this->class_name)->getName();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return unserialize($this->config);
    }

    /**
     * @param CMSBlock $block
     */
    public function setData(CMSBlock $block)
    {
        $this->config = serialize($block->getConfig());
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return empty($this->name) ? $this->id : $this->name;
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
        return $this->hasMany(Page::className(), ['id' => 'page_id'])->viaTable(PageHasBlock::tableName(), ['block_id' => 'id']);
    }

    public function isPublic()
    {
        return $this->visibility == self::VISIBILITY_PUBLIC;
    }
}

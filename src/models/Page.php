<?php

namespace nullref\cms\models;

use nullref\cms\components\RelatedBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cms_page}}".
 *
 * @property integer $id
 * @property string $route
 * @property string $title
 * @property string $layout
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 *
 * @property PageHasBlock[] $items
 * @property PageHasBlock[] $items_list
 *
 * @method loadWithRelations($data, $formName = null)
 */
class Page extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_page}}';
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
            ],
            'related' => [
                'class' => RelatedBehavior::className(),
                'fields' => [
                    'items' => PageHasBlock::className(),
                ]
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route', 'title', 'layout'], 'required'],
            [['createdAt', 'updatedAt'], 'integer'],
            [['route', 'title', 'layout'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'route' => Yii::t('cms', 'Route'),
            'title' => Yii::t('cms', 'Title'),
            'layout' => Yii::t('cms', 'Layout'),
            'createdAt' => Yii::t('cms', 'Created At'),
            'updatedAt' => Yii::t('cms', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(PageHasBlock::className(),['page_id'=>'id'])->orderBy(['order'=>SORT_ASC]);
    }
}

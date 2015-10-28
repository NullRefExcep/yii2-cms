<?php

namespace nullref\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%cms_page}}".
 *
 * @property integer $id
 * @property string $route
 * @property string $title
 * @property string $layout
 * @property integer $createdAt
 * @property integer $updatedAt
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_page}}';
    }

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
}

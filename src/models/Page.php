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
 * @property integer $created_at
 * @property integer $updated_at
 *
 *
 * @property string $layoutTitle
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
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
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
            [['created_at', 'updated_at'], 'integer'],
            [['route', 'title', 'layout'], 'string', 'max' => 255],
            [['layout'], 'validateAlias'],
        ];
    }

    /**
     * @param $attribute
     */
    public function validateAlias($attribute)
    {
        try {

            $path = Yii::getAlias($this->{$attribute});
            if (!(file_exists($path) || file_exists($path . '.php'))) {
                $this->addError($attribute, Yii::t('cms', 'Layout file must exist'));
            }
        } catch (\Exception $e) {
            $this->addError($attribute, $e->getMessage());
        }
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
            'created_at' => Yii::t('cms', 'Created At'),
            'updated_at' => Yii::t('cms', 'Updated At'),
        ];
    }

    /**
     * @return string
     */
    public function getLayoutTitle()
    {
        /** @var \nullref\cms\components\PageLayoutManager $layoutManager */
        $layoutManager = Yii::$app->getModule('cms')->get('layoutManager');
        return $layoutManager->getValue($this->layout);
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
        return $this->hasMany(PageHasBlock::className(), ['page_id' => 'id'])->orderBy(['order' => SORT_ASC]);
    }
}

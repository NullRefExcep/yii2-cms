<?php

namespace nullref\cms\models;

use nullref\useful\behaviors\RelatedBehavior;
use nullref\useful\traits\GetDefinition;
use nullref\useful\SerializeBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Command;
use yii\web\View;

/**
 * This is the model class for table "{{%cms_page}}".
 *
 * @property integer $id
 * @property string $route
 * @property string $title
 * @property string $layout
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $content
 * @property string $type
 * @property array $meta
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
    const TYPE_BLOCKS = 0;
    const TYPE_CONTENT = 1;

    use GetDefinition;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_page}}';
    }

    public static function getTypesMap()
    {
        return [
            self::TYPE_BLOCKS => Yii::t('cms', 'Block type'),
            self::TYPE_CONTENT => Yii::t('cms', 'Content type')
        ];
    }

    /**
     * @return array
     */
    public static function getMetaTypesList()
    {
        return [
            'title' => Yii::t('cms', 'Meta title'),
            'description' => Yii::t('cms', 'Meta description'),
            'keywords' => Yii::t('cms', 'Meta keywords'),
            'robots' => Yii::t('cms', 'Meta robots'),
        ];
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
                'filedSuffix' => '_list',
                'class' => RelatedBehavior::className(),
                'fields' => [
                    'items' => PageHasBlock::className(),
                ]
            ],
            'serialize' => [
                'class' => SerializeBehavior::className(),
                'fields' => ['meta'],
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
            [['created_at', 'updated_at', 'type'], 'integer'],
            [['route', 'title', 'layout'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['meta'], 'safe'],
            [['layout'], 'validateAlias'],
        ];
    }

    /**
     * Invalidate cache when update model
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) {
            $cmd = self::find()->byRoute($this->route)->createCommand();

            $cacheKey = [
                Command::className(),
                'fetch',
                null,
                self::getDb()->dsn,
                self::getDb()->username,
                $cmd->rawSql,
            ];
            Yii::$app->cache->delete($cacheKey);
        }
        parent::afterSave($insert, $changedAttributes);
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
            'content' => Yii::t('cms', 'Content'),
            'type' => Yii::t('cms', 'Type'),
            'meta' => Yii::t('cms', 'Meta Tags'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(PageHasBlock::className(), ['page_id' => 'id'])->orderBy(['order' => SORT_ASC]);
    }

    /**
     * @param View $view
     */
    public function registerMetaTags($view)
    {
        if (!empty($this->meta)) {
            foreach ($this->meta as $metaTag) {
                $view->registerMetaTag($metaTag);
            }
        }
    }
}

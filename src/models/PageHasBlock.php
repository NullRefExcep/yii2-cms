<?php

namespace nullref\cms\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cms_page_has_block}}".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $block_id
 * @property double $order
 *
 * @property Block $block
 */
class PageHasBlock extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_page_has_block}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id'], 'integer'],
            [['block_id', 'order'], 'required'],
            [['order'], 'number'],
            [['block_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'block_id' => 'Block ID',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::className(), ['id' => 'block_id']);
    }
}

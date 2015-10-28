<?php

namespace nullref\cms\models;

/**
 * This is the ActiveQuery class for [[Block]].
 *
 * @see Block
 */
class BlockQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Block[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Block|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
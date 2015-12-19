<?php

namespace nullref\cms\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Block]].
 *
 * @see Block
 */
class BlockQuery extends ActiveQuery
{
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

    public function visible()
    {
        return $this->where(['visibility' => Block::VISIBILITY_PUBLIC]);
    }
}
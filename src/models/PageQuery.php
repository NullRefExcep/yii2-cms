<?php

namespace nullref\cms\models;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Page]].
 *
 * @see Page
 */
class PageQuery extends ActiveQuery
{
    /**
     * Find by rout param
     * @param $route
     * @return $this
     */
    public function byRoute($route)
    {
        $this->andWhere(['route'=>$route]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return Page[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Page|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
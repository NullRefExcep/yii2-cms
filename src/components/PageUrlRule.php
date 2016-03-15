<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\cms\components;


use nullref\cms\models\Page;
use yii\web\UrlRule;

class PageUrlRule extends UrlRule
{
    public $pattern = '/<route:[_a-zA-Z0-9-/]+>';

    public $route = '/cms/page/view';

    public function parseRequest($manager, $request)
    {
        $result = parent::parseRequest($manager, $request);

        if (isset($result[1]) && $result[1]['route']) {
            $route = $result[1]['route'];

            $page = Page::getDb()->cache(function () use ($route) {
                return Page::find()->where(['route' => $route])->one();
            });

            if ($page) {
                return [$this->route, ['route' => $route]];
            }
        }
        return false;
    }

}
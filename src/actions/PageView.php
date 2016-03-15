<?php

namespace nullref\cms\actions;

use nullref\cms\models\Page;
use Yii;
use yii\base\Action;
use yii\caching\Cache;
use yii\web\NotFoundHttpException;


/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class PageView extends Action
{
    public $view = 'view';

    public $cachePrefix = 'cms.page.';

    public function run()
    {
        if (($route = Yii::$app->request->getQueryParam('route')) == null) {
            throw new NotFoundHttpException(Yii::t('cms', 'Page not found.'));
        }
        $page = Page::getDb()->cache(function () use ($route) {
            return Page::find()->byRoute($route)->one();
        });

        if (!isset($page)) {
            throw new NotFoundHttpException(Yii::t('cms', 'Page not found.'));
        }

        /** @var Cache $cache */
        $cache = Yii::$app->getCache();

        if (($result = $cache->get($this->cachePrefix . $route)) === false) {
            if ($page->layout) {
                $this->controller->layout = $page->layout;
            }
            if ($page->type == Page::TYPE_CONTENT) {
                $this->view = 'content-view';
            }
            $result = $this->controller->render($this->view, [
                'page' => $page,
            ]);
            $cache->set($this->cachePrefix . $route, $result);
        }

        return $result;
    }
}
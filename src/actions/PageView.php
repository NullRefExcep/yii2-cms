<?php

namespace nullref\cms\actions;

use nullref\cms\models\Page;
use Yii;
use yii\base\Action;
use yii\caching\TagDependency;
use yii\web\NotFoundHttpException;


/**
 * Class PageView
 * @package nullref\cms\actions
 *
 * Action for rendering cms pages
 *
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class PageView extends Action
{
    public $view = 'view';

    /**
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function run()
    {
        if (($route = Yii::$app->request->getQueryParam('route')) == null) {
            throw new NotFoundHttpException(Yii::t('cms', 'Page not found.'));
        }
        $page = Page::getDb()->cache(function () use ($route) {
            return Page::find()->byRoute($route)->one();
        }, null, new TagDependency(['tags' => 'cms.page.' . $route]));

        if (!isset($page)) {
            throw new NotFoundHttpException(Yii::t('cms', 'Page not found.'));
        }

        if ($page->layout) {
            $this->controller->layout = $page->layout;
        }
        if ($page->type == Page::TYPE_CONTENT) {
            $this->view = 'content-view';
        }
        $result = $this->controller->render($this->view, [
            'page' => $page,
        ]);

        //@TODO add tag dependency by blocks

        return $result;
    }
}

<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */

namespace nullref\cms\components;


use nullref\cms\models\Page;
use Yii;
use yii\base\ActionFilter;

class PageMetaTagsFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!Yii::$app->request->isAjax) {
            $url = '/' . Yii::$app->request->pathInfo;
            /** @var Page $page */
            $page = Page::find()->byRoute($url)->one();
            if ($page !== null) {
                $view = $action->controller->view;
                $page->registerMetaTags($view);
                $view->params['cms.page'] = $page;
            }
        }
        return parent::beforeAction($action);
    }
}

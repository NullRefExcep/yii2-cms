<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */

namespace nullref\cms\components;


use nullref\cms\models\Page;
use Yii;
use yii\base\ActionFilter;

/**
 * Class PageMetaTagsFilter
 *
 * Register meta tags based on cms page record
 *
 * @package nullref\cms\components
 */
class PageMetaTagsFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (!Yii::$app->request->isAjax) {
            /** Get current page url */
            $url = '/' . Yii::$app->request->pathInfo;
            /**
             * And try to find record by this url
             * @var Page $page
             */
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

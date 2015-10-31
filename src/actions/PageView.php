<?php

namespace nullref\cms\actions;

use nullref\cms\models\Page;
use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;


/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class PageView extends Action
{
    public $view = 'view';

    public function run()
    {
        if (($route = Yii::$app->request->getQueryParam('route')) == null) {
            throw new NotFoundHttpException(Yii::t('cms','Page not found.'));
        }
        $page = Page::find()->byRoute($route)->one();
        if (!isset($page)) {
            throw new NotFoundHttpException(Yii::t('cms','Page not found.'));
        }
        if ($page->layout){
            $this->controller->layout = $page->layout;
        }
        return $this->controller->render($this->view, [
            'page' => $page,
        ]);
    }
}
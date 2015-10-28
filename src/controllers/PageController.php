<?php

namespace nullref\cms\controllers;
use nullref\cms\models\Page;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * Class PageController
 */
class PageController extends Controller
{
    public function actionView($route)
    {
        $page = Page::find()->byRoute($route)->one();
        if (!isset($page)){
            throw new NotFoundHttpException();
        }
        return $this->render('view',[
            'page'=>$page,
        ]);
    }
}
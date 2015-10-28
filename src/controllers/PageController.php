<?php

namespace nullref\cms\controllers;
use yii\web\Controller;


/**
 * Class PageController
 */
class PageController extends Controller
{
    public function actionIndex($route)
    {
        return $route;
    }
}
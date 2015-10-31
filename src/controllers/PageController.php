<?php

namespace nullref\cms\controllers;

use nullref\cms\actions\PageView;
use yii\web\Controller;


/**
 * Class PageController
 */
class PageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'view' => [
                'class' => PageView::className(),
            ]
        ];
    }

}
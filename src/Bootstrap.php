<?php

namespace nullref\cms;


use yii\base\ActionEvent;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Controller;
use yii\base\Event;
use yii\web\ErrorAction;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $prefix = $app->getModule('cms')->urlPrefix;
        $app->urlManager->addRules([
            $prefix.'/<route:[a-zA-Z0-9-/]+>' => '/cms/page/view'
        ]);

        <?php

namespace nullref\cms;


use yii\base\ActionEvent;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Controller;
use yii\base\Event;
use yii\web\ErrorAction;
use yii\web\Application as WebApplication;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $prefix = $app->getModule('cms')->urlPrefix;
        $app->urlManager->addRules([
            $prefix . '/<route:[a-zA-Z0-9-/]+>' => '/cms/page/view'
        ]);

        if ($app instanceof WebApplication) {
            $app->controllerMap['elfinder-backend'] = [
                'class' => 'mihaildev\elfinder\Controller',
                'user' => 'admin',
                'access' => ['@'],
                'disabledCommands' => ['netmount'],
                'roots' => [
                    [
                        'path' => 'uploads',
                        'name' => 'Uploads'
                    ],
                ],
            ];
        }
    }

}

    }

}
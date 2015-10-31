<?php

namespace nullref\cms;


use yii\base\BootstrapInterface;
use yii\web\Application as WebApplication;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if ($app instanceof WebApplication) {
            $prefix = $app->getModule('cms')->urlPrefix;
            $app->urlManager->addRules([
                $prefix . '/<route:[a-zA-Z0-9-/]+>' => '/cms/page/view'
            ]);
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

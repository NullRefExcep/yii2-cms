<?php

namespace nullref\cms;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\i18n\PhpMessageSource;
use yii\gii\Module as Gii;
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

            $app->i18n->translations['cms*']=[
                'class' => PhpMessageSource::className(),
                'basePath' => '@nullref/cms/messages',
            ];
        }

        if (YII_ENV_DEV) {
            Event::on(Gii::className(), Gii::EVENT_BEFORE_ACTION, function (Event $event) {
                /** @var Gii $gii */
                $gii = $event->sender;
                $gii->generators['block-migration-generator'] = [
                    'class' => 'nullref\cms\generators\migration\Generator',
                ];
                $gii->generators['block-generator'] = [
                    'class' => 'nullref\cms\generators\block\Generator',
                ];
            });
        }
    }

}

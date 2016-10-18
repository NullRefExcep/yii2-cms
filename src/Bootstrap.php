<?php

namespace nullref\cms;

use nullref\cms\components\PageUrlRule;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\gii\Module as Gii;
use yii\i18n\PhpMessageSource;
use yii\web\Application as WebApplication;
use Yii;

class Bootstrap implements BootstrapInterface
{
    protected $classMap = [
        'Block' => 'nullref\cms\models\Block',
        'BlockQuery' => 'nullref\cms\models\BlockQuery',
        'Page' => 'nullref\cms\models\Page',
        'PageHasBlock' => 'nullref\cms\models\PageHasBlock',
        'PageQuery' => 'nullref\cms\models\PageQuery',
    ];

    public function bootstrap($app)
    {
        /** @var Module $module */
        if ($app->hasModule('cms') && ($module = $app->getModule('cms')) instanceof Module) {
            $classMap = array_merge($this->classMap, $module->classMap);
            foreach (array_keys($this->classMap) as $item) {
                $className = '\nullref\cms\models\\' . $item;
                $cmsClass = $className::className();
                $definition = $classMap[$item];
                Yii::$container->set($cmsClass, $definition);
            }
            if ($app instanceof WebApplication) {
                $prefix = $app->getModule('cms')->urlPrefix;
                $app->urlManager->addRules([Yii::createObject([
                    'class' => PageUrlRule::className(),
                    'pattern' => $prefix . '/<route:[_a-zA-Z0-9-/]+>',
                ])]);
                if (!isset($app->controllerMap['elfinder-backend'])) {
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

                $app->i18n->translations['cms*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => '@nullref/cms/messages',
                ];
            }
            if (YII_ENV_DEV) {
                Event::on(Gii::className(), Gii::EVENT_BEFORE_ACTION, function (Event $event) {
                    /** @var Gii $gii */
                    $gii = $event->sender;
                    $gii->generators['block-migration-generator'] = [
                        'class' => 'nullref\cms\generators\block_migration\Generator',
                    ];
                    $gii->generators['block-generator'] = [
                        'class' => 'nullref\cms\generators\block\Generator',
                    ];
                    $gii->generators['pages-migration-generator'] = [
                        'class' => 'nullref\cms\generators\pages_migration\Generator',
                    ];
                });
            }
        }
    }
}

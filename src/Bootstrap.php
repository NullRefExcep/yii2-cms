<?php

namespace nullref\cms;

use nullref\cms\components\PageUrlRule;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\i18n\PhpMessageSource;
use yii\web\Application as WebApplication;

class Bootstrap implements BootstrapInterface
{
    /**
     * Map of classes possible that could be override
     *
     * @var array
     */
    protected $classMap = [
        'Block' => 'nullref\cms\models\Block',
        'BlockQuery' => 'nullref\cms\models\BlockQuery',
        'Page' => 'nullref\cms\models\Page',
        'PageHasBlock' => 'nullref\cms\models\PageHasBlock',
        'PageQuery' => 'nullref\cms\models\PageQuery',
    ];

    /**
     * Check if application has cms module, if has:
     * - add module classes to application container
     * - add url rule for cms pages
     * - add elFinder controller
     * - add i18n for module
     * - add custom generators to gii
     *
     * @param \yii\base\Application $app
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        /** @var Module $module */
        if ($app->hasModule('cms') && ($module = $app->getModule('cms')) instanceof Module) {
            $classMap = array_merge($this->classMap, $module->classMap);
            foreach (array_keys($this->classMap) as $item) {
                $className = 'nullref\cms\models\\' . $item;
                $definition = $classMap[$item];
                Yii::$container->set($className, $definition);
            }

            if ($app instanceof WebApplication) {
                $prefix = $module->urlPrefix;
                $app->urlManager->addRules([Yii::createObject([
                    'class' => PageUrlRule::class,
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
                                'name' => 'Uploads',
                                'options' => [
                                    'attributes' => [
                                        [
                                            'pattern' => '/\.(?:gitignore)$/',
                                            'read' => false,
                                            'write' => false,
                                            'hidden' => true,
                                            'locked' => false
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ];
                }

                $app->i18n->translations['cms*'] = [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@nullref/cms/messages',
                ];
            }

            if ($app->hasModule('gii')) {
                Event::on(\yii\gii\Module::class, yii\gii\Module::EVENT_BEFORE_ACTION, function (Event $event) {
                    /** @var \yii\gii\Module $gii */
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

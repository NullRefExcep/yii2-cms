<?php

namespace nullref\cms;

use nullref\core\components\Module as BaseModule;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\InvalidConfigException;

/**
 * Class Module
 * @package nullref\blog
 */
class Module extends BaseModule implements IAdminModule
{
    public $urlPrefix = '/pages';

    public $fileControllerId = 'elfinder-backend';

    public $blockManagerClass = 'nullref\cms\components\BlockManager';

    public function init()
    {
        parent::init();

        $this->setComponents([
            'blockManager' => $this->blockManagerClass,
        ]);
    }

    public static function getFileControllerId()
    {
        /** @var $module Module */
        if (($module = Yii::$app->getModule('cms')) != null){
            return $module->fileControllerId;
        }
        return 'elfinder-backend';
    }

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('cms', 'CMS'),
            'icon' => 'columns',
            'items'=>[
                [
                    'label' => Yii::t('cms', 'Pages'),
                    'icon' => 'copy',
                    'url' => '/cms/admin/page',
                ],
                [
                    'label' => Yii::t('cms', 'Blocks'),
                    'icon' => 'clone',
                    'url' => '/cms/admin/block',
                ],
            ]
        ];
    }
} 
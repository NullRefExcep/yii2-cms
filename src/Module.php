<?php

namespace nullref\cms;

use nullref\core\components\Module as BaseModule;
use nullref\core\interfaces\IAdminModule;
use Yii;

/**
 * Class Module
 * @package nullref\blog
 */
class Module extends BaseModule implements IAdminModule
{
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('cms', 'CMS'),
            'icon' => 'archive',
            'items'=>[
                [
                    'label' => Yii::t('cms', 'Pages'),
                    'icon' => 'archive',
                    'url' => '/cms/admin/page',
                ],
                [
                    'label' => Yii::t('cms', 'Blocks'),
                    'icon' => 'archive',
                    'url' => '/cms/admin/block',
                ],
            ]
        ];
    }
} 
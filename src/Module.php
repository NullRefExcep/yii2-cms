<?php

namespace nullref\cms;

use nullref\cms\components\PageLayoutManager;
use nullref\core\components\Module as BaseModule;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Module
 * @package nullref\blog
 *
 *
 * @property PageLayoutManager $layoutManager
 *
 */
class Module extends BaseModule implements IAdminModule
{
    /**
     * Allow to override module classes
     * @var array
     */
    public $classMap = [];

    public $urlPrefix = '/pages';

    public function __construct($id, $parent = null, $config = [])
    {
        $config = ArrayHelper::merge([
            'components' => [
                'layoutManager' => [
                    'class' => '\nullref\cms\components\PageLayoutManager',
                ],
                'blockManager' => [
                    'class' => 'nullref\cms\components\BlockManager',
                ],
            ],
        ], $config);
        parent::__construct($id, $parent, $config);
    }

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('cms', 'CMS'),
            'icon' => 'columns',
            'order' => 2,
            'items' => [
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
                [
                    'label' => Yii::t('cms', 'Files'),
                    'icon' => 'files-o',
                    'url' => '/cms/admin/files',
                ],
            ]
        ];
    }
} 
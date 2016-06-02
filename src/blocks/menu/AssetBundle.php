<?php

namespace nullref\cms\blocks\menu;

use Yii;
use yii\web\AssetBundle as BaseBundle;


/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */
class AssetBundle extends BaseBundle
{
    public $sourcePath = '@nullref/cms/blocks/menu/assets/';

    public $js = [
        'scripts.js',
    ];
    public $css = [
        'styles.css',
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\jui\JuiAsset',
    ];

    public function init()
    {
        parent::init();
        Yii::$app->assetManager->bundles['wbraganca\fancytree\FancytreeAsset'] = [
            'skin' => 'dist/skin-bootstrap/ui.fancytree',
        ];
    }
}
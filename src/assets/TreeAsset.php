<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace nullref\cms\assets;

use yii\web\AssetBundle;

class TreeAsset extends AssetBundle
{
    public $sourcePath = '@nullref/cms/assets';
    public $js = [
        'js/main.js',
        'js/fancytree.js',
    ];
    public $css = [
        'css/fancytree.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

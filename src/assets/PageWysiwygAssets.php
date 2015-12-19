<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\cms\assets;


use yii\web\AssetBundle;

class PageWysiwygAssets extends AssetBundle
{
    public $sourcePath = '@nullref/cms/assets';
    public $js = [
        'js/page-wysiwyg.js',
    ];
    public $css = [
        'css/page-wysiwyg.css',
    ];
    public $depends = [
        'yii\jui\JuiAsset'
    ];
}
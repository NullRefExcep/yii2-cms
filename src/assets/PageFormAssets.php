<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\cms\assets;


use yii\web\AssetBundle;

class PageFormAssets extends AssetBundle
{
    public $sourcePath = '@nullref/cms/assets';
    public $js = [
        'js/page-form.js',
    ];
    public $css = [
        'css/page-form.css',
    ];
    public $depends = [
        'yii\jui\JuiAsset'
    ];
}
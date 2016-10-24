<?php

use nullref\cms\assets\TreeAsset;
use nullref\cms\generators\block_migration\Generator;
use rmrevin\yii\fontawesome\AssetBundle;
use wbraganca\fancytree\FancytreeWidget;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $generator Generator */

$this->registerAssetBundle(AssetBundle::className());
$this->registerAssetBundle(TreeAsset::className());

?>

<div class="migration-form">
    <?php

    echo $form->field($generator, 'path')->textInput();

    echo $form->beginField($generator, 'blocks');
    echo Html::activeLabel($generator, 'blocks');
    echo FancytreeWidget::widget([
        'id' => 'blocksTree',
        'options' => [
            'selectMode' => 3,
            'source' => Generator::getNestedList($generator->blocks),
            'checkbox' => true,
            'titlesTabbable' => true,
            'clickFolderMode' => 3,
            'init' => new JsExpression('app.initTree'),
            'select' => new JsExpression('app.selectTreeNode'),
            'extensions' => ["glyph", "edit", "wide"],
            'activeVisible' => true,
            'glyph' => [
                'map' => [
                    'doc' => "fa fa-file-o",
                    'docOpen' => "fa fa-file",
                    'checkbox' => "fa fa-square-o",
                    'checkboxSelected' => "fa fa-check-square-o",
                    'checkboxUnknown' => "fa fa-share",
                    'error' => "fa fa-warning-sign",
                    'expanderClosed' => "fa fa-plus-square-o",
                    'expanderLazy' => "fa fa-spinner fa-spin",
                    'expanderOpen' => "fa fa-minus-square-o",
                    'folder' => "fa fa-folder-o",
                    'folderOpen' => "fa fa-folder-open-o",
                    'loading' => "fa fa-refresh",
                ]
            ],
        ]
    ]);
    $form->endField();
    ?>
</div>
</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this \yii\web\View
 * @var $block \nullref\cms\components\Block
 */
$this->title = Yii::t('cms', 'Config Block ({name})', ['name' => $block->getName()]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-config">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?= $block->render() ?>

</div>

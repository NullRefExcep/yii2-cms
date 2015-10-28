<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Block */
/* @var $form yii\widgets\ActiveForm */
/** @var \nullref\cms\components\BlockManager $blockManager */
$blockManager = Yii::$app->getModule('cms')->get('blockManager');

?>

<div class="block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'blockId')->dropDownList($blockManager->getDropDownArray()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

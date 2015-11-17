<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nullref\cms\components\Block as CMSBlock;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Block */
/* @var $form yii\widgets\ActiveForm */
/** @var \nullref\cms\components\BlockManager $blockManager */

?>

<div class="block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
    <?php endif ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_name')->dropDownList(CMSBlock::getManager()->getDropDownArray(),['prompt'=>'']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

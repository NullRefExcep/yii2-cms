<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nullref\cms\components\Block as CMSBlock;
use nullref\cms\models\Block;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Block */
/* @var $form yii\widgets\ActiveForm */
/** @var \nullref\cms\components\BlockManager $blockManager */

?>

<div class="block-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?php if($model->isNewRecord): ?>
                <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
            <?php endif ?>

            <?= $form->field($model, 'class_name')->dropDownList(CMSBlock::getManager()->getDropDownArray(),['prompt'=>'']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'visibility')->dropDownList(Block::getVisibilityList()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

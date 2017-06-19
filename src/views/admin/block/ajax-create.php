<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Block */

$configUrl = Url::to(['/cms/admin/block/config']);
$this->registerJs(<<<JS
jQuery('#createBlockForm').on('beforeSubmit', function (e) {
    var form = jQuery(this);
    jQuery.ajax({
        url: form.attr('action'),
        method: 'post',
        data: form.serialize(),
        success: function () {
            jQuery.ajax('$configUrl').done(function (html) {
                form.parents('.modal-body').html(html);
            });
        }
    });
    e.preventDefault(e);
    return false;
});
JS
)
?>
<div class="block-create">

    <?php $form = ActiveForm::begin([
        'id' => 'createBlockForm',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'visibility')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'class_name')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

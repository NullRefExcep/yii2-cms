<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this \yii\web\View
 * @var $id string|null
 * @var $block \nullref\cms\components\Block
 */
$this->title = Yii::t('cms', 'Config Block ({name})', ['name' => $block->getName()]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isAjax = Yii::$app->request->isAjax;
if ($isAjax) {
    $this->registerJs(<<<JS
jQuery('#blockConfigForm').on('beforeSubmit', function (e) {
    var form = jQuery(this);
    jQuery.ajax({
        url: form.attr('action'),
        method: 'post',
        data: form.serialize(),
        success: function (data) {
            if (data.isNewRecord) {
                addBlock(data);
            }
            form.parents('.modal').modal('hide');
        }
    });
    e.preventDefault(e);
    return false;
});
JS
    );
}
?>
<div class="block-config">

    <?php if (!$isAjax): ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?= Html::encode($this->title) ?>
                </h1>
            </div>
        </div>
    <?php endif ?>


    <?php $form = ActiveForm::begin([
        'id' => 'blockConfigForm',
        'action' => ['/cms/admin/block/config', 'id' => $id],
    ]); ?>

    <?= $form->errorSummary($block) ?>

    <?= $this->renderFile($block->getForm(), ['form' => $form, 'block' => $block]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

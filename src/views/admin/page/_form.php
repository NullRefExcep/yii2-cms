<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use nullref\cms\assets\PageFormAssets;
use nullref\cms\models\Page;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Page */
/* @var $form yii\widgets\ActiveForm */

PageFormAssets::register($this);

$pageTypesMap = Page::getTypesMap();

/** @var \nullref\cms\components\PageLayoutManager $layoutManager */
$layoutManager = Yii::$app->getModule('cms')->get('layoutManager');
$this->registerJs(<<<JS
jQuery('.save-and-continue-edit').on('click', function (e) {
    var btn = jQuery(this);
    var form = btn.parents('form');
    form.attr('action', function(i, url) {
      return url + ( url.indexOf('?') >= 0 ? '&' : '?' ) + 'continue_edit=1';
    });
    form.submit();
    e.preventDefault(e);
    return false;
});

JS

);
?>
<div class="hide">
    <li class="list-group-item" id="pageItemTmpl">
        <button type="button"
                class="btn btn-danger btn-xs"
                data-action="remove-block"
                data-id="">
            <i class="fa fa-close"></i>
        </button>
        <input type="hidden" name="PageHasBlock[:id][block_id]" value=":block_id">
        <input type="hidden" name="PageHasBlock[:id][order]" value=":order">
        :name
        <i class="fa fa-bars pull-right"></i>
    </li>
</div>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'action' => ($model->isNewRecord ? ['/cms/admin/page/create'] : ['/cms/admin/page/update', 'id' => $model->id]),
        'encodeErrorSummary' => false,
    ]); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->errorSummary($model) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'layout')->dropDownList($layoutManager->getList()) ?>

            <?= $form->field($model, 'type')->dropDownList($pageTypesMap); ?>
        </div>

        <div id="editor-wrapper" class="col-md-9">

            <div class="row" data-type="<?= Page::TYPE_CONTENT ?>" style="display: none">
                <div class="col-md-12">
                    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
                        'editorOptions' => ElFinder::ckeditorOptions('elfinder-backend', [
                            'height' => 300,
                        ]),
                    ]) ?>
                </div>
            </div>

            <div class="row" data-type="<?= Page::TYPE_BLOCKS ?>" style="display: none">
                <?= $this->render('_blocks', [
                    'model' => $model,
                ]) ?>
            </div>

        </div>

        <div class="col-md-12">
            <h4><?= Yii::t('cms', 'Meta Tags') ?></h4>
            <?= $form->field($model, 'meta')->widget(MultipleInput::className(), [
                'columns' => [
                    [
                        'name' => 'name',
                        'title' => Yii::t('cms', 'Name'),
                        'type' => 'dropDownList',
                        'items' => call_user_func([Page::getDefinitionClass(), 'getMetaTypesList']),
                    ],
                    [
                        'name' => 'content',
                        'title' => Yii::t('cms', 'Content'),
                    ]
                ]
            ])->label(false) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::button(Yii::t('cms', 'Save and Continue Edit'), ['class' => 'btn btn-primary save-and-continue-edit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div class="modal fade" id="blockModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
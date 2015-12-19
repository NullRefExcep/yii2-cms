<?php

use nullref\cms\assets\PageFormAssets;
use nullref\cms\models\Block as BlockModel;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Page */
/* @var $form yii\widgets\ActiveForm */
/** @var BlockModel[] $blocks */
$blocks = BlockModel::find()->indexBy('id')->all();

PageFormAssets::register($this);


/** @var \nullref\cms\components\PageLayoutManager $layoutManager */
$layoutManager = Yii::$app->getModule('cms')->get('layoutManager');
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

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->errorSummary($model) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'layout')->dropDownList($layoutManager->getList()) ?>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Yii::t('cms', 'Page Content') ?>
                    <?= Html::a(FA::i(FA::_CLONE),['wysiwyg','id'=>$model->id],[
                        'class'=>'btn btn-xs btn-primary pull-right',
                        'target'=>'blank',
                    ]) ?>
                </div>
                <ul class="list-group page-items-list" id="pageItemsList">
                    <?php foreach ($model->items_list as $item): ?>
                        <li class="list-group-item">
                            <button type="button"
                                    class="btn btn-danger btn-xs"
                                    data-action="remove-block"
                                    data-id="">
                                <i class="fa fa-close"></i>
                            </button>
                            <?= Html::a(
                                FA::i(FA::_COG),
                                ['/cms/admin/block/update','id'=>$item->block_id,'page_id'=>$model->id],
                                ['class'=>'btn btn-xs btn-success']
                                ) ?>
                            <?php if($item->block): ?>
                                <i class="fa fa-<?= $item->block->isPublic()?FA::_EYE:FA::_EYE_SLASH ?>"></i>
                            <?php endif ?>

                            <input type="hidden" name="PageHasBlock[<?= $item->id ?>][block_id]"
                                   value="<?= $item->block_id ?>">
                            <input type="hidden" name="PageHasBlock[<?= $item->id ?>][order]"
                                   value="<?= $item->order ?>">
                            <?= $item->block ? $item->block->getFullName() : Yii::t('cms', 'Block "{id}" not found', ['id' => $item->block_id]) ?>
                            <i class="fa fa-bars pull-right"></i>
                        </li>
                    <?php endforeach ?>
                </ul>
                <?php if (!$model->isNewRecord): ?>
                    <div class="panel-footer">
                        <?= Html::a(Yii::t('cms', 'Add new block'), ['/cms/admin/block/create', 'page_id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
                    </div>
                <?php endif ?>

            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('cms', 'Available Blocks') ?></div>
                <ul class="list-group" id="blocksList">
                    <?php foreach ($blocks as $id => $block): ?>
                        <li class="list-group-item">
                            <button type="button"
                                    class="btn btn-primary btn-xs"
                                    data-action="add-block"
                                    data-id="<?= $id ?>"
                                    data-name="<?= $block->getFullName() ?>">
                                <i class="fa fa-plus"></i>
                            </button>
                            <?= $block->getFullName() ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>


        </div>

    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use nullref\cms\components\Block as BlockComponent;
use nullref\cms\models\Block as BlockModel;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Page */
/* @var BlockModel[] $blocks */
$blocks = BlockModel::find()->visible()->indexBy('id')->all();

$items = [];
foreach (BlockComponent::getManager()->getDropDownArray() as $key => $name) {
    $items[] = ['label' => $name, 'url' => ['/cms/admin/block/ajax-create', 'class_name' => $key], 'linkOptions' => [
        'class' => 'create-block-modal',
    ]];
}

$this->registerJs(<<<JS
jQuery('.create-block-modal').on('click', function (e) {
    var link = jQuery(this);
    var blockModal = jQuery('#blockModal');
    jQuery.ajax(link.attr('href')).done(function (html) {
        blockModal.find('.modal-body').html(html);
        blockModal.modal('show');
    });
    e.preventDefault(e);
    return false;
});
jQuery('body').on('click','.config-block-modal',function(e) {
    var link = jQuery(this);
    var blockModal = jQuery('#blockModal');
    jQuery.ajax(link.attr('href')).done(function (html) {
        blockModal.find('.modal-body').html(html);
        blockModal.modal('show');
    });
    e.preventDefault(e);
    return false;
});
JS
);
?>

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Yii::t('cms', 'Page Content') ?>

            <?= Html::a(FA::i(FA::_CLONE), ['wysiwyg', 'id' => $model->id], [
                'class' => 'btn btn-xs btn-primary pull-right',
                'target' => 'blank',
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
                        ['/cms/admin/block/config', 'id' => $item->block_id, 'page_id' => $model->id],
                        ['class' => 'btn btn-xs btn-success config-block-modal']
                    ) ?>

                    <?php if ($item->block): ?>
                        <i class="fa fa-<?= $item->block->isPublic() ? FA::_EYE : FA::_EYE_SLASH ?>"></i>
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
        <div class="panel-footer">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                <?= FA::i(FA::_PLUS) . ' ' . Yii::t('cms', 'Add new block') ?>
            </button>
            <?= Dropdown::widget([
                'items' => $items,
            ]);
            ?>
        </div>
    </div>
</div>

<div class="col-md-6">
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
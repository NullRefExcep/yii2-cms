<?php

use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use nullref\cms\models\Block as BlockModel;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Page */
/* @var BlockModel[] $blocks */
$blocks = BlockModel::find()->visible()->indexBy('id')->all();

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
                        ['/cms/admin/block/update', 'id' => $item->block_id, 'page_id' => $model->id],
                        ['class' => 'btn btn-xs btn-success']
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
        <?php if (!$model->isNewRecord): ?>
            <div class="panel-footer">
                <?= Html::a(Yii::t('cms', 'Add new block'), ['/cms/admin/block/create', 'page_id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
            </div>
        <?php endif ?>
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


<?php

use nullref\cms\blocks\EmptyBlock;
use nullref\cms\assets\PageWysiwygAssets;


/** @var $this \yii\web\View */
/** @var $model \nullref\cms\models\Page */

PageWysiwygAssets::register($this);
?>
<div class="page-wysiwyg" id="pageItemsList">
    <?php foreach ($model->items as $item): ?>
        <div class="page-block">
            <input type="hidden" name="PageHasBlock[<?= $item->id ?>][block_id]"
                   value="<?= $item->block_id ?>">
            <input type="hidden" name="PageHasBlock[<?= $item->id ?>][order]"
                   value="<?= $item->order ?>">
            <?php if ($item->block): ?>
                <?= $item->block->getWidget() ?>
            <?php else: ?>
                <?= EmptyBlock::widget(['id' => $item->block_id]) ?>
            <?php endif ?>
        </div>
    <?php endforeach ?>
</div>

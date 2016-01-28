<?php

use nullref\cms\blocks\EmptyBlock;

/** @var $this \yii\web\View */
/** @var $page \nullref\cms\models\Page */
$this->title = $page->title;
$page->registerMetaTags($this);
?>
<?php foreach ($page->items as $item): ?>
    <?php if ($item->block): ?>
        <?= $item->block->getWidget() ?>
    <?php else: ?>
        <?= EmptyBlock::widget(['id' => $item->block_id]) ?>
    <?php endif ?>
<?php endforeach ?>


<?php
/** @var $this \yii\web\View */
/** @var $page \nullref\cms\models\Page */
$this->title = $page->title;
?>
<?php foreach ($page->items as $item): ?>
        <?= $item->block->getWidget() ?>
<?php endforeach ?>


<?php

/** @var $this \yii\web\View */
/** @var $page \nullref\cms\models\Page */

$this->title = $page->title;
$page->registerMetaTags($this);

?>

<?= $page->content ?>

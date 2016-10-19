<?php
/**
 * @var $this \yii\web\View
 */
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;

$this->title = Yii::t('cms', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="files-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?= ElFinder::widget([
        'controller' => 'elfinder-backend',
        'frameOptions' => [
            'style' => 'min-height: 500px; width:100%',
        ]
    ]) ?>

</div>
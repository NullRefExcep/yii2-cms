<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Page */

$this->title = Yii::t('cms', 'Updating Page') . ' "' . $model->title . '"';
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms', 'Update');
?>
<div class="page-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('cms', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

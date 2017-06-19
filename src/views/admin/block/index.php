<?php

use nullref\cms\components\Block as BlockComponent;
use nullref\cms\models\Block;
use nullref\cms\models\Page;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel nullref\cms\models\BlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms', 'Blocks');
$this->params['breadcrumbs'][] = $this->title;
$items = [];
foreach (BlockComponent::getManager()->getDropDownArray() as $key => $name) {
    $items[] = ['label' => $name, 'url' => ['create', 'class_name' => $key]];
}
?>
<div class="block-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php if (Yii::$app->session->hasFlash('delete-is-not-allowed')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('delete-is-not-allowed') ?>
        </div>
    <?php endif ?>

    <p>
    <div class="btn-group">
        <?= Html::a(Yii::t('cms', 'Create Block'), ['create'], ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <?= Dropdown::widget([
            'items' => $items,
        ]);
        ?>
    </div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'filter' => BlockComponent::getManager()->getDropDownArray(),
                'attribute' => 'class_name',
                'value' => 'typeName'
            ],
            ['attribute' => 'created_at', 'format' => 'datetime', 'filter' => false],
            ['attribute' => 'updated_at', 'format' => 'datetime', 'filter' => false],
            [
                'attribute' => 'pages',
                'format' => 'html',
                'value' => function (Block $model) {
                    $names = ArrayHelper::getColumn($model->pages, function (Page $page) {
                        return Html::a($page->title, ['/cms/admin/page/update', 'id' => $page->id], ['class' => 'label label-primary']);
                    });
                    return implode(' ', $names);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {config} {delete}',
                'buttons' => [
                    'config' => function ($url, Block $model, $key) {
                        $options = [
                            'title' => Yii::t('cms', 'Config'),
                            'aria-label' => Yii::t('cms', 'Config'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-cog"></span>', $url, $options);
                    }
                ]
            ],
        ],
    ]); ?>

</div>

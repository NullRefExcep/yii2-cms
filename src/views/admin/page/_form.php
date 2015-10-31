<?php

use nullref\cms\models\Block as BlockModel;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\jui\JuiAsset;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model nullref\cms\models\Page */
/* @var $form yii\widgets\ActiveForm */
/** @var BlockModel[] $blocks */
$blocks = BlockModel::find()->indexBy('id')->all();
$blocksJson = Json::encode($blocks);
$itemsJson = Json::encode($model->items_list);

JuiAsset::register($this);
$this->registerJs(<<<JS
String.prototype.replaceAll = function (find, replace) {
    var str = this;
    return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
};
var pageItemsList = jQuery('#pageItemsList');
var pageItemTmpl = jQuery('#pageItemTmpl');
var blocksList = jQuery('#blocksList');
var itemsJson = $itemsJson;
var idCounter = 1;


blocksList.on('click','[data-action="add-block"]', function(e) {
  addBlock(jQuery(this).data());
  e.preventDefault(e);
  return false;
});

pageItemsList.on('click','[data-action="remove-block"]', function(e) {
  jQuery(this).parents('.list-group-item').remove();
  e.preventDefault(e);
  return false;
});


pageItemsList.sortable({
        stop: function () {
            pageItemsList.find('[name$="[order]"]').each(function(index) {
                jQuery(this).val(index);
            });
        }
});

pageItemsList.disableSelection();

function addBlock(data) {
    var item = pageItemTmpl.clone();
    item.removeAttr('id');
    var html = item.html()
    .replaceAll(':id','new_'+(idCounter++))
    .replaceAll(':block_id',data.id)
    .replaceAll(':name',data.name)
    .replaceAll(':order',pageItemsList.find('li').length);
    item.html(html);
    pageItemsList.append(item);
    pageItemsList.sortable( "refresh" );
}
JS
);

$this->registerCss(<<<CSS
.hint-block {
    font-size: 12px;
    padding: 2px;
    opacity: 0.7;
}

.hint-block:hover {
    opacity: 1;
}
CSS
);
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

            <?= $form->field($model, 'layout')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Page Content</div>
                <ul class="list-group" id="pageItemsList">
                    <?php foreach ($model->items_list as $item): ?>


                        <li class="list-group-item">
                            <button type="button"
                                    class="btn btn-danger btn-xs"
                                    data-action="remove-block"
                                    data-id="">
                                <i class="fa fa-close"></i>
                            </button>
                            <input type="hidden" name="PageHasBlock[<?= $item->id ?>][block_id]"
                                   value="<?= $item->block_id ?>">
                            <input type="hidden" name="PageHasBlock[<?= $item->id ?>][order]" value="<?= $item->order ?>">
                            <?= $item->block->getFullName() ?>
                            <i class="fa fa-bars pull-right"></i>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Available Blocks</div>
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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('cms', 'Create') : Yii::t('cms', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

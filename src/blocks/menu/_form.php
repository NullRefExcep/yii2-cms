<?php
/**
 * @var $block \nullref\cms\blocks\menu\Block
 * @var $this \yii\web\View
 * @var $form \yii\widgets\ActiveForm
 */
use app\components\Helper;
use nullref\cms\blocks\menu\AssetBundle;
use wbraganca\fancytree\FancytreeWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\Accordion;
use yii\web\JsExpression;

AssetBundle::register($this);

?>


<div class="row">
    <div class="col-md-6">
        <?= FancytreeWidget::widget([
            'id' => 'menuTree',
            'options' => [
                'titlesTabbable' => true,
                'activeVisible' => true,
                'autoCollapse' => true,
                'source' => new JsExpression($block->itemsJson),
                'checkbox' => false,
                'clickFolderMode' => 1,
                'extensions' => ['glyph', 'edit', 'wide', 'dnd'],
                'wide' => [
                    'levelOfs' => '20px',
                    'iconSpacing' => '0px',
                    'iconWidth' => '20px',
                ],
                'toggleEffect' => null,
                'glyph' => [
                    'map' => [
                        'doc' => ' ',
                        'docOpen' => ' ',
                        'checkbox' => 'fa fa-square-o',
                        'checkboxSelected' => 'fa fa-check-square-o',
                        'checkboxUnknown' => 'fa fa-share',
                        'error' => 'fa fa-warning-sign',
                        'expanderClosed' => 'fa fa-plus-square-o',
                        'expanderLazy' => 'fa fa-spinner fa-spin',
                        'expanderOpen' => 'fa fa-minus-square-o',
                        'folder' => 'fa fa-folder-o',
                        'folderOpen' => 'fa fa-folder-open-o',
                        'loading' => 'fa fa-refresh',
                    ]
                ],
                'dnd' => new JsExpression('app.menuTreeDnd'),
            ],
        ]) ?>

        <?= $form->field($block, 'itemsJson')->hiddenInput(['id' => 'itemsInput'])->label(false) ?>

        <button class="btn btn-success btn-sm" id="addItem">
            <i class="fa fa-plus-circle"></i> <?= Yii::t('cms', 'Add Menu Item') ?>
        </button>
    </div>
    <div class="col-md-6">
        <div id="nodeForm">
            <div class="form-group">
                <label for="titleInput"><?= Yii::t('cms', 'Title') ?></label>
                <input type="text"
                       class="form-control"
                       id="titleInput"
                       placeholder="<?= Yii::t('cms', 'Title') ?>">
            </div>
            <div class="form-group">
                <label for="urlInput"><?= Yii::t('cms', 'Url') ?></label>
                <input type="text"
                       class="form-control"
                       id="urlInput"
                       placeholder="<?= Yii::t('cms', 'Url') ?>">
            </div>
            <button class="btn btn-primary btn-sm" id="saveItem">
                <i class="fa fa-save"></i> <?= Yii::t('cms', 'Save') ?>
            </button>
            <button class="btn btn-danger btn-sm" id="removeItem">
                <i class="fa fa-trash"></i> <?= Yii::t('cms', 'Remove') ?>
            </button>
        </div>
        <hr/>
        <div>

            <?php $items = []; ?>
            <?php foreach ($block->getLinksList() as $type => $links): ?>
                <?php $items[] = [
                    'header' => $links['title'],
                    'content' => Html::tag('div', Html::checkboxList(
                        'Menu[' . $type . ']',
                        null,
                        ArrayHelper::map($links['list'], 'id', 'title'),
                        ['separator' => '<br/>',]
                    ), [
                        'data-type' => $type,
                        'class' => 'link-section',
                    ]),
                ] ?>
            <?php endforeach ?>

            <?php if (count($items)): ?>

                <?= Accordion::widget([
                    'id' => 'linkManger',
                    'items' => $items,
                    'options' => ['tag' => 'div'],
                    'itemOptions' => ['tag' => 'div'],
                    'headerOptions' => ['tag' => 'h3'],
                    'clientOptions' => [
                        'heightStyle' => 'content',
                    ],
                ]) ?>

                <button type="submit" class="btn btn-primary btn-sm" id="addSelectedItems">
                    <i class="fa fa-plus-circle"></i> <?= Yii::t('cms', 'Add Menu Item') ?>
                </button>

            <?php endif ?>

        </div>
    </div>
    <div class="col-md-12">

        <hr/>
    </div>


</div>


<?php

use mihaildev\ckeditor\CKEditor;
use yii\web\View;

/**
 * @var $form \yii\widgets\ActiveForm
 * @var $block \nullref\cms\blocks\html\Block
 * @var $this \yii\web\View
 */
list(, $footnotesUrl) = Yii::$app->assetManager->publish('@nullref/cms/assets/ckeditor-plugins/codemirror');
$this->registerJs("CKEDITOR.plugins.addExternal( 'codemirror', '" . $footnotesUrl . "/','plugin.js');", View::POS_END);


echo $form->field($block, 'content')->widget(CKEditor::className(), [
    'id' => 'editor',
    'editorOptions' => [
        'preset' => 'full',
        'inline' => false,
        'extraPlugins' => 'codemirror',
        'allowedContent' => true,
        'basicEntities' => false,
        'entities' => false,
        'entities_greek' => false,
        'entities_latin' => false,
        'htmlEncodeOutput' => false,
        'entities_processNumerical' => false,
        'fillEmptyBlocks' => false,
        'fullPage' => false,
        'codemirror' => [
            'autoCloseBrackets' => true,
            'autoCloseTags' => true,
            'autoFormatOnStart' => true,
            'autoFormatOnUncomment' => true,
            'continueComments' => true,
            'enableCodeFolding' => true,
            'enableCodeFormatting' => true,
            'enableSearchTools' => true,
            'highlightMatches' => true,
            'indentWithTabs' => false,
            'lineNumbers' => true,
            'lineWrapping' => true,
            'mode' => 'htmlmixed',
            'matchBrackets' => true,
            'matchTags' => true,
            'showAutoCompleteButton' => true,
            'showCommentButton' => true,
            'showFormatButton' => true,
            'showSearchButton' => true,
            'showTrailingSpace' => true,
            'showUncommentButton' => true,
            'styleActiveLine' => true,
            'theme' => 'default',
            'useBeautify' => true,
        ],
    ],
]);
echo $form->field($block, 'tag')->textInput();
echo $form->field($block, 'tagClass')->textInput();
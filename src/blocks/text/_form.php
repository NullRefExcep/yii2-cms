<?php
/**
 * @var $form \yii\widgets\ActiveForm
 * @var $block \nullref\cms\blocks\text\Block
 */

echo $form->field($block, 'content')->textarea(['rows' => 10]);
echo $form->field($block, 'tag')->textInput();
echo $form->field($block, 'tagClass')->textInput();
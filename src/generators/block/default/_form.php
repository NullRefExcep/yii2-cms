<?php

/**
 * @var $form \yii\widgets\ActiveForm
 * @var $block \nullref\cms\blocks\text\Block
 */

echo "<?php\n";
?>

/* Add nessesary fields like content below */
echo $form->field($block, 'content')->textarea();
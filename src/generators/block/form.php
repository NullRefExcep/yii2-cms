<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\module\Generator */
?>
<div class="migration-form">
    <?php
    echo $form->field($generator, 'blockName')->textInput();
    echo $form->field($generator, 'blockModel')->textInput();
    echo $form->field($generator, 'widgetModel')->textInput();
    echo $form->field($generator, 'destinationPath')->textInput();
    ?>
</div>

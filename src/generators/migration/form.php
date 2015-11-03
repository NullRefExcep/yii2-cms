<?php

use nullref\cms\generators\migration\Generator;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\module\Generator */
?>
<div class="migration-form">
    <?php
    echo $form->field($generator, 'block')->dropDownList(\yii\helpers\ArrayHelper::map(Generator::getBlocks(), 'id', 'id'));
    ?>
</div>

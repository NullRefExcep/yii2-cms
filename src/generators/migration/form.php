<?php

use nullref\cms\generators\migration\Generator;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $generator yii\gii\generators\module\Generator */
?>

<div class="migration-form">
    <?php

    echo $form->field($generator, 'path')->textInput();

    echo $form->field($generator, 'block')->dropDownList(ArrayHelper::map(Generator::getBlocks(), 'id', 'id'));
    ?>
</div>

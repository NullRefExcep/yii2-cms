<?php

use nullref\cms\generators\pages_migration\Generator;
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

    echo $form->field($generator, 'pages')->dropDownList(ArrayHelper::map(Generator::getPages(), 'id', 'route'), [
        'size' => 12,
        'multiple' => true,
    ]);

    ?>
</div>

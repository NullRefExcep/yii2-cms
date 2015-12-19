<?php

use mihaildev\elfinder\InputFile;

/**
 * @var $form \yii\widgets\ActiveForm
 * @var $block \nullref\cms\blocks\text\Block
 */

echo $form->field($block, 'image')->widget(InputFile::className(), [
    'language'      => 'ru',
    'controller'    => 'elfinder-backend', // ��������� �������� �����������, �� ��������� ����� elfinder
    'filter'        => 'image',    // ������ ������, ����� ������ ������ �������� https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    'options'       => ['class' => 'form-control'],
    'buttonOptions' => ['class' => 'btn btn-default'],
    'multiple'      => false       // ����������� ������ ���������� ������
]);
echo $form->field($block, 'alt')->textInput();
echo $form->field($block, 'width')->textInput();
echo $form->field($block, 'height')->textInput();
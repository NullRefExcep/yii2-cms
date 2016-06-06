<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
Yii::setAlias('@tests', __DIR__);
Yii::setAlias('@nullref/cms', __DIR__ . '/../src');
Yii::setAlias('@data', __DIR__ . DIRECTORY_SEPARATOR . '_data');
date_default_timezone_set('Europe/Kiev');
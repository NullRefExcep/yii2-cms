<?php

/**
 * @var $blockName string
 * @var $destination string
 * @var $widgetModel string
 */

echo "<?php\n";
?>

namespace <?= $destination ?>;

use <?= $widgetModel ?> as BaseWidget;
use yii\helpers\Html;


class Widget extends BaseWidget
{
public $content;

public function run()
{
return $this->content;
}
}
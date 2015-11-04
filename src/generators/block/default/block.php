<?php

/**
 * @var $blockName string
 * @var $destination string
 * @var $blockModel string
 */

echo "<?php\n";
?>

namespace <?= $destination ?>;

use <?= $blockModel ?> as BaseBlock;
/**
* Class Block
*/
class Block extends BaseBlock
{
public $content;

public function getName()
{
return '<?= $blockName ?> Block';
}

public function rules()
{
return [
[['content'],'required'],
];
}
}
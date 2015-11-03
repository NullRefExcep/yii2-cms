<?php

/**
 * @var $blockId string
 * @var $commands string
 */

echo "<?php\n";
?>

use yii\db\Migration;
use yii\db\Schema;
use nullref\cms\models\Block;

class <?= $name ?> extends Migration
{

public function up()
{
/** @var Block $existBlock */
$existBlock = Block::findOne(['id' => '<?= $blockId ?>']);
if( $existBlock ) {
$oldId = 'old_' . $existBlock->id;
$existBlock->id = $oldId;
$existBlock->save();
}
$this->insert(Block::tableName(), <?= $commands ?>);
}

public function down()
{
$this->delete(Block::tableName(), ['id' => '<?= $blockId ?>']);
/** @var Block $oldBlock */
$oldBlock = Block::findOne(['id' => 'old_<?= $blockId ?>']);
if( $oldBlock ) {
$oldBlock->id = '<?= $blockId ?>';
$oldBlock->save();
}
return true;
}

}

<?php

/**
 * @var $blocksToMigrate array
 */

echo "<?php\n";
?>

use yii\db\Migration;
use yii\db\Schema;
use nullref\cms\models\Block;

class <?= $name ?> extends Migration
{
public function safeUp()
{
/** @var Block $existBlock */
<?php foreach ($blocksToMigrate as $block): ?>

    $existBlock = Block::findOne(['id' => '<?= $block['blockId'] ?>']);
    if( $existBlock ) {
    $oldId = 'old_' . $existBlock->id;
    $existBlock->id = $oldId;
    $existBlock->save();
    }
    $this->insert(Block::tableName(), <?= $block['commands'] ?>);

<?php endforeach ?>

}

public function safeDown()
{
/** @var Block $oldBlock */
<?php foreach ($blocksToMigrate as $block): ?>

    $this->delete(Block::tableName(), ['id' => '<?= $block['blockId'] ?>']);

    $oldBlock = Block::findOne(['id' => 'old_<?= $block['blockId'] ?>']);
    if( $oldBlock ) {
    $oldBlock->id = '<?= $block['blockId'] ?>';
    $oldBlock->save();
    }

<?php endforeach ?>

return true;
}
}

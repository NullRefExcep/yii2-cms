<?php

/**
 * @var $pages array
 * @var $createdAt integer
 */


echo "<?php\n";
?>

use yii\db\Migration;
use yii\db\Schema;
use nullref\cms\models\Page;

class <?= $name ?> extends Migration
{
public function up()
{
<?php foreach ($pages as $page): ?>

    $this->insert(Page::tableName(), <?= $page['columns'] ?>);
<?php endforeach; ?>

}

public function down()
{
$this->delete(Page::tableName(), ['created_at' => <?= $createdAt ?>]);

return true;
}
}

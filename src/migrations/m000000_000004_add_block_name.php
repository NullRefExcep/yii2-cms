<?php

namespace nullref\cms\migrations;

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

class m000000_000004_add_block_name extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->addColumn('{{%cms_block}}', 'name', $this->string());
        $this->addColumn('{{%cms_block}}', 'visibility', $this->smallInteger());
    }

    public function down()
    {
        $this->dropColumn('{{%cms_block}}', 'name');
        $this->dropColumn('{{%cms_block}}', 'visibility');
        return true;
    }
}

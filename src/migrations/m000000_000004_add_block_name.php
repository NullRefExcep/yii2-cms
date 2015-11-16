<?php

use yii\db\Migration;
use yii\db\Schema;

class m000000_000004_add_block_name extends Migration
{
    use \nullref\core\traits\MigrationTrait;

    public function up()
    {
        $this->addColumn('{{%cms_block}}','name',Schema::TYPE_STRING);
        $this->addColumn('{{%cms_block}}','visibility',Schema::TYPE_SMALLINT);
    }

    public function down()
    {
        $this->dropColumn('{{%cms_block}}','name');
        $this->dropColumn('{{%cms_block}}','visibility');
        return true;
    }
}

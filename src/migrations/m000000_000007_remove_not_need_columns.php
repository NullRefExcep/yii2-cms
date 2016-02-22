<?php

use yii\db\Migration;
use yii\db\Schema;

class m000000_000007_remove_not_need_columns extends Migration
{
    use \nullref\core\traits\MigrationTrait;


    public function up()
    {
        if ($this->hasColumn('{{%cms_page_has_block}}', 'created_at')) {
            $this->dropColumn('{{%cms_page_has_block}}', 'created_at');
        }
        if ($this->hasColumn('{{%cms_page_has_block}}', 'updated_at')) {
            $this->dropColumn('{{%cms_page_has_block}}', 'updated_at');
        }

    }

    public function down()
    {
        if (!$this->hasColumn('{{%cms_page_has_block}}', 'created_at')) {
            $this->addColumn('{{%cms_page_has_block}}', 'created_at', $this->integer()->notNull());
        }
        if (!$this->hasColumn('{{%cms_page_has_block}}', 'updated_at')) {
            $this->addColumn('{{%cms_page_has_block}}', 'updated_at', $this->integer()->notNull());
        }

        return true;
    }
}

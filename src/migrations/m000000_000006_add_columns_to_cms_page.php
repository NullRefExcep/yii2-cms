<?php

use yii\db\Migration;

class m000000_000006_add_columns_to_cms_page extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%cms_page}}', 'content', $this->text());
        $this->addColumn('{{%cms_page}}', 'meta', $this->text());
        $this->addColumn('{{%cms_page}}', 'type', $this->smallInteger());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%cms_page}}', 'content');
        $this->dropColumn('{{%cms_page}}', 'meta');
        $this->dropColumn('{{%cms_page}}', 'type');
        return true;
    }
}

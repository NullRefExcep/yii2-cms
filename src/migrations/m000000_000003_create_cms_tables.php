<?php

use yii\db\Migration;
use yii\db\Schema;

class m000000_000003_create_cms_tables extends Migration
{
    use \nullref\core\traits\MigrationTrait;

    protected $tables = [
        'page' => '{{%cms_page}}',
        'block' => '{{%cms_block}}',
        'page_has_block' => '{{%cms_page_has_block}}',
    ];

    public function up()
    {
        foreach ($this->tables as $table) {
            if ($this->tableExist($table)) {
                $this->stdout("Table '{$table}' already exists\n");
                if ($this->confirm('Drop and create new?')) {
                    $this->dropTable($table);
                } else {
                    return true;
                }
            }
        }

        /**
         * Create page table
         */
        $this->createTable($this->tables['page'], [
            'id' => Schema::TYPE_PK,
            'route' => Schema::TYPE_STRING . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'layout' => Schema::TYPE_STRING . ' NOT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->getTableOptions());

        /**
         * Create block table
         */
        $this->createTable($this->tables['block'], [
            'id' => Schema::TYPE_STRING . ' NOT NULL',
            'class_name' => Schema::TYPE_STRING . ' NOT NULL',
            'config' => Schema::TYPE_TEXT,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->getTableOptions());

        $this->addPrimaryKey('block_PK', $this->tables['block'], 'id');
        /**
         * Create pageHasBlock table
         */
        $this->createTable($this->tables['page_has_block'], [
            'id' => Schema::TYPE_PK,
            'page_id' => Schema::TYPE_INTEGER,
            'block_id' => Schema::TYPE_STRING . ' NOT NULL',
            'order' => Schema::TYPE_FLOAT,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->getTableOptions());

    }

    public function down()
    {
        $this->dropTable($this->tables['page']);
        $this->dropPrimaryKey('block_PK', $this->tables['block']);
        $this->dropTable($this->tables['block']);
        $this->dropTable($this->tables['page_has_block']);

        return true;
    }
}

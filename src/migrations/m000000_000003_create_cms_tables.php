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
            'id' => $this->primaryKey(),
            'route' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'layout' => $this->string()->notNull(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
        ], $this->getTableOptions());

        /**
         * Create block table
         */
        $this->createTable($this->tables['block'], [
            'id' => $this->string()->notNull(),
            'class_name' => $this->string()->notNull(),
            'config' => $this->text(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
        ], $this->getTableOptions());

        $this->addPrimaryKey('block_PK', $this->tables['block'], 'id');
        /**
         * Create pageHasBlock table
         */
        $this->createTable($this->tables['page_has_block'], [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'block_id' => $this->string()->notNull(),
            'order' => $this->float(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
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

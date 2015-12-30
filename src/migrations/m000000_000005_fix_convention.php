<?php

use yii\db\Migration;
use yii\db\Schema;

class m000000_000005_fix_convention extends Migration
{
    use \nullref\core\traits\MigrationTrait;

    protected $tables = [
        'page' => '{{%cms_page}}',
        'block' => '{{%cms_block}}',
        'page_has_block' => '{{%cms_page_has_block}}',
    ];

    protected $columns = [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function safeUp()
    {
        foreach ($this->tables as $table) {
            foreach ($this->columns as $oldColumn => $newColumn) {
                if ($this->hasColumn($table, $oldColumn)) {
                    $this->renameColumn($table, $oldColumn, $newColumn);
                }
            }
        }
    }

    public function safeDown()
    {
        foreach ($this->tables as $table) {
            foreach ($this->columns as $oldColumn => $newColumn) {
                if ($this->hasColumn($table, $newColumn)) {
                    $this->renameColumn($table, $newColumn, $oldColumn);
                }
            }
        }
        return true;
    }
}

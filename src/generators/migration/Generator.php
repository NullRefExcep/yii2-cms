<?php

namespace nullref\cms\generators\migration;

use nullref\cms\models\Block;
use nullref\core\traits\VariableExportTrait;
use Yii;
use yii\gii\CodeFile;
use yii\gii\Generator as BaseGenerator;


class Generator extends BaseGenerator
{
    use VariableExportTrait;

    public $path;

    public $block;

    public static function getBlocks()
    {
        return Block::find()->all();
    }


    public function generate()
    {
        /** @var Block $selectedBlock */
        $selectedBlock = Block::find()->where(['id' => $this->block])->one();
        $time = new \DateTime();
        $time = $time->getTimestamp();

        $resultConfig = 'serialize(' . $this->varExport(unserialize($selectedBlock->config)) . ')';

        $offset = "\n\t\t\t";
        $commands = "[{$offset}'id' => '$selectedBlock->id'," .
            "{$offset}'class_name' => '$selectedBlock->class_name'," .
            "{$offset}'name' => '$selectedBlock->name'," .
            "{$offset}'visibility' => '$selectedBlock->visibility'," .
            "{$offset}'config' => $resultConfig," .
            "{$offset}'created_at' => $time," .
            "{$offset}'updated_at' => $time,{$offset}]";

        $files = [];
        $name = 'm' . gmdate('ymd_Hi') . '00_block_' . str_replace('-', '_', $selectedBlock->id);
        $code = $this->render('migration.php', [
            'name' => $name,
            'blockId' => $selectedBlock->id,
            'commands' => $commands,
        ]);
        $files[] = new CodeFile(
            Yii::getAlias($this->path) . '/' . $name . '.php',
            $code
        );
        return $files;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['block', 'path'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Block Migration Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a migration for block';
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'path' => 'Specify the directory for storing the migration for your  block. You may use path alias here, e.g.,
                <code>@app/migrations</code>'
        ]);
    }

}
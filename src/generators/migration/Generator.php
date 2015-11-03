<?php

namespace nullref\cms\generators\migration;

use Yii;
use nullref\cms\models\Block;
use yii\gii\CodeFile;
use yii\gii\Generator as BaseGenerator;


class Generator extends BaseGenerator
{

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
        $commands = "['id' => '$selectedBlock->id'," .
            "'class_name' => '$selectedBlock->class_name'," .
            "'config' => '{$selectedBlock->config}'," .
            "'createdAt' => $time," .
            "'updatedAt' => $time,]";

        $files = [];
        $name = 'm' . gmdate('ymd_Hi') . '00_block_' . $selectedBlock->id;
        $code = $this->render('migration.php', [
            'name' => $name,
            'blockId' => $selectedBlock->id,
            'commands' => $commands,
        ]);
        $files[] = new CodeFile(
            Yii::getAlias('@app/migrations') . '/' . $name . '.php',
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
            [['block'], 'required'],
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

}
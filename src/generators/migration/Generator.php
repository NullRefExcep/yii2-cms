<?php

namespace nullref\cms\generators\migration;

use nullref\cms\models\Block;
use nullref\core\traits\VariableExportTrait;
use Yii;
use yii\gii\CodeFile;
use yii\gii\Generator as BaseGenerator;
use yii\helpers\ArrayHelper;

class Generator extends BaseGenerator
{
    use VariableExportTrait;

    public $path = '@app/migrations';

    public $blocks;

    public function generate()
    {
        $blockIds = self::getBlockIds($this->blocks);

        /** @var Block[] $selectedBlocks */
        $selectedBlocks = Block::find()->where(['id' => $blockIds])->all();

        $name = 'm' . gmdate('ymd_Hi') . '00_blocks_' . count($selectedBlocks);

        $time = new \DateTime();
        $time = $time->getTimestamp();

        $blocksToMigrate = [];

        foreach ($selectedBlocks as $key => $selectedBlock) {
            $resultConfig = 'serialize(' . $this->varExport(unserialize($selectedBlock->config)) . ')';
            $time += $key;
            $offset = "\n\t\t\t";
            $commands = "[{$offset}'id' => '$selectedBlock->id'," .
                "{$offset}'class_name' => '$selectedBlock->class_name'," .
                "{$offset}'name' => '$selectedBlock->name'," .
                "{$offset}'visibility' => '$selectedBlock->visibility'," .
                "{$offset}'config' => $resultConfig," .
                "{$offset}'created_at' => $time," .
                "{$offset}'updated_at' => $time,{$offset}]";

            $blocksToMigrate[$key] = [
                'blockId' => $selectedBlock->id,
                'commands' => $commands,
            ];
        }
        $files = [];

        $code = $this->render('migration.php', [
            'name' => $name,
            'blocksToMigrate' => $blocksToMigrate,
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
            [['blocks', 'path'], 'required'],
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

    public static function getBlocks()
    {
        return Block::find()->all();
    }

    public static function getBlockIds($blocks)
    {
        $blockIds = [];
        $blockTypes = [];

        foreach ($blocks as $block) {
            $typePosition = strpos($block, '-type');
            if ($typePosition) {
                array_push($blockTypes, substr($block, 0, $typePosition));
            } else {
                array_push($blockIds, $block);
            }
        }
        $otherIds = Block::find()->select(['id'])->where(['class_name' => $blockTypes])->column();

        return ArrayHelper::merge($blockIds, $otherIds);
    }

    public static function getNestedList($blockIds)
    {
        if (!empty($blockIds)) {
            $blockIds = self::getBlockIds($blockIds);
        }

        $blocks = Block::find()->orderBy(['id' => SORT_ASC])->orderBy(['class_name' => SORT_ASC])->asArray()->all();

        $key = -1;
        $names = [];
        $result = [];
        foreach ($blocks as $block) {
            $name = $block['class_name'];
            if (!in_array($name, $names)) {
                $groupName = $name;
                $key++;
                array_push($names, $name);

                $result[$key] = [
                    'title' => $groupName,
                    'key' => $groupName . '-type',
                    'selected' => false,
                    'folder' => true,
                    'children' => [],
                    'expanded' => true,
                ];
            }

            $selected = false;
            if (!empty($blockIds)) {
                $selected = (in_array($block['id'], $blockIds)) ? true : false;
            }

            $block = [
                'title' => $block['id'],
                'key' => $block['id'],
                'selected' => $selected
            ];
            $result[$key]['children'][] = $block;

        }
        return $result;
    }

}
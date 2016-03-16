<?php

namespace nullref\cms\generators\pages_migration;

use nullref\cms\models\Page;
use nullref\core\traits\VariableExportTrait;
use Yii;
use yii\gii\CodeFile;
use yii\gii\Generator as BaseGenerator;


class Generator extends BaseGenerator
{
    use VariableExportTrait;

    public $path = '@app/migrations';

    public $pages;

    public static function getPages()
    {
        return Page::find()->all();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'CMS Pages Migration Generator';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['pages', 'path'], 'required'],
        ];
    }

    public function generate()
    {
        $selectedPages = Page::find()->where(['id' => $this->pages])->all();
        $time = (new \DateTime())->getTimestamp();
        $pages = [];
        foreach ($selectedPages as $page) {
            $meta = serialize($page->meta);
            $offset = "\n\t\t\t";

            $columns = "[{$offset}'route' => '$page->route'," .
                "{$offset}'title' => '$page->title'," .
                "{$offset}'layout' => '$page->layout'," .
                "{$offset}'content' => '$page->content'," .
                "{$offset}'type' => $page->type," .
                "{$offset}'meta' => '$meta'," .
                "{$offset}'created_at' => $time," .
                "{$offset}'updated_at' => $time,{$offset}]";

            $pages[] = ['columns' => $columns];
        }

        $files = [];
        $name = 'm' . gmdate('ymd_Hi') . '00_insert_cms_pages';
        $code = $this->render('migration.php', [
            'name' => $name,
            'pages' => $pages,
            'createdAt' => $time,
        ]);
        $files[] = new CodeFile(
            Yii::getAlias($this->path) . '/' . $name . '.php',
            $code
        );

        return $files;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a migration for pages';
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'path' => 'Specify the directory for storing the migration for your  block. You may use path alias here, e.g.,
                <code>@app/migrations</code>',
            'pages' => 'Select pages for which you want to generate migration. You may select multiple pages.'
        ]);
    }

}
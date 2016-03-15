Content Management Module for Yii2
====================
[![Latest Stable Version](https://poser.pugx.org/nullref/yii2-cms/v/stable)](https://packagist.org/packages/nullref/yii2-cms) [![Total Downloads](https://poser.pugx.org/nullref/yii2-cms/downloads)](https://packagist.org/packages/nullref/yii2-cms) [![Latest Unstable Version](https://poser.pugx.org/nullref/yii2-cms/v/unstable)](https://packagist.org/packages/nullref/yii2-cms) [![License](https://poser.pugx.org/nullref/yii2-cms/license)](https://packagist.org/packages/nullref/yii2-cms)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nullref/yii2-cms "*"
```

or add

```
"nullref/yii2-cms": "*"
```

to the require section of your `composer.json` file.

Run command `php yii module/install cms` to install this module. It will be added to your application config (`@app/config/installed_modules.php`)

Concept
-------

This module allows you to build dynamic pages which consist of blocks (widget with config).
You can create custom widgets and register it in BlockManager.

Also you can create pages with html content by WYSIWYG [CKEditor](https://github.com/MihailDev/yii2-ckeditor).


BlockManager
------------

This component contains information about available blocks.
You can override it:

```php
    'cms' => [
        'class' => 'nullref\\cms\\Module',
        'components' => [
            'blockManager' => 'app\components\BlockManager',
        ]
    ],
```

and add in your class own blocks:

```php
class BlockManager extends BaseBlockManager
{
    public function getList()
    {
        return array_merge([
            'smile' => 'app\blocks\smile', //namespace of block files
        ], parent::getList());
    }
}
```

To register block at runtime:

```php
    Block::getManager()->register('smile','app\blocks\smile');
    //or
    Yii::$app->getModule($moduleId)->get('blockManager')->register('smile','app\blocks\smile');
```



Block structure convention
--------------------------

A valid block is represented by a folder with two classes:

- Block - define data block to use
- Widget - run with data when this block use on page

In most cases form file will also be in this folder

When you add own block you have to set unique id and namespace of block files folder.


Single block usage
------------------

You can use cms blocks on you own views, to call by id:

```php
use nullref\cms\components\Block;
?>
<div class="site-index">
    <?= Block::getBlock('hello')->run() ?>
    or
    <?= Block::getBlock('hello2') //block has override method __toString() ?>
</div>
```


Pages
-----

This module allows to create pages with custom content and set custom url for it.
By default all pages are available by route `/pages/<route>`, but you can override it by config:
```php
/** module config **/
'cms' => [
    'class' => 'nullref\cms\Module',
    'urlPrefix' => '', //make empty prefix
],
```

By default you can set meta tags for each page.
Default tags are:

- title
- description
- keywords
- robots

You can override method `getMetaTypesList` in Page model class ([see below](#overriding)) to extend it.


Overriding
--------

- Models and ActiveQueries:
```php
/** module config **/
'cms' => [
    'classMap' => [
        'Block' => 'app\models\cms\Block',
        'BlockQuery' => 'app\models\cms\BlockQuery',
        'Page' => 'app\models\cms\Page',
        'PageHasBlock' => 'app\models\cms\PageHasBlock',
        'PageQuery' => 'app\models\cms\PageQuery',
    ],
],
```

- [Translations](https://github.com/NullRefExcep/yii2-core#translation-overriding):
```php
[
 /** App config **/
 'components' => [
  'i18n' => [
      'translations' => [
          '*' => ['class' => 'yii\i18n\PhpMessageSource'],
          'cms' => ['class' => 'nullref\core\components\i18n\PhpMessageSource'],
      ],
  ],
 ]
]
```
- [Views](http://www.yiiframework.com/doc-2.0/yii-base-theme.html#$pathMap-detail):

```php
/** App config **/
'components' => [
    'view' => [
        'theme' => [
            'pathMap' => [
                '@nullref/cms/views' => '@app/views/cms'
            ],
        ],
    ],
],
```
- [Controllers](http://www.yiiframework.com/doc-2.0/guide-structure-controllers.html):

```php
/** module config **/
'cms' => [
    'class' => 'nullref\cms\Module',
    'controllerNamespace' => 'app\modules\cms\controllers',
    'controllerMap' => [
        // declares "page" controller using a class name
        'page' => 'app\controllers\PageController',
    ],
],
```

Admin Panel
----------------------------

You can use this module with [Yii2 Admin](https://github.com/NullRefExcep/yii2-admin) module.

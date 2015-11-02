Content Management Module for Yii2
====================
Content Management Module for Yii2

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


BlockManager
------------

This component contains information about available blocks.
You can override it:

```php
    'cms' => [
        'class' => 'nullref\\cms\\Module',
        'blockManagerClass' => 'app\components\BlockManager',
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



Admin Panel
----------------------------

You can use this module with [Yii2 Admin](https://github.com/NullRefExcep/yii2-admin) module.

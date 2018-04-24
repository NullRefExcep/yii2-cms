<?php

namespace nullref\cms\components;


use yii\base\Model;
use yii\base\Widget;

abstract class Block extends Model
{
    public $id;

    public $formFile = '_form.php';

    /**
     * @param $blockId
     * @param array $config
     * @param string $moduleId
     * @return Widget
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function getBlock($blockId, $config = [], $moduleId = 'cms')
    {
        return self::getManager($moduleId)->getWidget($blockId, $config);
    }

    /**
     * @param string $moduleId
     * @return null|BlockManager
     */
    public static function getManager($moduleId = 'cms')
    {
        return \Yii::$app->getModule($moduleId)->get('blockManager');
    }

    /**
     * Return name of block
     * @return mixed
     */
    public abstract function getName();

    /**
     * Return path to form class
     * @return bool|string
     */
    public function getForm()
    {
        return realpath($this->getDir() . '/' . $this->formFile);
    }

    /**
     * Get path to directory with block classes
     * @return string
     */
    protected function getDir()
    {
        $reflector = new \ReflectionClass(get_class($this));
        return dirname($reflector->getFileName());
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->getAttributes(null, ['formFile']);
    }
}
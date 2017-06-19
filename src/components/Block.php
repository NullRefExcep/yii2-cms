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
     */
    public static function getBlock($blockId, $config = [], $moduleId = 'cms')
    {
        return self::getManager($moduleId)->getWidget($blockId, $config);
    }

    /**
     * @param string $moduleId
     * @return BlockManager
     */
    public static function getManager($moduleId = 'cms')
    {
        return \Yii::$app->getModule($moduleId)->get('blockManager');
    }

    public abstract function getName();

    public function getForm()
    {
        return realpath($this->getDir() . '/' . $this->formFile);
    }

    protected function getDir()
    {
        $reflector = new \ReflectionClass(get_class($this));
        return dirname($reflector->getFileName());
    }

    public function getConfig()
    {
        return $this->getAttributes(null, ['formFile']);
    }
}
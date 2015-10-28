<?php

namespace nullref\cms\components;


use yii\base\Model;
use yii\base\Widget;

abstract class Block extends Model
{
    public $form = '_form.php';

    public abstract function getName();

    protected function getDir() {
        $reflector = new \ReflectionClass(get_class($this));
        return dirname($reflector->getFileName());
    }

    public function getForm()
    {
        return realpath($this->getDir().'/'.$this->form);
    }

    public abstract function getConfig();
}
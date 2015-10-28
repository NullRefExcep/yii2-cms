<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\cms\components;


use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class RelatedBehavior extends Behavior
{
    /** @var array */
    public $fields = [];

    /** @var string */
    public $filedSuffix = '_list';

    /** @var string */
    public $newKeyPrefix = 'new_';

    /** @var ActiveRecord[][] */
    protected $_newValues = [];
    /** @var ActiveRecord[][] */
    protected $_editedValues = [];
    /** @var ActiveRecord[][] */
    protected $_removedValues = [];


    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate()
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        foreach ($this->fields as $name => $class) {
            $originalName = $name . $this->filedSuffix;
            foreach ($this->_newValues[$originalName] as $model) {
                if (!$model->validate()){
                    $owner->addErrors(['items'=>$model->getErrors()]);
                    return false;
                }
            }
            foreach ($this->_editedValues[$originalName] as $model) {
                if (!$model->validate()){
                    $owner->addErrors(['items'=>$model->getErrors()]);
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * @param $data
     * @param null $formName
     * @return bool
     */
    public function loadWithRelations($data, $formName = null)
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        foreach ($this->fields as $name => $class) {
            $reflection = new \ReflectionClass($class);
            $relatedFormName = $reflection->getShortName();
            if (isset($data[$relatedFormName])) {
                $models = [];
                foreach ($data[$relatedFormName] as $key => $item) {
                    $models[$key] = new $class(array_merge($item, ['id' => $key]));
                }
                $owner->{$name . $this->filedSuffix} = ($models);
            }
        }

        return $owner->load($data, $formName);
    }

    /**
     * @param string $name
     * @param bool|true $checkVars
     * @return bool
     */
    public function canSetProperty($name, $checkVars = true)
    {
        $originalName = str_replace($this->filedSuffix, '', $name);
        if (isset($this->fields[$originalName])) {
            return true;
        }
        return parent::canSetProperty($name, $checkVars);
    }

    /**
     * @param string $name
     * @param bool|true $checkVars
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true)
    {
        $originalName = str_replace($this->filedSuffix, '', $name);
        if (isset($this->fields[$originalName])) {
            return true;
        }
        return parent::canGetProperty($name, $checkVars);
    }

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
        foreach ($this->fields as $name => $class) {
            $this->_newValues[$name . $this->filedSuffix] = [];
            $this->_removedValues[$name . $this->filedSuffix] = [];
            $this->_editedValues[$name . $this->filedSuffix] = [];
            if (!class_exists($class)) {
                throw new InvalidConfigException("Class $class doesn't exist");
            }
        }

        parent::init();
    }

    /**
     * @param string $name
     * @return mixed|\yii\db\ActiveRecord[]
     * @throws \yii\base\UnknownPropertyException
     */
    public function __get($name)
    {
        $originalName = str_replace($this->filedSuffix, '', $name);
        if (isset($this->fields[$originalName])) {
            /** @var ActiveRecord $owner */
            $owner = $this->owner;
            if ($owner->isNewRecord) {
                return $this->_newValues[$name];
            }
            return $owner->{$originalName};
        }
        return parent::__get($name);
    }

    /**
     * @param string $name
     * @param mixed $models
     * @throws \yii\base\UnknownPropertyException
     */
    public function __set($name, $models)
    {
        $originalName = str_replace($this->filedSuffix, '', $name);
        if (isset($this->fields[$originalName])) {
            /** @var ActiveRecord $owner */
            $owner = $this->owner;
            if ($owner->isNewRecord) {
                $this->_newValues[$name] = $models;
            } else {
                $storedValues = $owner->getRelation($originalName)->indexBy('id')->all();
                foreach ($models as $key => $model) {
                    /** @var $model ActiveRecord */
                    if (substr($key, 0, strlen($this->newKeyPrefix)) == $this->newKeyPrefix) {
                        $this->_newValues[$name][] = $model;
                    } else {
                        $this->_editedValues[$name][$key] = $storedValues[$key];
                        $this->_editedValues[$name][$key]->setAttributes($model->getAttributes());
                    }
                }
                $this->_removedValues[$name] = array_diff_key($storedValues, $this->_editedValues[$name]);
                $this->_editedValues[$name] = array_diff_key($this->_editedValues[$name], $this->_removedValues[$name]);
            }
        } else {
            parent::__set($name, $models);
        }
    }

    /**
     * @throws \Exception
     */
    public function afterSave()
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        foreach ($this->fields as $name => $class) {
            $originalName = $name . $this->filedSuffix;
            foreach ($this->_newValues[$originalName] as $model) {
                $owner->link($name, $model);
            }
            foreach ($this->_editedValues[$originalName] as $model) {
                $owner->link($name, $model);
            }
            foreach ($this->_removedValues[$originalName] as $model) {
                $model->delete();
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function afterDelete()
    {
        foreach ($this->fields as $name => $class) {
            $originalName = $name . $this->filedSuffix;
            foreach ($this->{$originalName} as $model) {
                $model->delete();
            }
        }
    }

}
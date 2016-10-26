<?php

namespace nullref\cms\components;


use Yii;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Class Block
 * @package nullref\cms\components
 *
 * @property $formFile string
 */
abstract class Block extends Model
{
    public $id;

    protected $_formFile = '_form.php';

    protected $_view;

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

    /**
     * @return string
     */
    public function getFormFile()
    {
        return $this->_formFile;
    }

    /**
     * @param string $formFile
     */
    public function setFormFile($formFile)
    {
        $this->_formFile = $formFile;
    }

    public abstract function getName();

    public function getConfig()
    {
        return $this->getAttributes(null, ['formFile']);
    }

    public function render()
    {
        ob_start();
        $form = ActiveForm::begin();

        echo $form->errorSummary($this);

        echo $this->renderFormFile($form, $this);

        echo Html::tag('div', Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-primary']), ['class' => 'form-group']);

        ActiveForm::end();

        return ob_get_clean();
    }

    public function renderFormFile($form, $model)
    {
        return $this->getView()->renderFile($this->getForm(), ['form' => $form, 'block' => $model]);
    }

    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::$app->getView();
        }
        return $this->_view;
    }

    public function getForm()
    {
        return realpath($this->getDir() . '/' . $this->getFormFile());
    }

    protected function getDir()
    {
        $reflector = new \ReflectionClass(get_class($this));
        return dirname($reflector->getFileName());
    }
}
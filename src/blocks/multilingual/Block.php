<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */

namespace nullref\cms\blocks\multilingual;

use nullref\cms\components\Block as BaseBlock;
use nullref\core\interfaces\ILanguage;
use nullref\core\interfaces\ILanguageManager;
use nullref\core\widgets\Multilingual;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\validators\Validator;
use yii\widgets\ActiveForm;

/**
 * Class Block
 * @package nullref\cms\blocks\multilingual
 */
abstract class Block extends BaseBlock
{
    /** @var  ILanguage[] */
    public $languages = [];

    /**
     * @var array
     */
    protected $_languagesMap = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if (!count($this->languages)) {
            /** @var ILanguageManager $languageManager */
            $languageManager = Yii::$app->get('languageManager');
            $this->languages = $languageManager->getLanguages();
        }
        $this->_languagesMap = [];
        foreach ($this->languages as $language) {
            $this->_languagesMap[$language->getSlug()] = $language;
        }
        $languages = array_keys($this->_languagesMap);
        foreach ($this->getMultilingualAttributes() as $attribute) {
            $default = $this->{$attribute};
            $newValue = array_combine($languages, array_fill(0, count($languages), $default));
            $this->{$attribute} = $newValue;
        }

        $this->prepareValidators();
    }

    /**
     * @return array
     */
    public abstract function getMultilingualAttributes();

    /**
     * @inheritDoc
     */
    protected function prepareValidators()
    {
        $rules = $this->rules();
        $validators = $this->getValidators();

        $newValidators = [];

        $safeAttributes = [];
        foreach ($rules as $rule) {
            if ($rule instanceof Validator) {
                $rule_attributes = (array)$rule->attributes[0];
                $safeAttributes = array_merge($safeAttributes, $rule_attributes);
                $rule->attributes = $this->populateAttributes($rule_attributes);
                $newValidators[] = $rule;
            } elseif (is_array($rule) && isset($rule[0], $rule[1])) {
                $attributes = (array)$rule[0];
                $safeAttributes = array_merge($safeAttributes, $attributes);
                $validator = Validator::createValidator($rule[1], $this, $this->populateAttributes($attributes), array_slice($rule, 2));
                $newValidators[] = $validator;
            } else {
                throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
            }
        }

        $newValidators[] = Validator::createValidator('safe', $this, array_unique($safeAttributes));

        $validators->exchangeArray($newValidators);

    }

    /**
     * @param $rule_attributes
     *
     * @return mixed
     */
    protected function populateAttributes($rule_attributes)
    {
        $languages = array_keys($this->_languagesMap);
        $multiLanguageAttrs = $this->getMultilingualAttributes();
        return array_reduce($rule_attributes, function ($rule_attributes, $attribute) use ($languages, $multiLanguageAttrs) {
            if (in_array($attribute, $multiLanguageAttrs)) {
                return array_merge($rule_attributes, array_map(function ($language) use ($attribute) {
                    return $attribute . '_' . $language;
                }, $languages));
            } else {
                return array_merge($rule_attributes, [$attribute]);
            }
        }, []);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->getAttributes(null, ['languages', 'formFile']);
    }

    /**
     * @return string
     */
    public function render()
    {
        ob_start();
        $form = ActiveForm::begin();

        echo $form->errorSummary($this);

        echo Multilingual::widget([
            'languages' => $this->languages,
            'model' => $this,
            'tab' => [$this, 'renderFormFile'],
        ]);


        echo Html::tag('div', Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-primary']), ['class' => 'form-group']);

        ActiveForm::end();

        return ob_get_clean();
    }

    /**
     * @param null $attributeNames
     * @param bool $clearErrors
     *
     * @return mixed
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        return parent::validate($attributeNames, $clearErrors);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        foreach ($this->_languagesMap as $key => $languages) {
            if (substr($name, -3) === '_' . $key) {
                $attr = substr($name, 0, strlen($name) - 3);
                return $this->{$attr}[$key];
            }
        }
        return parent::__get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        foreach ($this->_languagesMap as $key => $languages) {
            if (substr($name, -3) === '_' . $key) {
                $attr = substr($name, 0, strlen($name) - 3);
                $this->{$attr}[$key] = $value;
                return;
            }
        }
        parent::__set($name, $value);
        return;
    }

    /**
     * @param $name
     * @param bool $checkVars
     * @param bool $checkBehaviors
     *
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true, $checkBehaviors = true)
    {
        foreach ($this->_languagesMap as $key => $languages) {
            if (substr($name, -3) === '_' . $key) {
                $attr = substr($name, 0, strlen($name) - 3);
                return property_exists($this, $attr);
            }
        }
        return parent::canGetProperty($name, $checkVars, $checkBehaviors);
    }
}

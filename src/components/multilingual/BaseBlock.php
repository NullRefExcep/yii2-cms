<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2017 NRE
 */

namespace nullref\cms\components\multilingual;

use nullref\cms\components\Block as CmsBlock;
use nullref\core\interfaces\ILanguage;
use nullref\core\interfaces\ILanguageManager;
use Yii;
use yii\base\InvalidConfigException;
use yii\validators\Validator;

/**
 * Class BaseBlock
 * @package nullref\cms\components\multilingual
 */
abstract class BaseBlock extends CmsBlock
{
    /** @var  ILanguage[] */
    public $languages = [];

    /** @var  ILanguageManager */
    protected $languageManager;
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
            $this->_languagesMap = [
                'default' => $languageManager->getLanguage(),
            ];
        }
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
     * @return mixed
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
     * @param $ruleAttributes
     *
     * @return array
     */
    protected function populateAttributes($ruleAttributes)
    {
        $attributes = array_intersect($ruleAttributes, $this->getMultilingualAttributes());

        $singleAttributes = array_diff($ruleAttributes, $this->getMultilingualAttributes());

        $languages = array_diff(array_keys($this->_languagesMap), ['default']);

        return array_merge($singleAttributes, array_reduce($attributes, function ($ruleAttributes, $attribute) use ($languages) {
            return array_merge($ruleAttributes, array_map(function ($language) use ($attribute) {
                return $attribute . '_' . $language;
            }, $languages));
        }, []));
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->getAttributes(null, ['languages', 'formFile']);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        foreach ($this->_languagesMap as $key => $languages) {
            $keyLen = strlen($key);
            if (substr($name, -($keyLen + 1)) === '_' . $key) {
                $attr = substr($name, 0, strlen($name) - $keyLen - 1);
                if (isset($this->{$attr}[$key])) {
                    return $this->{$attr}[$key];
                }
                if ($key !== 'default') {
                    if (isset($this->{$attr}['default'])) {
                        return $this->{$attr}['default'];
                    }
                    if (!is_array($this->{$attr})) {
                        return $this->{$attr};
                    }
                }
                return null;
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
            $keyLen = strlen($key);
            if (substr($name, -($keyLen + 1)) === '_' . $key) {
                $attr = substr($name, 0, strlen($name) - $keyLen - 1);
                if (!is_array($this->{$attr})) {
                    $this->{$attr} = [
                        'default' => $this->{$attr},
                    ];
                }
                $this->{$attr}[$key] = $value;
                if (empty($this->{$attr}['default'])) {
                    $this->{$attr}['default'] = $value;
                }
                return;
            }
        }
        parent::__set($name, $value);
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
            $keyLen = strlen($key);
            if (substr($name, -($keyLen + 1)) === '_' . $key) {
                $attr = substr($name, 0, strlen($name) - $keyLen - 1);
                return property_exists($this, $attr);
            }
        }
        return parent::canGetProperty($name, $checkVars, $checkBehaviors);
    }
}

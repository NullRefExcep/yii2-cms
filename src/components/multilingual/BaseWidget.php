<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2017 NRE
 */


namespace nullref\cms\components\multilingual;

use nullref\cms\components\Widget as CmsWidget;
use nullref\core\interfaces\ILanguageManager;
use Yii;

class BaseWidget extends CmsWidget
{
    public $blocks;

    /** @var  ILanguageManager */
    protected $languageManager;

    public function init()
    {
        $this->languageManager = Yii::$app->get('languageManager');
        parent::init();
    }
}

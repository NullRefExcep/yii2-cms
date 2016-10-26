<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\cms\blocks\multilingual;

use nullref\cms\components\Widget as BaseWidget;
use nullref\core\interfaces\ILanguageManager;
use Yii;


class Widget extends BaseWidget
{
    /** @var  ILanguageManager */
    protected $languageManager;

    public function init()
    {
        $this->languageManager = Yii::$app->get('languageManager');
        parent::init();
    }

}
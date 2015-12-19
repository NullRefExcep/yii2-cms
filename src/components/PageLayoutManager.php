<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */

namespace nullref\cms\components;


use nullref\core\interfaces\IList;
use Yii;
use yii\base\Component;

/**
 * Class PageLayoutManager
 * @package nullref\cms\components
 *
 * @property $list array
 */
class PageLayoutManager extends Component implements IList
{
    protected $_list = [];

    public function setList($value)
    {
        if ($value instanceof \Closure){
            $value = call_user_func($value);
        }
        $this->_list = $value;
    }

    public function getList()
    {
        return $this->_list;
    }

    public function init()
    {
        parent::init();

        if (empty($this->_list)) {
            $this->_list = [
                '@nullref/cms/views/layouts/clear' => Yii::t('cms', 'Base layout'),
            ];
        }
    }

    public function getValue($key)
    {
        return isset($this->_list[$key]) ? ($this->_list[$key]) : Yii::t('cms', 'N/A');
    }


}
<?php
/**
 *
 */

namespace nullref\cms\components;

use yii\base\Widget as BaseWidget;

/**
 * Class Widget
 * Based class for block's widget
 *
 * @package nullref\cms\components
 */
class Widget extends BaseWidget
{
    protected $_block;

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->_block;
    }

    /**
     * @param $block
     */
    public function setBlock($block)
    {
        $this->_block = $block;
    }

    /**
     * Run widget and return result of it work as string
     *
     * @return string
     * @throws \Exception
     */
    function __toString()
    {
        ob_start();
        ob_implicit_flush(false);
        try {
            $out = $this->run();
        } catch (\Exception $e) {

            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            throw $e;
        }
        return ob_get_clean() . $out;
    }

}
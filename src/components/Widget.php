<?php
/**
 *
 */

namespace nullref\cms\components;

use yii\base\Widget as BaseWidget;

class Widget extends BaseWidget
{
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
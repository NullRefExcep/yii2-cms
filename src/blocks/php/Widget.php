<?php
/**
 *
 */

namespace nullref\cms\blocks\php;

use nullref\cms\blocks\text\Widget as BaseWidget;
use yii\helpers\Html;


class Widget extends BaseWidget
{
    public function run()
    {
        ob_start();
        eval(' ?>' . $this->content . '<?php ');
        if (!empty($this->tag)) {
            return Html::tag($this->tag, ob_get_clean(), ['class' => $this->tagClass]);
        }
        return ob_get_clean();
    }
}
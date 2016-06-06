<?php


use nullref\cms\blocks\text\Widget as TestWidget;

class TextBlockTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testWidgetRunWithTag()
    {
        $widget = new TestWidget();
        $content = 'Lorem';
        $widget->content = $content;
        $widget->tag = 'div';


        self::assertEquals(\yii\helpers\Html::tag('div', $content), $widget->run());
    }

    public function testWidgetRunWithoutTag()
    {
        $widget = new TestWidget();
        $content = 'Lorem';
        $widget->content = $content;
        $widget->tag = '';

        self::assertEquals($content, $widget->run());
    }
}
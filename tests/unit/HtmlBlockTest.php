<?php


use nullref\cms\blocks\html\Widget as HtmlWidget;

class HtmlBlockTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testWidgetRunWithTag()
    {
        $widget = new HtmlWidget();
        $content = 'Lorem';
        $widget->content = $content;
        $widget->tag = 'div';


        self::assertEquals(\yii\helpers\Html::tag('div', $content), $widget->run());
    }

    public function testWidgetRunWithoutTag()
    {
        $widget = new HtmlWidget();
        $content = 'Lorem';
        $widget->content = $content;
        $widget->tag = '';

        self::assertEquals($content, $widget->run());
    }
}
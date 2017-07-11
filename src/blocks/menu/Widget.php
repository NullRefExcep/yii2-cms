<?php

namespace nullref\cms\blocks\menu;

use nullref\cms\components\LinkManager;
use nullref\cms\components\Widget as BaseWidget;
use yii\bootstrap\Nav;


class Widget extends BaseWidget
{
    public $items;

    public $options = [];

    /** @var LinkManager */
    protected $linkManager;

    public function __construct(LinkManager $linkManager, $config = [])
    {
        $this->linkManager = $linkManager;
        parent::__construct($config);
    }

    public function run()
    {
        return Nav::widget(['items' => $this->buildItems(), 'options' => $this->options]);
    }

    public function buildItems($items = null, $options = [])
    {
        $options = array_merge([
            'titleField' => 'label',
            'itemsField' => 'items',
        ], $options);
        if ($items === null) {
            return $this->buildItems($this->items);
        }
        return $this->buildItemsInternal($items, $options);
    }

    public function buildItemsInternal($items, $options)
    {
        return array_map(function ($item) use ($options) {
            $result[$options['titleField']] = $item['title'];
            $result['url'] = $this->buildUrl($item);
            if (isset($item['children'])) {
                $result[$options['itemsField']] = $this->buildItems($item['children']);
            }
            $result['active'] = \Yii::$app->request->url == $result['url'];
            return $result;
        }, $items);
    }

    protected function buildUrl($item)
    {
        if (isset($item['data']) && isset($item['data']['type'])) {
            return $this->linkManager->createUrl($item['data']['type'], $item['data']['url']);
        }
        return $item['data']['url'];
    }
}
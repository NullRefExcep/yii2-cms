<?php

namespace nullref\cms\blocks\menu;

use nullref\cms\components\Block as BaseBlock;
use nullref\cms\components\LinkManager;
use nullref\cms\components\LinkProvider;
use nullref\useful\behaviors\JsonBehavior;
use Yii;
use yii\helpers\Json;

/**
 * Class Block
 *
 * @property string $itemsJson
 */
class Block extends BaseBlock
{
    public $items = [];

    public $options = [];

    /** @var LinkManager */
    protected $linkManager;

    public function __construct(LinkManager $linkManager)
    {
        $this->linkManager = $linkManager;
        parent::__construct();
    }

    public function getName()
    {
        return 'Menu Block';
    }

    public function getItemsJson()
    {
        return Json::encode($this->items);
    }

    public function setItemsJson($items)
    {
        $this->items = Json::decode($items);
    }

    public function rules()
    {
        return [
            [['itemsJson'], 'required'],
            [['items'], 'safe'],
        ];
    }

    public function getLinksList()
    {
        return array_map(function (LinkProvider $provider) {
            return [
                'list' => $provider->getList(),
                'title' => $provider->getTitle(),
            ];
        }, $this->linkManager->providers);
    }

}
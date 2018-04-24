<?php

namespace nullref\cms\components;

use Yii;
use yii\base\BaseObject;

/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 *
 * @property LinkProvider[] $providers
 */
class LinkManager extends BaseObject
{
    /** @var LinkProvider[] */
    protected $providers = [];

    /**
     * @param $type
     * @param $id
     * @return string
     */
    public function createUrl($type, $id)
    {
        $provider = $this->providers[$type];
        return $provider->createUrl($id);
    }

    /**
     * @return LinkProvider[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @param array $providers
     * @throws \yii\base\InvalidConfigException
     */
    public function setProviders(array $providers)
    {
        foreach ($providers as $type => $provider) {
            if ($provider instanceof LinkProvider) {
                $this->addProvider($type, $provider);
            } else {
                $this->setProvider($type, $provider);
            }
        }
    }

    /**
     * @param $type
     * @param LinkProvider $provider
     */
    public function addProvider($type, LinkProvider $provider)
    {
        $this->providers[$type] = $provider;
    }

    /**
     * @param $type
     * @param $providerConfig
     * @throws \yii\base\InvalidConfigException
     */
    public function setProvider($type, $providerConfig)
    {
        /** @var LinkProvider $provider */
        $provider = Yii::createObject($providerConfig);
        $this->providers[$type] = $provider;
    }
}
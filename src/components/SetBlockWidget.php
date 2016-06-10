<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\cms\components;


trait SetBlockWidget
{
    protected $block;

    public function getBlock()
    {
        return $this->block;
    }

    public function setBlock($block)
    {
        $this->block = $block;
    }
}
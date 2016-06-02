<?php

namespace nullref\cms\components;
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */
interface LinkProvider
{
    /**
     * @param $id
     * @return string
     */
    public function createUrl($id);

    /**
     * @return array
     */
    public function getList();

    /**
     * @return string
     */
    public function getTitle();
}
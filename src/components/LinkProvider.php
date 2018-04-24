<?php

namespace nullref\cms\components;
/**
 * Interface LinkProvider
 * @package nullref\cms\components
 * Used in menu block to manage possible links in system
 *
 * @see \nullref\cms\blocks\menu\Block
 *
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
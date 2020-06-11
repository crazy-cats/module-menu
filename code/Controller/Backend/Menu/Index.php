<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\Menu;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Index extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function execute()
    {
        $this->setPageTitle(__('Menu List'))->render();
    }
}

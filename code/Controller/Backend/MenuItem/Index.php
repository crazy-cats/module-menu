<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\MenuItem;

use CrazyCat\Menu\Model\Menu;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Index extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @throws \ReflectionException
     */
    protected function execute()
    {
        if (!($mid = $this->request->getParam('mid'))) {
            $this->messenger->addError(__('Menu with specified ID does not exist.'));
            return $this->redirect('menu/menu');
        }

        /* @var $model \CrazyCat\Menu\Model\Menu */
        $menu = $this->objectManager->create(Menu::class)->load($mid);
        if (!$menu->getId()) {
            $this->messenger->addError(__('Menu with specified ID does not exist.'));
            return $this->redirect('menu/menu');
        }

        $this->setPageTitle(__('Items of Menu `%1` [ ID: %2 ]', [$menu->getData('name'), $menu->getId()]))->render();
    }
}

<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\MenuItem;

use CrazyCat\Menu\Model\Menu\Item as Model;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Edit extends \CrazyCat\Framework\App\Component\Module\Controller\Backend\AbstractAction
{
    /**
     * @return void
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function execute()
    {
        /* @var $model \CrazyCat\Framework\App\Component\Module\Model\AbstractModel */
        $model = $this->objectManager->create(Model::class);

        if (($id = $this->request->getParam('id'))) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messenger->addError(__('Item with specified ID does not exist.'));
                return $this->redirect('menu/menu_item');
            }
        }

        $this->registry->register('current_model', $model);

        $pageTitle = $model->getId() ?
            __('Edit Menu Item `%1` [ ID: %2 ]', [$model->getData('title'), $model->getId()]) :
            __('Create Menu Item');

        $this->setPageTitle($pageTitle)->render();
    }
}

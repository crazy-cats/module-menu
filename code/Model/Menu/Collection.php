<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Menu;

use CrazyCat\Base\Model\Stage\Manager as StageManager;
use CrazyCat\Framework\App\Area;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Collection extends \CrazyCat\Framework\App\Component\Module\Model\AbstractCollection
{
    protected function construct()
    {
        $this->init(\CrazyCat\Menu\Model\Menu::class);
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function beforeLoad()
    {
        if ($this->objectManager->get(Area::class)->getCode() === Area::CODE_FRONTEND) {
            $stage = $this->objectManager->get(StageManager::class)->getCurrentStage();
            $this->addFieldToFilter(
                [
                    ['field' => 'stage_ids', 'conditions' => ['finset' => $stage->getId()]],
                    ['field' => 'stage_ids', 'conditions' => ['finset' => 0]]
                ]
            );
        }

        parent::beforeLoad();
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function afterLoad()
    {
        parent::afterLoad();

        foreach ($this->items as &$item) {
            $item->setData('stage_ids', explode(',', $item->getData('stage_ids')));
        }
    }
}

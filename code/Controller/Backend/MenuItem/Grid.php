<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\MenuItem;

use CrazyCat\Base\Model\Source\Stage as SourceStage;
use CrazyCat\Base\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Menu\Block\Backend\Menu\Item\Grid as GridBlock;
use CrazyCat\Menu\Model\Menu\Item\Collection;
use CrazyCat\Menu\Model\Source\Item as SourceItem;
use CrazyCat\Menu\Model\Source\Menu as SourceMenu;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Grid extends \CrazyCat\Base\Controller\Backend\AbstractGridAction
{
    protected function construct()
    {
        $this->init(Collection::class, GridBlock::class);

        $this->collection->addFieldToFilter('menu_id', ['eq' => $this->request->getParam('mid')]);
    }

    /**
     * @param array $collectionData
     * @return array
     * @throws \ReflectionException
     */
    protected function processData($collectionData)
    {
        $sourceStage = $this->objectManager->get(SourceStage::class);
        $sourceYesNo = $this->objectManager->get(SourceYesNo::class);
        $sourceMenu = $this->objectManager->get(SourceMenu::class);
        $sourceItem = $this->objectManager->get(SourceItem::class);
        foreach ($collectionData['items'] as &$item) {
            $item['menu_id'] = $sourceMenu->getLabel($item['menu_id']);
            $item['parent_id'] = $sourceItem->getLabel($item['parent_id']);
            $item['enabled'] = $sourceYesNo->getLabel($item['enabled']);
            $item['stage_ids'] = $sourceStage->getLabel($item['stage_ids']);
        }
        return $collectionData;
    }
}

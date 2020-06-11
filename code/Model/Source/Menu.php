<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source;

use CrazyCat\Menu\Model\Menu\Collection as MenuCollection;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Menu extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    /**
     * @param \CrazyCat\Framework\App\ObjectManager $objectManager
     * @throws \ReflectionException
     */
    public function __construct(
        \CrazyCat\Framework\App\ObjectManager $objectManager
    ) {
        foreach ($objectManager->create(MenuCollection::class) as $item) {
            $this->sourceData[$item->getData('name')] = $item->getId();
        }
    }
}

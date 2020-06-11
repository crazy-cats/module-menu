<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model;

use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\App\Io\Http\Url;
use CrazyCat\Menu\Model\Menu\Item as MenuItem;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
abstract class ItemDataGenerator
{
    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \CrazyCat\Framework\App\Io\Http\Url
     */
    protected $url;

    public function __construct(ObjectManager $objectManager, Url $url)
    {
        $this->objectManager = $objectManager;
        $this->url = $url;
    }

    /**
     * @param \CrazyCat\Menu\Model\Menu\Item $menuItem
     * @return \CrazyCat\Framework\Data\DataObject[]
     */
    abstract public function generateItems(MenuItem $menuItem);
}

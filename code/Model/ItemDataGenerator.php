<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model;

use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Menu\Model\Menu\Item as MenuItem;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
abstract class ItemDataGenerator {

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    public function __construct( ObjectManager $objectManager )
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param \CrazyCat\Menu\Model\Menu\Item $menuItem
     * @return \CrazyCat\Framework\Data\Object[]
     */
    abstract public function generateItems( MenuItem $menuItem );
}

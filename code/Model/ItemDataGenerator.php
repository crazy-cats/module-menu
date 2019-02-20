<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model;

use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\App\Url;
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

    /**
     * @var \CrazyCat\Framework\App\Url
     */
    protected $url;

    public function __construct( ObjectManager $objectManager, Url $url )
    {
        $this->objectManager = $objectManager;
        $this->url = $url;
    }

    /**
     * @param \CrazyCat\Menu\Model\Menu\Item $menuItem
     * @return \CrazyCat\Framework\Data\DataObject[]
     */
    abstract public function generateItems( MenuItem $menuItem );
}

<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source;

use CrazyCat\Menu\Model\Menu\Collection as MenuCollection;
use CrazyCat\Framework\App\ObjectManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Menu extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    public function __construct( ObjectManager $objectManager )
    {
        foreach ( $objectManager->create( MenuCollection::class ) as $item ) {
            $this->sourceData[$item->getData( 'name' )] = $item->getId();
        }
    }

}

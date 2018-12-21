<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source;

use CrazyCat\Framework\App\Module\Manager as ModuleManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class ItemType extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    public function __construct( ModuleManager $moduleManager )
    {
        foreach ( $moduleManager->getEnabledModules() as $module ) {
            
        }
    }

}

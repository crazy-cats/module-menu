<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source\Item;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Target extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    public function __construct()
    {
        $this->sourceData = [
            '_self' => '_self',
            '_blank' => '_blank',
            '_parent' => '_parent',
            '_top' => '_top'
        ];
    }

}

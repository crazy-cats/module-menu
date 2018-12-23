<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Item extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    public function __construct()
    {
        $this->sourceData = [
            '[ ROOT ]' => 0
        ];
    }

}

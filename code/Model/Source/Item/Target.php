<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source\Item;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Target extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    public function __construct()
    {
        $this->sourceData = [
            '_self'   => '_self',
            '_blank'  => '_blank',
            '_parent' => '_parent',
            '_top'    => '_top'
        ];
    }
}

<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
return [
    'namespace' => 'CrazyCat\Menu',
    'depends'   => [
        'CrazyCat\Base'
    ],
    'routes'    => [
        'backend' => 'menu'
    ],
    'setup'     => [
        'CrazyCat\Menu\Setup\Install'
    ]
];

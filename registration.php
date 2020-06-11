<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

use CrazyCat\Framework\App\Component\Manager as ComponentManager;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
ComponentManager::getInstance()->register('CrazyCat\Menu', ComponentManager::TYPE_MODULE, __DIR__);

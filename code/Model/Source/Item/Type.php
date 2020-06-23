<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source\Item;

use CrazyCat\Framework\App\Cache\Manager as CacheManager;
use CrazyCat\Framework\App\Component\Module\Manager as ModuleManager;
use CrazyCat\Framework\App\ObjectManager;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Type extends \CrazyCat\Framework\App\Component\Module\Model\Source\AbstractSource
{
    public const CACHE_MENU_TYPES = 'menu_types';

    /**
     * @var \CrazyCat\Framework\App\Cache\Manager
     */
    protected $cacheManager;

    /**
     * @var \CrazyCat\Framework\App\Component\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $itemTypes;

    public function __construct(ObjectManager $objectManager, CacheManager $cacheManager, ModuleManager $moduleManager)
    {
        $this->cacheManager = $cacheManager;
        $this->moduleManager = $moduleManager;
        $this->objectManager = $objectManager;

        $this->collectItemTypes();

        foreach ($this->itemTypes as $typeName => $typeInfo) {
            $this->sourceData[__($typeInfo['label'])] = $typeName;
        }
    }

    /**
     * @return void
     */
    protected function collectItemTypes()
    {
        $cacheItemTypes = $this->cacheManager->create(self::CACHE_MENU_TYPES);
        if (empty($this->itemTypes = $cacheItemTypes->getData())) {
            foreach ($this->moduleManager->getEnabledModules() as $module) {
                if (is_file(($file = $module->getData('dir') . DS . 'config' . DS . 'frontend' . DS . 'menu.php')) &&
                    is_array(($modelItemTypes = require $file))) {
                    $this->itemTypes = array_merge($this->itemTypes, $modelItemTypes);
                }
            }
            $cacheItemTypes->setData($this->itemTypes)->save();
        }
    }

    /**
     * @param string $type
     * @return \CrazyCat\Menu\Model\ItemDataGenerator|null
     * @throws \ReflectionException
     */
    public function getItemDataGenerator($type)
    {
        return empty($this->itemTypes[$type]['item_data_generator']) ?
            null : $this->objectManager->get($this->itemTypes[$type]['item_data_generator']);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getItemTypes()
    {
        foreach ($this->itemTypes as &$itemType) {
            if (!empty($itemType['params_generating_url'])) {
                $itemType['params_generating_url'] = getUrl($itemType['params_generating_url']);
            }
        }
        return $this->itemTypes;
    }
}

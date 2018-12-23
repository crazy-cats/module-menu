<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source\Item;

use CrazyCat\Framework\App\Cache\Factory as CacheFactory;
use CrazyCat\Framework\App\Module\Manager as ModuleManager;
use CrazyCat\Framework\App\ObjectManager;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Type extends \CrazyCat\Framework\App\Module\Model\Source\AbstractSource {

    const CACHE_MENU_TYPES = 'menu_types';

    /**
     * @var \CrazyCat\Framework\App\Cache\Factory
     */
    protected $cacheFactory;

    /**
     * @var \CrazyCat\Framework\App\Module\Manager
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

    public function __construct( ObjectManager $objectManager, CacheFactory $cacheFactory, ModuleManager $moduleManager )
    {
        $this->cacheFactory = $cacheFactory;
        $this->moduleManager = $moduleManager;
        $this->objectManager = $objectManager;

        $this->collectItemTypes();

        foreach ( $this->itemTypes as $typeName => $typeInfo ) {
            $this->sourceData[$typeInfo['label']] = $typeName;
        }
    }

    /**
     * @return void
     */
    protected function collectItemTypes()
    {
        $cacheItemTypes = $this->cacheFactory->create( self::CACHE_MENU_TYPES );
        if ( empty( $this->itemTypes = $cacheItemTypes->getData() ) ) {
            foreach ( $this->moduleManager->getEnabledModules() as $module ) {
                if ( is_file( ( $file = $module->getData( 'dir' ) . DS . 'config' . DS . 'frontend' . DS . 'menu.php' ) ) &&
                        is_array( ( $modelItemTypes = require $file ) ) ) {
                    $this->itemTypes = array_merge( $this->itemTypes, $modelItemTypes );
                }
            }
            $cacheItemTypes->setData( $this->itemTypes )->save();
        }
    }

    /**
     * @param string $type
     * @return 
     */
    public function getItemDataGenerator( $type )
    {
        return empty( $this->itemTypes[$type]['item_data_generator'] ) ?
                null : $this->objectManager->get( $this->itemTypes[$type]['item_data_generator'] );
    }

    /**
     * @return array
     */
    public function getItemTypes()
    {
        foreach ( $this->itemTypes as &$itemType ) {
            if ( !empty( $itemType['params_generating_url'] ) ) {
                $itemType['params_generating_url'] = getUrl( $itemType['params_generating_url'] );
            }
        }
        return $this->itemTypes;
    }

}

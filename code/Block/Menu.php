<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block;

use CrazyCat\Menu\Model\Menu\Collection as MenuCollection;
use CrazyCat\Menu\Model\Menu\Item\Collection as ItemCollection;
use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Menu extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Menu::menu';

    /**
     * @var \CrazyCat\Menu\Model\Menu
     */
    protected $menuModel;

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    public function __construct( ObjectManager $objectManager, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->objectManager = $objectManager;
    }

    /**
     * @return \CrazyCat\Menu\Model\Menu|null
     */
    public function getMenu()
    {
        if ( $this->menuModel === null ) {
            $this->menuModel = $this->objectManager->create( MenuCollection::class )
                    ->addFieldToFilter( 'identifier', [ 'eq' => $this->getData( 'identifier' ) ] )
                    ->setPageSize( 1 )
                    ->getFirstItem();
        }
        return $this->menuModel;
    }

    /**
     * @return array
     */
    protected function getItemTree( $itemSource, $parentId = 0, $level = 0 )
    {
        if ( !isset( $itemSource[$parentId] ) ) {
            return [];
        }

        $itemTree = [];
        $level ++;
        $hasActivedItem = false;
        foreach ( $itemSource[$parentId] as $item ) {
            list( $children, $hasActivedChild ) = $this->getItemTree( $itemSource, $item->getId(), $level );
            $hasActivedItem = $hasActivedItem || $hasActivedChild;
            $itemTree[] = $item->addData( [
                'level' => $level,
                'children' => $children ] );
        }

        return [ $itemTree, $hasActivedItem ];
    }

    /**
     * @return array
     */
    public function getItems()
    {
        $itemCollection = $this->objectManager->create( ItemCollection::class )
                ->addFieldToFilter( 'menu_id', [ 'eq' => $this->getMenu()->getId() ] )
                ->addOrder( 'sort_order' );

        $itemSource = [];
        foreach ( $itemCollection as $item ) {
            if ( !isset( $itemSource[$item->getData( 'parent_id' )] ) ) {
                $itemSource[$item->getData( 'parent_id' )] = [];
            }
            $itemSource[$item->getData( 'parent_id' )][] = $item;
        }

        return $this->getItemTree( $itemSource );
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        if ( $this->getMenu() === null ) {
            return '';
        }
        return parent::toHtml();
    }

}

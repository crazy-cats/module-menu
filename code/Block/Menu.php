<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block;

use CrazyCat\Menu\Model\Menu\Collection as MenuCollection;
use CrazyCat\Menu\Model\Menu\Item\Collection as ItemCollection;
use CrazyCat\Menu\Model\Source\ItemType as SourceItemType;
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

    /**
     * @var \CrazyCat\Menu\Model\Source\ItemType
     */
    protected $sourceItemType;

    /**
     * @var array
     */
    protected $items;

    public function __construct( SourceItemType $sourceItemType, ObjectManager $objectManager, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->objectManager = $objectManager;
        $this->sourceItemType = $sourceItemType;
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
     * @param array $itemSource [ parent_id => [ item1, item2, ... ] ]
     * @param int $parentId
     * @param int $level
     * @return array
     */
    protected function getItemTree( $itemSource, $parentId = 0, $level = 0 )
    {
        if ( !isset( $itemSource[$parentId] ) ) {
            return [ [], false ];
        }

        $itemTree = [];
        $level ++;
        $isActived = false;
        foreach ( $itemSource[$parentId] as $item ) {
            if ( ( $itemDataGenerator = $this->sourceItemType->getItemDataGenerator( $item->getData( 'type' ) ) ) ) {
                foreach ( $itemDataGenerator->generateItems( $item->setData( 'level', $level ) ) as $realItem ) {
                    $isActived = $isActived || $realItem->getIsActived();
                    $itemTree[] = $realItem;
                }
            }
            else {
                list( $children, $hasActivedChild ) = $this->getItemTree( $itemSource, $item->getId(), $level );
                $isActived = $isActived || $hasActivedChild;
                $itemTree[] = $item->addData( [
                    'level' => $level,
                    'is_actived' => $hasActivedChild,
                    'children' => $children ] );
            }
        }

        return [ $itemTree, $isActived ];
    }

    /**
     * @return array
     */
    public function getItems()
    {
        if ( $this->items === null ) {
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
            list( $this->items ) = $this->getItemTree( $itemSource );
        }

        return $this->items;
    }

    /**
     * @return string
     */
    public function renderItem( $item )
    {
        return $this->objectManager->create( Menu\Item::class )->setData( 'item', $item )->toHtml();
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        if ( $this->getMenu() === null || empty( $this->getItems() ) ) {
            return '';
        }
        return parent::toHtml();
    }

}

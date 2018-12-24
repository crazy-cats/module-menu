<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Source;

use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\Utility\Html;
use CrazyCat\Menu\Model\Menu\Item\Collection as ItemCollection;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Item {

    /**
     * @var array
     */
    private $itemSource;

    public function __construct( ObjectManager $objectManager )
    {
        $itemCollection = $objectManager->create( ItemCollection::class )
                ->addOrder( 'sort_order' );

        $this->itemSource = [];
        foreach ( $itemCollection as $item ) {
            if ( !isset( $this->itemSource[$item->getData( 'parent_id' )] ) ) {
                $this->itemSource[$item->getData( 'parent_id' )] = [];
            }
            $this->itemSource[$item->getData( 'parent_id' )][] = $item;
        }
    }

    /**
     * @param array $itemSource
     * @param int $parentId
     * @param int $level
     * @param int|null $excludeId
     * @return array
     */
    private function getItemTree( $itemSource, $parentId = 0, $level = 0, $excludeId = null )
    {
        if ( !isset( $itemSource[$parentId] ) ) {
            return false;
        }
        $itemTree = [];
        $prefix = str_repeat( Html::spaceString(), 4 * $level );
        $level ++;
        foreach ( $itemSource[$parentId] as $item ) {
            if ( $excludeId == $item->getId() ) {
                continue;
            }
            $itemTree[sprintf( '%s%s ( ID: %d )', $prefix, $item->getData( 'title' ), $item->getId() )] = $item->getId();
            if ( ( $children = $this->getItemTree( $itemSource, $item->getId(), $level, $excludeId ) ) ) {
                $itemTree = array_merge( $itemTree, $children );
            }
        }
        return $itemTree;
    }

    /**
     * @param array $itemSource
     * @param int|null $excludeId
     * @return array
     */
    private function getItemArray( $itemSource, $excludeId )
    {
        return array_merge( [ '[ ROOT ]' => 0 ], $this->getItemTree( $itemSource, 0, 0, $excludeId ) );
    }

    /**
     * @param boolean $withEmpty
     * @param int|null $excludeId
     * @return array
     */
    public function toOptionArray( $withEmpty = false, $excludeId = null )
    {
        $options = [];
        foreach ( $this->getItemArray( $this->itemSource, $excludeId ) as $label => $value ) {
            $options[] = [ 'label' => $label, 'value' => $value ];
        }
        if ( $withEmpty ) {
            array_unshift( $options, [ 'label' => '', 'value' => '' ] );
        }
        return $options;
    }

    /**
     * @param int|null $excludeId
     * @return array
     */
    public function toHashArray( $excludeId = null )
    {
        return array_flip( $this->getItemArray( $this->itemSource, $excludeId ) );
    }

    /**
     * @param string $value
     * @return string|null
     */
    public function getLabel( $value )
    {
        $tmp = $this->toHashArray();
        if ( is_array( $value ) ) {
            foreach ( $value as &$v ) {
                $v = isset( $tmp[$v] ) ? $tmp[$v] : null;
            }
            return implode( ', ', $value );
        }
        else {
            return isset( $tmp[$value] ) ? $tmp[$value] : null;
        }
    }

}

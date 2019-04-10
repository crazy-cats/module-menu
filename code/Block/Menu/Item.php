<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block\Menu;

use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Item extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    protected $template = 'CrazyCat\Menu::item';

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    public function __construct( ObjectManager $objectManager, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->objectManager = $objectManager;
    }

    public function renderChildren( $children, $template = null )
    {
        $html = '';
        foreach ( $children as $child ) {
            $html .= $this->objectManager->create( Item::class, [ 'data' => [ 'template' => $template ] ] )->setData( 'item', $child )->toHtml();
        }
        return $html;
    }

}

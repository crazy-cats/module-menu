<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block\Backend\Menu\Item\Edit;

use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\App\Theme\Block\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Type extends \CrazyCat\Core\Block\Form\Renderer\abstractRenderer {

    protected $template = 'CrazyCat\Menu::item/type';

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    public function __construct( ObjectManager $objectManager, Context $context, array $data = [] )
    {
        parent::__construct( $context, $data );

        $this->objectManager = $objectManager;
    }

    public function getOptions()
    {
        return $this->objectManager->create( $this->getData( 'field' )['source'] )->toOptionArray();
    }

}

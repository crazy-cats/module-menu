<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\MenuItem;

use CrazyCat\Menu\Model\Menu;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Index extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        if ( !( $mid = $this->request->getParam( 'mid' ) ) ) {
            $this->messenger->addError( __( 'Menu with specified ID does not exist.' ) );
            return $this->redirect( 'menu/menu' );
        }

        /* @var $model \CrazyCat\Menu\Model\Menu */
        $menu = $this->objectManager->create( Menu::class )->load( $mid );
        if ( !$menu->getId() ) {
            $this->messenger->addError( __( 'Menu with specified ID does not exist.' ) );
            return $this->redirect( 'menu/menu' );
        }

        $this->setPageTitle( __( 'Items of Menu `%1` [ ID: %2 ]', [ $menu->getData( 'name' ), $menu->getId() ] ) )->render();
    }

}

<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model\Menu;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Item extends \CrazyCat\Framework\App\Module\Model\AbstractLangModel {

    /**
     * @return void
     */
    protected function construct()
    {
        $this->init( 'menu_item', 'menu_item' );
    }

    /**
     * @return void
     */
    protected function beforeSave()
    {
        parent::beforeSave();

        if ( isset( $this->data['stage_ids'] ) && is_array( $this->data['stage_ids'] ) ) {
            $this->data['stage_ids'] = implode( ',', $this->data['stage_ids'] );
        }
    }

    /**
     * @return void
     */
    protected function afterLoad()
    {
        $this->data['stage_ids'] = explode( ',', $this->data['stage_ids'] );

        parent::afterLoad();
    }

}

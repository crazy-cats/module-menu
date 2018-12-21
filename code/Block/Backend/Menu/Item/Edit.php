<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block\Backend\Menu\Item;

use CrazyCat\Core\Model\Source\Stage as SourceStage;
use CrazyCat\Core\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Menu\Block\Backend\Menu\Item\Edit\Type;
use CrazyCat\Menu\Model\Source\ItemType as SourceItemType;
use CrazyCat\Menu\Model\Source\Menu as SourceMenu;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Edit extends \CrazyCat\Core\Block\Backend\AbstractEdit {

    /**
     * @return array
     */
    public function getFields()
    {
        return [
            'general' => [
                'label' => __( 'General' ),
                'fields' => [
                        [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                        [ 'name' => 'title', 'label' => __( 'Title' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                        [ 'name' => 'identifier', 'label' => __( 'Identifier' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                        [ 'name' => 'enabled', 'label' => __( 'Enabled' ), 'type' => 'select', 'source' => SourceYesNo::class ],
                        [ 'name' => 'menu_id', 'label' => __( 'Menu' ), 'type' => 'select', 'source' => SourceMenu::class, 'validation' => [ 'required' => true ] ],
                        [ 'name' => 'parent_id', 'label' => __( 'Parent' ), 'type' => 'select', 'source' => SourceMenu::class, 'validation' => [ 'required' => true ] ],
                        [ 'name' => 'type', 'label' => __( 'Type' ), 'renderer' => Type::class, 'source' => SourceItemType::class, 'validation' => [ 'required' => true ] ],
                        [ 'name' => 'stage_ids', 'label' => __( 'Stage' ), 'type' => 'multiselect', 'source' => SourceStage::class ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return getUrl( 'menu/menu_item/save' );
    }

}

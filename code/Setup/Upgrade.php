<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Setup;

use CrazyCat\Framework\App\Db\MySql;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Upgrade extends \CrazyCat\Framework\App\Module\Setup\AbstractUpgrade {

    private function createMenuMainTable()
    {
        $columns = [
                [ 'name' => 'id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'auto_increment' => true ],
                [ 'name' => 'name', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 255, 'null' => false ],
                [ 'name' => 'identifier', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false ],
                [ 'name' => 'enabled', 'type' => MySql::COL_TYPE_TINYINT, 'length' => 1, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'stage_ids', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false, 'default' => '0' ]
        ];
        $indexes = [
                [ 'columns' => [ 'identifier' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'enabled' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'stage_ids' ], 'type' => MySql::INDEX_NORMAL ]
        ];
        $this->conn->createTable( 'menu', $columns, $indexes );
    }

    private function createMenuItemMainTable()
    {
        $columns = [
                [ 'name' => 'id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'auto_increment' => true ],
                [ 'name' => 'identifier', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false ],
                [ 'name' => 'enabled', 'type' => MySql::COL_TYPE_TINYINT, 'length' => 1, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'menu_id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'parent_id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false, 'default' => 0 ],
                [ 'name' => 'type', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false ],
                [ 'name' => 'stage_ids', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 32, 'null' => false, 'default' => '0' ],
                [ 'name' => 'params', 'type' => MySql::COL_TYPE_TEXT ],
                [ 'name' => 'sort_order', 'type' => MySql::COL_TYPE_INT, 'length' => 8, 'unsign' => true, 'default' => 0 ]
        ];
        $indexes = [
                [ 'columns' => [ 'identifier' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'enabled' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'menu_id' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'stage_ids' ], 'type' => MySql::INDEX_NORMAL ],
                [ 'columns' => [ 'sort_order' ], 'type' => MySql::INDEX_NORMAL ]
        ];
        $this->conn->createTable( 'menu_item', $columns, $indexes );
    }

    private function createMenuItemLangTable()
    {
        $columns = [
                [ 'name' => 'id', 'type' => MySql::COL_TYPE_INT, 'unsign' => true, 'null' => false ],
                [ 'name' => 'lang', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 8, 'null' => false ],
                [ 'name' => 'title', 'type' => MySql::COL_TYPE_VARCHAR, 'length' => 256, 'null' => false ]
        ];
        $indexes = [
                [ 'columns' => [ 'id', 'lang' ], 'type' => MySql::INDEX_UNIQUE ]
        ];
        $this->conn->createTable( 'menu_item_lang', $columns, $indexes );
    }

    private function createDefaultMenu()
    {
        $menuId = $this->conn->insert( 'menu', [
            'name' => 'Main Menu',
            'identifier' => 'main-menu',
            'enabled' => '1',
            'stage_ids' => '0' ] );

        $menuItemId = $this->conn->insert( 'menu_item', [
            'identifier' => 'home',
            'enabled' => 1,
            'menu_id' => $menuId,
            'parent_id' => 0,
            'type' => 'general',
            'stage_ids' => '0',
            'sort_order' => 0 ] );

        $this->conn->insert( 'menu_item_lang', [
            'id' => $menuItemId,
            'lang' => 'en_US',
            'title' => 'Home' ] );
    }

    /**
     * @param string|null $currentVersion
     */
    public function execute( $currentVersion )
    {
        if ( $currentVersion === null ) {
            $this->createMenuMainTable();
            $this->createMenuItemMainTable();
            $this->createMenuItemLangTable();
            $this->createDefaultMenu();
        }
    }

}

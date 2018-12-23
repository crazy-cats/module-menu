<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\MenuItem;

use CrazyCat\Menu\Model\Menu\Item as Model;
use CrazyCat\Framework\App\Url;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Save extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    protected function run()
    {
        /* @var $model \CrazyCat\Framework\App\Module\Model\AbstractModel */
        $model = $this->objectManager->create( Model::class );

        $data = $this->request->getPost( 'data' );
        if ( empty( $data[$model->getIdFieldName()] ) ) {
            unset( $data[$model->getIdFieldName()] );
        }

        try {
            $id = $model->addData( $data )->save()->getId();
            $this->messenger->addSuccess( __( 'Successfully saved.' ) );
        }
        catch ( \Exception $e ) {
            $id = isset( $data[Url::ID_NAME] ) ? $data[Url::ID_NAME] : null;
            $this->messenger->addError( $e->getMessage() );
        }

        if ( !$this->request->getPost( 'to_list' ) && $id !== null ) {
            return $this->redirect( 'menu/menu_item/edit', [ Url::ID_NAME => $id, 'mid' => $data['menu_id'] ] );
        }
        return $this->redirect( 'menu/menu_item', [ 'mid' => $data['menu_id'] ] );
    }

}

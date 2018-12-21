<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\MenuItem;

use CrazyCat\Menu\Block\Backend\Menu\Item\Grid as GridBlock;
use CrazyCat\Menu\Model\Menu\Item\Collection;
use CrazyCat\Core\Model\Source\Stage as SourceStage;
use CrazyCat\Core\Model\Source\YesNo as SourceYesNo;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Grid extends \CrazyCat\Core\Controller\Backend\AbstractGridAction {

    protected function construct()
    {
        $this->init( Collection::class, GridBlock::class );

        $this->collection->addFieldToFilter( 'id', [ 'eq' => $this->request->getParam( 'mid' ) ] );
    }

    /**
     * @param array $collectionData
     * @return array
     */
    protected function processData( $collectionData )
    {
        $sourceStage = $this->objectManager->get( SourceStage::class );
        $sourceYesNo = $this->objectManager->get( SourceYesNo::class );
        foreach ( $collectionData['items'] as &$item ) {
            $item['enabled'] = $sourceYesNo->getLabel( $item['enabled'] );
            $item['stage_ids'] = $sourceStage->getLabel( $item['stage_ids'] );
        }
        return $collectionData;
    }

}

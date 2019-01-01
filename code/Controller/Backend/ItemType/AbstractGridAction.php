<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\ItemType;

use CrazyCat\Framework\App\Io\Http\Response;
use CrazyCat\Framework\App\Module\Controller\Backend\Context;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
abstract class AbstractGridAction extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    const DEFAULT_PAGE_SIZE = 20;

    /**
     * @var \CrazyCat\Framework\App\Module\Model\AbstractCollection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $fields;

    public function __construct( Context $context )
    {
        parent::__construct( $context );

        $this->initFields();
        $this->initCollection();
    }

    /**
     * @param array $collectionData
     * @return array
     */
    protected function processData( $collectionData )
    {
        return $collectionData;
    }

    /**
     * @return void
     */
    protected function run()
    {
        $this->collection->setPageSize( $this->request->getParam( 'limit' ) ?: self::DEFAULT_PAGE_SIZE  );

        if ( ( $page = $this->request->getParam( 'p' ) ) ) {
            $this->collection->setCurrentPage( $page );
        }

        $this->response->setType( Response::TYPE_JSON )->setData( [
            'filters' => $this->request->getParam( 'filter' ),
            'fields' => $this->fields,
            'data' => $this->processData( $this->collection->toArray() )
        ] );
    }

    /**
     * @return void
     */
    abstract protected function initFields();

    /**
     * @return void
     */
    abstract protected function initCollection();
}

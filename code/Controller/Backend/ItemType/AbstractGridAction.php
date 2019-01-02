<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Controller\Backend\ItemType;

use CrazyCat\Framework\App\Io\Http\Response;
use CrazyCat\Framework\App\Module\Controller\Backend\Context;
use CrazyCat\Framework\Utility\StaticVariable;

/**
 * @category CrazyCat
 * @package CrazyCat\Menu
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
abstract class AbstractGridAction extends \CrazyCat\Framework\App\Module\Controller\Backend\AbstractAction {

    const DEFAULT_PAGE_SIZE = 20;

    /**
     * field types
     */
    const FIELD_TYPE_SELECT = 'select';
    const FIELD_TYPE_TEXT = 'text';

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
     * @param array|null $filters
     * @return array
     */
    protected function processFilters( $filters )
    {
        if ( empty( $filters ) ) {
            return [];
        }

        if ( $filters['ids'] && $filters['ids'] != StaticVariable::NO_SELECTION ) {
            $ids = explode( StaticVariable::GENERAL_SEPARATOR, $this->request->getParam( 'ids' ) );
            $this->collection->addFieldToFilter( $this->collection->getIdFieldName(), [ 'in' => $ids ] );
        }

        foreach ( $this->fields as $field ) {
            if ( empty( $field['filter']['type'] ) || !isset( $filters[$field['name']] ) ) {
                continue;
            }
            switch ( $field['filter']['type'] ) {

                case self::FIELD_TYPE_SELECT :
                    if ( $filters[$field['name']] != StaticVariable::NO_SELECTION ) {
                        $this->collection->addFieldToFilter( $field['name'], [ $field['filter']['condition'] => $filters[$field['name']] ] );
                    }
                    break;

                case self::FIELD_TYPE_TEXT :
                    if ( !empty( $filter = trim( $filters[$field['name']] ) ) ) {
                        $this->collection->addFieldToFilter( $field['name'], [ $field['filter']['condition'] => ( $field['filter']['condition'] == 'like' ) ? ( '%' . $filter . '%' ) : $filter ] );
                    }
                    break;
            }
        }

        return $filters;
    }

    /**
     * @return void
     */
    protected function run()
    {
        $filters = $this->processFilters( $this->request->getParam( 'filter' ) );
        $this->collection->setPageSize( $this->request->getParam( 'limit' ) ?: self::DEFAULT_PAGE_SIZE  );

        if ( ( $page = $this->request->getParam( 'p' ) ) ) {
            $this->collection->setCurrentPage( $page );
        }

        $this->response->setType( Response::TYPE_JSON )->setData( [
            'filters' => $filters,
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

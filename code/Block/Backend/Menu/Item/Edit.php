<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block\Backend\Menu\Item;

use CrazyCat\Base\Model\Source\Stage as SourceStage;
use CrazyCat\Base\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Menu\Block\Backend\Menu\Item\Edit\Type;
use CrazyCat\Menu\Model\Source\Item as SourceItem;
use CrazyCat\Menu\Model\Source\Item\Target as SourceItemTarget;
use CrazyCat\Menu\Model\Source\Item\Type as SourceItemType;
use CrazyCat\Menu\Model\Source\Menu as SourceMenu;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Edit extends \CrazyCat\Base\Block\Backend\AbstractEdit
{
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getFields()
    {
        return [
            'general' => [
                'label'  => __('General'),
                'fields' => [
                    [
                        'name' => 'id',
                        'type' => 'hidden'
                    ],
                    [
                        'name' => 'params',
                        'type' => 'hidden'
                    ],
                    [
                        'name'       => 'title',
                        'label'      => __('Title'),
                        'type'       => 'text',
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'       => 'identifier',
                        'label'      => __('Identifier'),
                        'type'       => 'text',
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'  => 'url',
                        'label' => __('URL'),
                        'type'  => 'text'
                    ],
                    [
                        'name'       => 'target',
                        'label'      => __('Target'),
                        'type'       => 'select',
                        'source'     => SourceItemTarget::class,
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'   => 'enabled',
                        'label'  => __('Enabled'),
                        'type'   => 'select',
                        'source' => SourceYesNo::class
                    ],
                    [
                        'name'       => 'menu_id',
                        'label'      => __('Menu'),
                        'type'       => 'select',
                        'source'     => SourceMenu::class,
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'       => 'parent_id',
                        'label'      => __('Parent Item'),
                        'type'       => 'select',
                        'options'    => $this->objectManager->get(SourceItem::class)->toOptionArray(
                            false,
                            $this->getModel()->getId()
                        ),
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'       => 'type',
                        'label'      => __('Type'),
                        'renderer'   => Type::class,
                        'source'     => SourceItemType::class,
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'       => 'stage_ids',
                        'label'      => __('Stages'),
                        'type'       => 'multiselect',
                        'source'     => SourceStage::class,
                        'validation' => ['required' => true]
                    ],
                    [
                        'name'  => 'sort_order',
                        'label' => __('Sort Order'),
                        'type'  => 'text'
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return $this->getUrl('menu/menu_item/save');
    }
}

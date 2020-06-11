<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block\Backend\Menu\Item;

use CrazyCat\Base\Model\Source\Stage as SourceStage;
use CrazyCat\Base\Model\Source\YesNo as SourceYesNo;
use CrazyCat\Menu\Model\Source\Item as SourceItem;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Grid extends \CrazyCat\Base\Block\Backend\AbstractGrid
{
    public const BOOKMARK_KEY = 'menu_menu_item';

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getFields()
    {
        return [
            ['ids' => true,],
            [
                'name'   => 'id',
                'label'  => __('ID'),
                'sort'   => true,
                'width'  => 100,
                'filter' => ['type' => 'text', 'condition' => 'eq']
            ],
            [
                'name'   => 'title',
                'label'  => __('Title'),
                'sort'   => true,
                'filter' => ['type' => 'text', 'condition' => 'like']
            ],
            [
                'name'   => 'identifier',
                'label'  => __('Identifier'),
                'sort'   => true,
                'filter' => ['type' => 'text', 'condition' => 'like']
            ],
            [
                'name'   => 'parent_id',
                'label'  => __('Parent Item'),
                'sort'   => true,
                'width'  => 200,
                'filter' => ['type' => 'select', 'source' => SourceItem::class, 'condition' => 'eq']
            ],
            [
                'name'   => 'stage_ids',
                'label'  => __('Stages'),
                'sort'   => true,
                'width'  => 200,
                'filter' => ['type' => 'select', 'source' => SourceStage::class, 'condition' => 'finset']
            ],
            [
                'name'   => 'enabled',
                'label'  => __('Enabled'),
                'sort'   => true,
                'width'  => 130,
                'filter' => ['type' => 'select', 'source' => SourceYesNo::class, 'condition' => 'eq']
            ],
            [
                'label'   => __('Actions'),
                'actions' => [
                    [
                        'name'   => 'redirect',
                        'label'  => __('Edit'),
                        'url'    => getUrl('menu/menu_item/edit'),
                        'params' => ['id' => ':id', 'mid' => $this->request->getParam('mid')]
                    ],
                    [
                        'name'    => 'delete',
                        'label'   => __('Delete'),
                        'confirm' => __('Sure you want to remove this item?'),
                        'url'     => getUrl('menu/menu_item/delete', ['mid' => $this->request->getParam('mid')])
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->getUrl('menu/menu_item/grid', ['mid' => $this->request->getParam('mid')]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function toHtml()
    {
        return parent::toHtml() . <<<EOD
        <script type="text/javascript">
            // <!CDATA[
            require(['jquery'], function ($) {
                $('.item-menu-menu-index').addClass('active');
            });
            // ]]>
        </script>
EOD;
    }
}

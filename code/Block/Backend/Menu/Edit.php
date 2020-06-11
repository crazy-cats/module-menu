<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block\Backend\Menu;

use CrazyCat\Base\Model\Source\Stage as SourceStage;
use CrazyCat\Base\Model\Source\YesNo as SourceYesNo;

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
                        'name'  => 'id',
                        'label' => __('ID'),
                        'type'  => 'hidden'
                    ],
                    [
                        'name'       => 'name',
                        'label'      => __('Menu Name'),
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
                        'name'   => 'enabled',
                        'label'  => __('Enabled'),
                        'type'   => 'select',
                        'source' => SourceYesNo::class
                    ],
                    [
                        'name'   => 'stage_ids',
                        'label'  => __('Stage'),
                        'type'   => 'multiselect',
                        'source' => SourceStage::class
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
        return $this->getUrl('menu/menu/save');
    }
}

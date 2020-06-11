<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block\Menu;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Item extends \CrazyCat\Framework\App\Component\Module\Block\AbstractBlock
{
    protected $template = 'CrazyCat\Menu::item';

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    public function __construct(
        \CrazyCat\Framework\App\ObjectManager $objectManager,
        \CrazyCat\Framework\App\Component\Theme\Block\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->objectManager = $objectManager;
    }

    public function renderChildren($children, $template = null)
    {
        $html = '';
        foreach ($children as $child) {
            $html .= $this->objectManager->create(Item::class, ['data' => ['template' => $template]])
                ->setData('item', $child)
                ->toHtml();
        }
        return $html;
    }
}

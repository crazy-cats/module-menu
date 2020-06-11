<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Block\Backend\Menu\Item\Edit;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Type extends \CrazyCat\Base\Block\Form\Renderer\abstractRenderer
{
    protected $template = 'CrazyCat\Menu::item/type';

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \CrazyCat\Menu\Model\Source\Item\Type
     */
    protected $sourceItemType;

    public function __construct(
        \CrazyCat\Menu\Model\Source\Item\Type $sourceItemType,
        \CrazyCat\Framework\App\ObjectManager $objectManager,
        \CrazyCat\Framework\App\Component\Theme\Block\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->objectManager = $objectManager;
        $this->sourceItemType = $sourceItemType;
    }

    /**
     * @return array
     */
    public function getItemTypes()
    {
        return $this->sourceItemType->getItemTypes();
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getOptions()
    {
        return $this->objectManager->create($this->getData('field')['source'])->toOptionArray();
    }
}

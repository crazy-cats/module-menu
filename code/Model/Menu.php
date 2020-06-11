<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Menu\Model;

/**
 * @category CrazyCat
 * @package  CrazyCat\Menu
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Menu extends \CrazyCat\Framework\App\Component\Module\Model\AbstractModel
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function construct()
    {
        $this->init('menu', 'menu');
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function beforeSave()
    {
        parent::beforeSave();

        if (isset($this->data['stage_ids']) && is_array($this->data['stage_ids'])) {
            $this->data['stage_ids'] = implode(',', $this->data['stage_ids']);
        }
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function afterLoad()
    {
        $this->data['stage_ids'] = explode(',', $this->data['stage_ids']);

        parent::afterLoad();
    }
}

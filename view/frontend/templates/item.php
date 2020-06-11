<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Menu\Block\Menu\Item */
$item = $this->getItem();
$itemClass = ( 'level-' . $item->getData( 'level' ) ) .
        ( $item->getData( 'is_actived' ) ? ' actived' : '' ) .
        ( $item->getData( 'is_current' ) ? ' current' : '' );
?>
<li class="menu-item <?php echo $itemClass ?>">
    <a href="<?php echo $item->getData( 'url' ); ?>">
        <span><?php echo $item->getData( 'title' ); ?></span>
    </a>
    <?php if ( !empty( $item->getData( 'children' ) ) ) : ?>
        <ul class="<?php echo 'level-' . ( $item->getData( 'level' ) + 1 ) ?>">
            <?php echo $this->renderChildren( $item->getData( 'children' ) ); ?>
        </ul>
    <?php endif; ?>
</li>
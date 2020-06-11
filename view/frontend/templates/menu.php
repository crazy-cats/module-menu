<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Menu\Block\Menu */
?>
<div class="menu">
    <ul>
        <?php
        foreach ( $this->getItems() as $item ) :
            echo $this->renderItem( $item );
        endforeach;
        ?>
    </ul>
</div>
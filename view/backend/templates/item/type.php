<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Menu\Block\Backend\Menu\Item\Edit\Type */
$field = $this->getField();
$value = $this->getValue();
?>
<?php if ( $this->withLabel() ) : ?>
    <label class="field-name" for="<?php echo $this->getFieldId(); ?>"><?php echo $field['label']; ?></label>
<?php endif; ?>

<?php if ( $this->withWrapper() ) : ?>
    <div class="field-content">
    <?php endif; ?>

    <select id="<?php echo $this->getFieldId(); ?>"
            name="<?php echo $this->getFieldName(); ?>"
            class="<?php echo $this->getClasses(); ?>">
                <?php echo selectOptionsHtml( $this->getOptions(), $value ); ?>
    </select>

    <?php if ( $this->withWrapper() ) : ?>
    </div>
<?php endif; ?>
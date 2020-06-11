<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
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
    <div class="source-box" id="<?php echo $this->getFieldId(); ?>-source"></div>

    <script type="text/javascript">
        // <![CDATA[
        require( [ 'CrazyCat/Menu/js/item-type' ], function( itemType ) {
            var itemTypes = <?php echo json_encode( $this->getItemTypes() ); ?>;
            itemType( {
                el: '#<?php echo $this->getFieldId(); ?>',
                sourceBoxEl: '#<?php echo $this->getFieldId(); ?>-source',
                paramsEl: '#data_params',
                itemTypes: itemTypes
            } );
        } );
        // ]]>
    </script>

    <?php if ( $this->withWrapper() ) : ?>
    </div>
<?php endif; ?>
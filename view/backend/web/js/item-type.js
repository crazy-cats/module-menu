/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery', 'utility' ], function( $, utility ) {

    return function( options ) {

        var opts = $.extend( true, {
            el: null,
            paramsEl: null,
            sourceBoxEl: null,
            itemTypes: {}
        }, options );

        var selector = $( opts.el );
        var paramsElm = $( opts.paramsEl );
        var sourceBox = $( opts.sourceBoxEl );

        var updateItemType = function() {
            if ( opts.itemTypes[selector.val()]['params_generating_url'] ) {
                utility.loading( true );
                var url = opts.itemTypes[selector.val()]['params_generating_url'];
                $.ajax( {
                    url: url + (url.indexOf( '?' ) === -1 ? '?' : '&') + 'ajax=1',
                    type: 'post',
                    dataType: 'json',
                    complete: function() {
                        utility.loading( false );
                    },
                    success: function( response ) {
                        console.log( response );
                    }
                } );
            } else {
                paramsElm.val( null );
                sourceBox.html( '' );
            }
        };

        selector.on( 'change', updateItemType );
        updateItemType();

    };

} );
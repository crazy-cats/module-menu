/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery', 'translator', 'utility' ], function( $, $t, utility ) {

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
                        var html = '<table><thead>';

                        /**
                         * Captions
                         */
                        html += '<tr class="captions">';
                        for ( var i in response.fields ) {
                            var field = response.fields[i];
                            html += '<th>' +
                                    (field.sort ? ('<a href="javascript:;"><span>' + field.label + '</span></a>') : ('<span>' + field.label + '</span>')) +
                                    '</th>';
                        }
                        html += '</tr>';

                        /**
                         * Filters
                         */
                        html += '<tr class="filters">';
                        for ( var i in response.fields ) {
                            var field = response.fields[i];
                            html += '<th>';
                            if ( field.filter ) {
                                switch ( field.filter.type ) {
                                    case 'text' :
                                        html += '<input type="text" class="input-text" name="filter[' + field.name + ']" />';
                                        break;
                                    case 'select' :
                                        html += '<select name="filter[' + field.name + ']"></select>';
                                        break;
                                }
                            } else {
                                html += '&nbsp;';
                            }
                            html += '</th>';
                        }
                        html += '<tr>';

                        /**
                         * Content
                         */
                        html += '</thead><tbody>';
                        for ( var i = 0; i < response.data.items.length; i++ ) {
                            var item = response.data.items[i];
                            html += '<tr>';
                            for ( var i in response.fields ) {
                                var field = response.fields[i];
                                html += '<td>' + (item[field.name] || '-') + '</td>';
                            }
                            html += '</tr>';
                        }
                        html += '</tbody>';

                        /**
                         * Toolbar
                         */
                        html += '<tfoot><tr><td colspan="' + response.fields.length + '">' +
                                '<div class="page-limit">' +
                                '<select name="limit"><option value="20">20</option><option value="50">50</option><option value="100">100</option></select>' +
                                $t( 'items per page' ) + '</div>' +
                                '<div class="pagination">' + $t( 'Total %1 items, page %2 of %3' ) + '</div>' +
                                '</td></tr></tfoot></table>';

                        sourceBox.html( html );
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
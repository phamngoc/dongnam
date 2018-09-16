(function( $ ) {
    'use strict';

    redux.field_objects = redux.field_objects || {};
    redux.field_objects.color_alpha = redux.field_objects.color_alpha || {};

    $( document ).click(
        function(event) {
            if( !$(event.target).closest('.wp-picker-holder').length ) {
                $('.wp-picker-holder .iris-picker').css('display', 'none');
            }
        }
    );

    redux.field_objects.color_alpha.init = function( selector ) {

        if ( !selector ) {
            selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-color_alpha:visible' );
        }

        $( selector ).each(
            function() {

                var el = $( this );
                var parent = el;

                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }
                if ( parent.is( ":hidden" ) ) { // Skip hidden fields
                    return;
                }
                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }

                // Replace and validate field on blur
                el.find( '.redux-color' ).on(
                    'blur', function() {
                        var value = $( this ).val();
                        var id = '#' + $( this ).attr( 'id' );
                        var data_id = '#' + $( this ).attr( 'data-id' );

                        if ( value === "transparent" ) {
                            $( this ).parent().parent().find( '.wp-color-result' ).css(
                                'background-color', 'transparent'
                            );

                            el.find( data_id + '-transparency' ).attr( 'checked', 'checked' );
                        } else {
                            if ( colorValidate( this ) === value ) {
                                if ( value.indexOf( "#" ) !== 0 ) {
                                    $( this ).val( $( this ).data( 'oldcolor' ) );
                                }
                            }

                            el.find( data_id + '-transparency' ).removeAttr( 'checked' );
                        }
                    }
                );

                // When transparency checkbox is clicked
                el.find( '.color-transparency' ).on(
                    'click', function() {
                        if ( $( this ).is( ":checked" ) ) {
                            el.find( '.redux-saved-color' ).val( $( '#' + $( this ).data( 'id' ) ).val() );
                            el.find( '#' + $( this ).data( 'id' ) ).val( 'transparent' );
                            el.find( '#' + $( this ).data( 'id' ) ).parent().parent().find( '.wp-color-result' ).css(
                                'background-color', 'transparent'
                            );
                        } else {
                            if ( el.find( '#' + $( this ).data( 'id' ) ).val() === 'transparent' ) {
                                var prevColor = $( '.redux-saved-color' ).val();

                                if ( prevColor === '' ) {
                                    prevColor = $( '#' + $( this ).data( 'id' ) ).data( 'default-color' );
                                }

                                el.find( '#' + $( this ).data( 'id' ) ).parent().parent().find( '.wp-color-result' ).css(
                                    'background-color', prevColor
                                );

                                el.find( '#' + $( this ).data( 'id' ) ).val( prevColor );
                            }
                        }
                        el.find( '.redux-color' ).trigger( 'input' );
                    }
                );

                el.find( '.redux-color' ).on(
                    'input', function() {
                        var value = $( this ).val();
                        var data_id = '#' + $( this ).attr( 'data-id' );
                        if ( value === "transparent" ) {
                            el.find( data_id + '-transparency' ).attr( 'checked', 'checked' );
                        } else {
                            el.find( data_id + '-transparency' ).removeAttr( 'checked' );
                        }

                        // Refresh Css when have to change
                        $('[name="redux_save"]').each(function(){
                            $(this).attr('name', 'yolo_bestruct_options[lesscss]');
                        });

                        redux_change( $( this ) );
                    }
                );
            }
        );
    };
})( jQuery );
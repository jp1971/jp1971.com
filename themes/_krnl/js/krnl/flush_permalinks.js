( function( $ ) {

    "use strict";

    $( function() {

        // Listen for click on Flush Permalinks
        $( KFP.button_id ).click( function( e ) {

            e.preventDefault();

            // Store callback method name and nonce field value in an array
            var data = {
                action: KFP.action_id,
                nonce: KFP.nonce
            };

            // AJAX call
            $.post( ajaxurl, data, function( response ) {

                if ( '1' === response ) {
                    alert( KFP.success_msg );
                } else {
                    alert( KFP.error_msg );
                }

            });

        });

    });

}( jQuery ));
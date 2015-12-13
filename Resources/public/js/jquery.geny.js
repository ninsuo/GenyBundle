;(function( $ ) {

    $.geny = (function ($) {

        var disableFields = function (formId) {


        }; // disableFields

        return {
            disableFields: disableFields,
        };

    })( $ ); // $.geny

    $('.geny-script-readonly').on('keyup keypress', function (e) {
         e.preventDefault();
         return false;
    });

})( jQuery );

;(function( $ ) {

    $.geny = (function ($) {

        var disableFields = function (formId) {


        }; // disableFields

        return {
            disableFields: disableFields,
        };

    })( $ ); // $.geny

    $('body').off('keyup keypress', '.geny-script-readonly');
    $('body').on('keyup keypress', '.geny-script-readonly', function (e) {
         e.preventDefault();
         return false;
    });

    $('body').off('click', '.geny-script-field-toggle');
    $('body').on('click', '.geny-script-field-toggle', function (e) {
        $('.geny-script-field-handle').addClass('hide');
        $('#geny-field-details-' + $(this).data('geny-field')).removeClass('hide');
    });

})( jQuery );

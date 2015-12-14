;(function( $ ) {

    $.geny = (function ($) {

        var disableFields = function (formId) {


        }; // disableFields

        return {
            disableFields: disableFields,
        };

    })( $ ); // $.geny

    var body = $('body');

    if (body.length === 0) {
        throw "Document must have <body> / </body> tags.";
    }

    body.off('keyup keypress', '.geny-script-readonly');
    body.on('keyup keypress', '.geny-script-readonly', function (e) {
         e.preventDefault();
         return false;
    });

    body.off('click', '.geny-script-field-toggle');
    body.on('click', '.geny-script-field-toggle', function (e) {
        $('.geny-script-field-handle').addClass('hide');
        $('.geny-script-field-settings').removeClass('hide');

        var field_id = $(this).data('geny-field');
        $('#geny-field-details-' + field_id).removeClass('hide');
        $('#geny-field-settings-' + field_id).addClass('hide');
    });

})( jQuery );

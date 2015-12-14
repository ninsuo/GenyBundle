;(function( $ ) {

    $.geny = (function ($) {

        var disableFields = function (formId) {


        }; // disableFields

        return {
            disableFields: disableFields,
        };

    })( $ ); // $.geny

    var body = $('body');

    // domAjax requirement
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
        $('#geny-field-details-' + $(this).data('geny-field')).removeClass('hide');
    });

})( jQuery );

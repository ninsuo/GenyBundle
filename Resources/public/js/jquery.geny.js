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

    body.off('keyup keypress submit', '.geny-script-preview');
    body.on('keyup keypress submit', '.geny-script-preview', function (e) {
         e.preventDefault();
         return false;
    });

    body.off('keyup keypress', '.geny-script-no-submit');
    body.on('keyup keypress', '.geny-script-no-submit', function (e) {
        if (13 === e.which) {
            e.preventDefault();
            return false;
        }
    });

    body.off('click', '.geny-script-display-button');
    body.on('click', '.geny-script-display-button', function (e) {
        var target = $(this).data('geny-target');
        $(target).trigger('click');
    });

    body.off('click', '.geny-script-display-toggle');
    body.on('click', '.geny-script-display-toggle', function (e) {
        $('.geny-script-display-handle').addClass('hide');
        $('.geny-script-display-settings').removeClass('hide');

        // todo: use a target to simplify this

        var field_id = $(this).data('geny-field');
        if ('#' === field_id) {
            var form_id = $(this).data('geny-form');
            $('#geny-form-' + form_id).removeClass('hide');
            $('#geny-settings-' + form_id).addClass('hide');
        } else if ('@' === field_id) {
            $('#geny-submit-form,-' + form_id).removeClass('hide');
            $('#geny-submit-settings-' + form_id).addClass('hide');
        }
        else {
            $('#geny-field-details-' + field_id).removeClass('hide');
            $('#geny-field-settings-' + field_id).addClass('hide');
        }
    });

})( jQuery );

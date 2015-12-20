;(function( $ ) {

//    $.geny = (function ($) {
//
//        var disableFields = function (formId) {
//
//
//        }; // disableFields
//
//        return {
//            disableFields: disableFields,
//        };
//
//    })( $ ); // $.geny

    var body = $('body');

    if (body.length === 0) {
        throw "Document must have <body> / </body> tags.";
    }

    // readonly forms
    body
        .off('keyup keypress submit', '.geny-script-preview')
        .on('keyup keypress submit', '.geny-script-preview', function (e) {
            e.preventDefault();
            return false;
    });

    // pressing enter doesn't submit anymore
    body
        .off('keyup keypress', '.geny-script-no-submit')
        .on('keyup keypress', '.geny-script-no-submit', function (e) {
            if (13 === e.which) {
                e.preventDefault();
                return false;
            }
    });

    // edit buttons
    body
        .off('click', '.geny-script-visibility-button')
        .on('click', '.geny-script-visibility-button', function (e) {
            var target = $(this).data('geny-target');
            $(target).trigger('click');
        })
        .off('click', '.geny-script-visibility-clicks-area')
        .on('click', '.geny-script-visibility-clicks-area', function (e) {
            $('.geny-script-visibility-button').removeClass('hide');
            $('.geny-script-visibility-form').addClass('hide');

            var that = $(this);
            var button = that.data('geny-button');
            var form = that.data('geny-form');

            $(button).addClass('hide');
            $(form).removeClass('hide');
        });

    // toggling tabs
    $('.geny-script-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // collections initialization
    $('.geny-collection').collection();

})( jQuery );

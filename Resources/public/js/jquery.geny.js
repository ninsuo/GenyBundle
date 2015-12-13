;(function( $ ) {

    $.geny = (function ($) {

        var disableFields = function (formId) {


        }; // disableFields

        return {
            disableFields: disableFields,
        };

    })( $ ); // $.geny

    $('.geny-script-readonly').off('keyup keypress');
    $('.geny-script-readonly').on('keyup keypress', function (e) {
         e.preventDefault();
         return false;
    });

//    $('.geny-script-field-toggle').off('mouseenter');
//    $('.geny-script-field-toggle').on('mouseenter', function (e) {
//        $(this).css('border-left', '1px solid grey');
//    });
//
//    $('.geny-script-field-toggle').off('mouseleave');
//    $('.geny-script-field-toggle').on('mouseleave', function (e) {
//        $(this).css('border-left', 'none');
//    });

    $('.geny-script-field-toggle').on('click', function (e) {
        $('.geny-script-field-handle').addClass('hide');
        $('#geny-field-details-' + $(this).data('geny-field')).removeClass('hide');
    });

})( jQuery );

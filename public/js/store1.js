$(document).ready(function () {
    $('[data-toggle=offcanvas]').click(function () {
        /* alert("SSSSSSSSSSSS"); */
        $('.row-offcanvas').toggleClass('active');
    });
});


$(document).ready(function () {
    $('#addToCart form').submit(function (event) {
        event.preventDefault();
        var myUrl = $(this).attr('action');
        /*alert('adding to cart XXX' + myUrl); */

        var formValues = $(this).serialize();
        
        $.post(myUrl, formValues, function (data) {
            alert("OK");
            /* Just in case we have a current status */
            $('.storeMsg').hide();
            $('#addToCartOK').show();
        }).fail(function (jqXHR) {
             alert("Fail");
            $('.storeMsg').hide();
             $('#addToCartFail').show();
        });
    });
});


/*
 $(function () {
 // bind change event to select
 $('#items_resize').bind('change', function () {
 var url = $(this).val(); // get selected value
 if (url) { // require a URL
 window.location = url; // redirect
 }
 return false;
 });
 });
 */
$(document).ready(function () {
    (function ($) {
        $.fn.copyNamedTo = function (other) {
            return this.each(function () {
                $(':input[name]', this).each(function () {
                    var dog = $('[name=' + "'" + $(this).attr('name') + "'" + ']', other);
                    $(this).val($('[name=' + "'" + $(this).attr('name') + "'" + ']', other).val())
                })
            })
        }
    }(jQuery))


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

            /* Just in case we have a current status */
            $('#shop-cart-button-cnt').html(data);
            $('.storeMsg').hide();
            $('#addToCartOK').show();
        }).fail(function (jqXHR) {
            alert("Fail");
            $('.storeMsg').hide();
            $('#addToCartFail').show();
        }).always(function () {
            window.scrollTo(0, 0);
            $('#main').animate({scrollTop: '0px'}, 300);
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





$("#cart-form").validate();

$("#billing-address-form").validate();


jQuery.validator.addClassRules(
        {
            "required-integer": {
                digits: true,
                required: true
            }
        });



$(document).ready(function () {


    var authOptions = function (inThis)
    {
        if (inThis.id == 'login') {
            $('.register-account').hide().find('input, textarea').prop('disabled', true);
            $('#checkout-auth').show();
        }
        else if (inThis.id == 'register') {
            $('.register-account').show().find('input, textarea').prop('disabled', false);
            $('#checkout-auth').show();
        }
        else if (inThis.id == 'guest')
        {
            $('#checkout-auth').hide();
        }
    }


    /* Call option set on change */
    $('input[type=radio][name=optCheckout]').change(function ()
    {
        authOptions(this)
    });
    /*
     $('input[type=radio][name=optCheckout]').change(function () {
     if (this.id == 'login') {
     $('.register-account').hide().find('input, textarea').prop('disabled', true);
     $('#checkout-auth').show();
     }
     else if (this.id == 'register') {
     $('.register-account').show().find('input, textarea').prop('disabled', false);
     $('#checkout-auth').show();
     }
     else if (this.id == 'guest')
     {
     $('#checkout-auth').hide();
     }
     })
     */
    $('#checkout-auth-form').submit(function () {
        form = $('#checkout-auth-form');
        selectedOption = form.find('input[type=radio]:checked');
        method = selectedOption.prop('id');
        if (method == 'guest') {
            form.find('#authEmail').prop('value', 'guest@noDomain.com');

            form.find('#authPassword').prop('value', 'guest1');
        }
        else if (method == 'register')
        {
            url = selectedOption.data("xurl");
            form.attr("action", url);
        }
    })

    $('#billing-address-form').submit(function (event) {


        var $form = $(this);
        if (!$form.valid())
            return false;
        $("#billing-panel-body").collapse('toggle');
        $("#shipping-panel .panel-title a").removeAttr('disabled');

        $("#shipping-panel-body").collapse('toggle');
        event.preventDefault();
    })

    $('#shipping-address-form').submit(function (event) {

        var val = $(this).find("button[clicked='true']").val();
        event.preventDefault()
        if (val == "useBilling")
        {
            $(this).copyNamedTo($("#billing-address-form"))
        }
        var $form = $(this);
        if (!$form.valid())
            return false;
        
        $("#shipping-panel-body").collapse('hide');
        $("#payment-panel .panel-title a").removeAttr('disabled');        
        $("#payment-panel-body").collapse('show');
        
         
    })




    /* This sets a special click attribute so we know wich button was pressed 
     * I am NOT happy with this solution but it seems there are not many 
     * reliable ways of doing this in JS
     */
    $("form button").click(function () {
        $("button", $(this).parents("form")).removeAttr("clicked");

        $(this).attr("clicked", "true");
    });



    /*
     $.ajax({
     type: 'POST',
     url: 'add.php',
     data: $('#form').serialize(),
     success: function(response) {
     $("#answers").html(response);
     }
     
     });
     */

    function checkoutRouting(currentState)
    {
        // $(currentState).collapse();
        // if ($currenState).id
    }
});


/*
 function doChkoutAuth()
 {
 form = $('#checkout-auth-form');
 
 selectedOption = form.find('input[type=radio]:checked');
 url= selectedOption.data("xurl");
 
 alert("CCCCCCCCCC" + url);
 
 if (selectedOption .prop('name') == 'guest') {
 form.find('#authEmail').prop('value', 'guest@noDomain.com');
 form.find('#authPassword'.prop('value', 'guest'));
 }
 
 
 var formValues = form.serialize();
 $.post(url, formValues, function (data) {
 
 
 
 }).fail(function (error) {
 if (undefined == error)
 ;
 }).always(function () {
 
 });
 }
 */
;




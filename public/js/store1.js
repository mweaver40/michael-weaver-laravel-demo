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


    /**
     * Moves left menu panel on and off the users viewport by toggeling a class
     * that manipulates the border.
     */
    $('[data-toggle=offcanvas]').click(function () {
        $('.row-offcanvas').toggleClass('active');
    });
});

/*
 * Adds a order line to the order and displays a 
 * success or failure meassage when user adds item 
 * to the cart
 */
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



$("#cart-form").validate();
$("#billing-address-form").validate();
jQuery.validator.addClassRules(
        {
            "required-integer": {
                digits: true,
                required: true
            }
        });

/*
 * Based on selected radio button pick either login or register URL 
 * for laravel's authentication. Guests are loged in to an existing 
 * guest account.
 */
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

    /*
     * Handle the use billing address for shipping
     */
    $('#use-billing-address').change(function (event) {

        var useBillingAddress;
        event.preventDefault();
        useBillingAddress = $(this).is(":checked") ? "1" : "0";


        if (useBillingAddress == "1") {
            token = $("#shipping-address-form input[name='_token']").val();
            myUrl = $('#shipping-address-form').attr('action');

            clearCheckoutError();
            $.post(myUrl, {useBillingAddress: useBillingAddress, _token: token}, function (data) {
                console.log("after post");
            }).fail(function (jqXHR) {
                showCheckoutError();
                return false;
            }).always(function () {

            })
            $("#shipping-address-div").hide();
            completeStep('#shipping-panel');
        }
        else
        {
            $("#shipping-address-div").show();
        }

    })

    function showCheckoutError()
    {
        $('.storeMsg').show().html("An error occured. Please try later");
    }

    function clearCheckoutError()
    {
        $('.storeMsg').hide();
    }

/*
 * Handle checkout billing address step.
 */
    $('#billing-address-form').submit(function (event) {
        var $form = $(this);
        if (!$form.valid())
            return false;
        event.preventDefault();
        console.log("entering billing-address-form");
        console.log("In clousure");
        event.preventDefault();
        var myUrl = $(this).attr('action');
        var formValues = $(this).serialize();
        $.post(myUrl, formValues, function (data) {
            completeStep('#billing-panel');
            console.log("after post");
        }).fail(function (jqXHR) {
            failStep();
            return false;
        }).always(function () {

        });
    })

/*
 * Handle checkout shipping step
 */
    $('#shipping-address-form').submit(function (event) {

        var val = $(this).find("button[clicked='true']").val();
        event.preventDefault();

        var $form = $(this);
        if (!$form.valid())
            return false;
        var myUrl = $(this).attr('action');
        var formValues = $(this).serialize();
        $.post(myUrl, formValues, function (data) {
            completeStep('#shipping-panel');
        }).fail(function (jqXHR) {
            console.log("in failure")
            failStep();
            return false;
        }).always(function () {

        });
    })

/*
 * Handle checkout payment step
 */
    $('#payment-form').submit(function (event) {
        var $form = $(this);
        if (!$form.valid())
            return false;
        completeStep('#payment-panel');
        event.preventDefault();
    })
    
   
    $('#confirm-address-form').submit(function (event) {
        var $form = $(this);
        /*
         *  Here we would have to copy the cc data from the imput form 
         *  to hidden fields or build up a non form URL 
         *  Not doing it now beacuse we are not going to submit the 
         *  data on this demo
         */
       
        event.preventDefault();
        var myUrl = $(this).attr('action');
        var formValues = $(this).serialize();
        $.post(myUrl, formValues, function (data) {
            // Replace the page html data. We no longer want to do anything 
            // with the order.
            $('html').replaceWith(data.html());
        }).fail(function (jqXHR) {
            failStep();
            return false;
        }).always(function () {

        });
    })
   
    
    // This deals with a bootstrap isue. If you don't do this
    // the code can only toggle  the panel state not set it
    $(document).ready(function() {
    $('#shipping-panel-body').collapse({'toggle': false});
    $('#payment-panel-body').collapse({'toggle': false});
    $('#billing-panel-body').collapse({'toggle': false});
    $('#confirm-panel-body').collapse({'toggle': false});
});
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
 * Given the current checkpout panel name, close that panel, open the next 
 * step panel and make that open panel active.
 */
function completeStep(currentStep)
{
    // Collapse all the  panels
    
     $(".panel-body").each(function () {
     $(this).collapse("hide");
     });
    
    nextPanel = navigateCheckout(currentStep);
    nextPanelObj = $(nextPanel);
    // Enable next step panel
    $(nextPanelObj).find(".panel-title a").removeAttr('disabled');
    // Show next step panel
    $(nextPanelObj).find(".panel-body").collapse('show');
    $('.storeMsg').hide();
}

/* 
 * Give the name of a panel return the name of the panel that
 * will handle the next step of the checkout process.
 */
function navigateCheckout(currentStep)
{
    switch (currentStep) {
        case '#billing-panel':
            return '#shipping-panel';
        case '#shipping-panel':
            return '#payment-panel';
        case '#payment-panel':
            return '#confirm-panel';
    }
}

/*
 * Show an error message for a failed checkout step
 */
function failStep()
{
    $('.storeMsg').show().html("An error occured. Please try later");
}
;
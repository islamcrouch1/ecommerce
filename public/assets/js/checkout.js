$(document).ready(function(){
    getStates();
    $("input[name=shipping_option][value=" + 1 + "]").prop('checked', true);
});


$('.country-select').on('change' , function(e){
    e.preventDefault();
    getStates();
});


$('.state-select').on('change' , function(e){
    e.preventDefault();
    getCities();
});


$('.city-select').on('change' , function(e){
    e.preventDefault();
    calculateShipping();
});


$('input[name="shipping_option"]').on('change' , function(e){
    e.preventDefault();
    var value = $('input[name="shipping_option"]:checked').val();
    if(value == '2'){
        $('.select-branch').show();
        $('.select-branch-input').attr('required' , true);
        calculateShipping();
    }else if(value == '1'){
        $('.select-branch').hide();
        $('.select-branch-input').attr('required' , false);
        calculateShipping();
    }
});


$('.coupon-link').on('click' , function(e){
    e.preventDefault();
    $('.coupon-field').toggle();
});


$('.coupon-apply').on('click' , function(e){
    e.preventDefault();
    calculateShipping();
});

$('.coupon-remove').on('click' , function(e){
    e.preventDefault();
    $('.coupon-code').val('');
    $(".coupon-code").removeAttr('disabled');
    $('.coupon-text').html();
    $('.coupon-apply').removeClass("disabled")
    $('.coupon-remove').hide();
    $('.coupon-submit').val('');
    calculateShipping();
});


$('input[name="create_account"]').on('change' , function(e){
    e.preventDefault();
    if(this.checked) {
        $('.checkout-password').show();
        $('.checkout-password-password').attr('required' , true);
        $('.checkout-password-password-confirm').attr('required' , true);

    }else{
        $('.checkout-password').hide();
        $('.checkout-password-password').attr('required' , false);
        $('.checkout-password-password-confirm').attr('required' , false);
    }
});




function getStates(){

    var country_id = $('.country-select').find(":selected").data('country_id');
    var url = $('.country-select').data('url');

    var formData = new FormData();

    formData.append('country_id' , country_id );

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data.status == 1){

                $('.state-select').children().remove().end()

                var array = data.states;
                array.forEach(element => {
                    $('.state-select').append(
                        `<option data-state_id="`+ element.id +`" value="`+ element.id +`">`+ (data.locale == 'ar' ? element.name_ar : element.name_en) +`</option>`
                    )
                });

                getCities()

            }else{
                $('.state-select').children().remove().end()
            }

        }
    });


}


function getCities(){

    var state_id = $('.state-select').find(":selected").data('state_id');
    var url = $('.state-select').data('url');

    var formData = new FormData();

    formData.append('state_id' , state_id );

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data.status == 1){

                $('.city-select').children().remove().end()

                var array = data.cities;
                array.forEach(element => {
                    $('.city-select').append(
                        `<option data-city_id="`+ element.id +`" value="`+ element.id +`">`+ (data.locale == 'ar' ? element.name_ar : element.name_en) +`</option>`
                    )
                });

                calculateShipping()

            }else{
                $('.city-select').children().remove().end()
            }

        }
    });
}



function calculateShipping(){

    var country_id = $('.country-select').find(":selected").data('country_id');
    var state_id = $('.state-select').find(":selected").data('state_id');
    var city_id = $('.city-select').find(":selected").data('city_id');
    var url = $('.country-select').data('url_shipping');
    var coupon = $('.coupon-code').val();


    // console.log(country_id , state_id , city_id , url , coupon);

    var formData = new FormData();

    formData.append('country_id' , country_id );
    formData.append('state_id' , state_id );
    formData.append('city_id' , city_id );
    formData.append('coupon' , coupon );

    $('.coupon-apply').addClass( "disabled" )
    $('.coupon-text').html('');
    $('.coupon-text').removeClass('coupon-text-green');


    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            // console.log(data);

            $('.coupon-apply').removeClass( "disabled" )



            if(data.status == 1){


                if(data.coupon_status == 1){

                    if(data.locale == 'ar'){
                        text_2 = 'تم تفعيل الكوبون ، استمتع باعلى نسبة خصم يمكن تطبيقها على طلبك';
                    }else{
                        text_2 = 'Coupon has been activated, enjoy the highest discount rate that can be applied to your order';
                    }

                    $('.coupon-text').html(text_2);
                    $('.coupon-code').attr('disabled','disabled');
                    $('.coupon-apply').addClass( "disabled" )
                    $('.coupon-text').addClass('coupon-text-green');
                    $('.coupon-remove').show();
                    $('.coupon-submit').val($('.coupon-code').val());



                }

                if(data.coupon_status == 0 || data.coupon_status == 14){

                    if(data.locale == 'ar'){
                        text_2 = 'الكود المستخدم غير صالح';
                    }else{
                        text_2 = 'Promo code not valid';
                    }

                    $('.coupon-code').val('');
                    $('.coupon-text').html(text_2);

                }

                if(data.coupon_status == 12){

                    if(data.locale == 'ar'){
                        text_2 = 'يرجى تسجيل الدخول لاستخام اكواد الخصم';
                    }else{
                        text_2 = 'Please login to use promo code';
                    }

                    $('.coupon-code').val('');
                    $('.coupon-text').html(text_2);

                }

                if(data.coupon_status == 13){

                    if(data.locale == 'ar'){
                        text_2 = 'لقد تعديت الحد الاقصى لاستخدام هذا الكوبون';
                    }else{
                        text_2 = 'You have exceeded the maximum limit for using this coupon';
                    }

                    $('.coupon-code').val('');
                    $('.coupon-text').html(text_2);

                }

                if(data.coupon_status == 15){

                    if(data.locale == 'ar'){
                        text_2 = 'عسل';
                    }else{
                        text_2 = 'honey';
                    }

                    $('.coupon-code').val('');
                    $('.coupon-text').html(text_2);

                }

                var value = $('input[name="shipping_option"]:checked').val();

                if(value == '1'){
                    $('.shipping-amount').text(data.shipping_amount + data.currency);
                    $('.checkout-total').text((data.shipping_amount+data.total) + data.currency);
                }else if(value == '2'){

                    $('.checkout-total').text((data.total) + data.currency);
                }else{
                    $('.shipping-amount').text(data.shipping_amount + data.currency);
                    $('.checkout-total').text((data.total) + data.currency);

                }

            }else if(data.status == 2){


                $('.shipping-option-1').hide();

                $('.alarm').show();

                var text = '';
                var text_2 = '';


                if(data.locale == 'ar'){
                    text = 'هناك منتجات في السلة يجب عليك استلامها من الفرع اذا كان هناك منتجات اخرى يمكنك طلبها في طلب منفصل او استلام الطلب كامل من الفرع';
                    text_2 = 'استلام من الفرع';
                }else{
                    text = 'There are products in the cart that you must collect from the branch. If there are other products, you can order them in a separate request or collect the entire order from the branch';
                    text_2 = 'Local Pickup';
                }


                var div = `<div class="shopping-option shipping-option-2">
                                <input value="2" type="radio" name="shipping_option"
                                id="local_pickup" required>
                                <label for="local-pickup">`+text_2+`</label>
                            </div>`;


                $('.alarm-text').text( text + ' - ' + data.product_name )

                // var value_1 = $('input[name="shipping_option"]:first').val();
                // var value_2 = $('input[name="shipping_option"]:second').val();

                // if(value_1 != 2 || value_2 != 2){
                //     $('.shipping').prepend(div);
                // }

                $('.shipping').prepend(div)
                $('.select-branch').show();
            }

        }
    });

}


$('.btn').on('click' , function(e){

    e.preventDefault

    var check = 0;

    $(this).closest('form').find('input').each(function() {
        if ($(this).prop('required') && $(this).val() == '' ) {
            check++;
        }
    });

      if(check == 0){
        $(this).closest('form').submit(function () {
            $('.btn').attr("disabled", true);
        });
    }


});


$('.size-box ul li').on('click', function (e) {
    var attribute_id = $(this).data('attribute-id');
    $(".attribute-box-"+ attribute_id +" ul li").removeClass("active");
    $('#selectSize').removeClass('cartMove');
    $(this).addClass("active");
    $(this).parent().addClass('selected');
});


$('.attribute-select').on('click' , function(e){

    e.preventDefault();

    var variations = [];
    var product_id = $(this).data('product-id');
    var url = $(this).data('url');
    var locale = $(this).data('locale');
    var price_tag = '.ecommerce-product-price-' + product_id;
    var currency = $(this).data('currency');



    $(".product-attributes-"+ product_id+ " .active").each(function() {
        variations.push($(this).data('variation-id'));
    });


    var formData = new FormData();

    formData.append('variations' , variations );
    formData.append('product_id' , product_id );


    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data == 1){

                if(locale == 'ar'){
                    $(price_tag).html('يرجى تحديد جميع الخيارات');
                }else{
                    $(price_tag).html('please select all options');
                }

            }else if(data == 2){

                if(locale == 'ar'){
                    $(price_tag).html('حدث خطا اثناء تحديد السعر');
                }else{
                    $(price_tag).html('error ocured when try to get price');
                }

            }else{

                $(price_tag).html('');

                if(data.discount_price == 0){
                    var append_data = `<h4>`+ data.sale_price + currency + `</h4>`;
                }else{
                    var append_data = `<h4><del>`+ data.sale_price + currency + `</del>` + data.discount_price + ` ` + currency + `</h4>`;
                }

                $(price_tag).append(append_data);

            }

        }
    });
});


$(document).ready(function(){

    $("#show-pass").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });



});


$('.review-btn').on('click' , function(e){

    e.preventDefault

    var rating = $('#rate').attr('data-rating');
    $('#rating').val(rating)

    var check = 0;

    $(this).closest('form').find('input').each(function() {
        if ($(this).prop('required') && $(this).val() == '' ) {
            check++;
        }
    });

      if(check == 0){
        $(this).closest('form').submit(function () {
            $('.btn').attr("disabled", true);
        });
    }


});




$('.quantity-right-plus').on('click', function () {

    var $qty = $(".qty-input");
    var max = $qty.data('max');
    var currentVal = parseInt($qty.val());
    if (!isNaN(currentVal) && currentVal < max) {
        $qty.val(currentVal + 1);
    }
});
$('.quantity-left-minus').on('click', function () {
    var $qty = $(".qty-input");
    var min = $qty.data('min')

    var _val = $($qty).val();
    if (_val == '1') {
        var _removeCls = $(this).parents('.cart_qty');
        $(_removeCls).removeClass("open");
    }
    var currentVal = parseInt($qty.val());
    if (!isNaN(currentVal) && currentVal > 0 && currentVal > min) {
        $qty.val(currentVal - 1);
    }
});



$('.add-to-cart').on('click', function (e) {


    e.preventDefault();
    var url = $(this).data('url');
    var locale = $(this).data('locale');
    var product_id = $(this).data('product_id');
    var loader = '.spin-' + product_id;
    var $qty = $(".qty-input");
    var currentVal = parseInt($qty.val());

    var cart_icon = '.cart-icon-' + product_id;
    var cart_text = '.cart-text-' + product_id;
    var cart_added = '.cart-added-' + product_id;

    if(isNaN(currentVal)){
        currentVal = 1;
    }

    var variations = [];

    var alarm = '.alarm' ;
    var alarm_text = '.alarm-text';



    $(".product-attributes-"+ product_id+ " .active").each(function() {
        variations.push($(this).data('variation-id'));
    });


    $(alarm).css('display', 'none');
    $(loader).show();
    $(cart_icon).hide()



    var formData = new FormData();


    formData.append('variations' , variations );
    formData.append('product_id' , product_id );
    formData.append('qty' , currentVal );

    $('.add-to-cart').addClass( "disabled" )


    console.log(variations , product_id , currentVal);


    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            console.log(data);

            if(data.status == 1){

            $(loader).hide();
            $(cart_icon).show()
            $('.cart-empty').text(' ');

            $('.pay-now').show();



            $(cart_added).show()
            $(cart_text).hide()
            $('.cart-noty').addClass("show");
            setTimeout(function () {
                $(cart_added).hide()
                $(cart_text).show()
                $('.cart-noty').removeClass("show");
            }, 5000);








            $(".cart-count").text(parseInt($(".cart-count").text()) + 1);


            var text1 = '';
            var text2 = '';

            if(locale == 'ar'){
                text1 = 'سعر المنتج: ';
                text2 = 'الكمية: ';
            }else{
                text1 = 'price: ';
                text2 = 'quantity: ';
            }




            var append_data = `<li>
            <div class="media">
                <a
                    href="`+ data.product_url +`"><img
                        alt="" class="me-3"
                        src="`+ data.product_image +`"></a>
                <div class="media-body">
                    <a
                        href="`+ data.product_url +`">
                        <h4>`+ data.product_name +`
                        </h4>
                    </a>
                        <h4><span>`+ text1 + data.product_price +`</span>
                        </h4>
                    <h4><span>`+ text2 + data.qty +`</span>
                    </h4>
                </div>
            </div>
            <div class="close-circle"><a
                    href="`+ data.destroy +`"><i
                        class="fa fa-times" aria-hidden="true"></i></a>
            </div>
        </li>`;



        $('.shopping-cart').prepend(append_data);


        var count = parseInt($(".cart-count").text());

        if(count == 1){
            $('.cart-buttons').show()
        }


        $(".cart-subtotal").text(parseInt($(".cart-subtotal").text()) + (parseInt(data.qty) * parseInt(data.product_price)));





        $('.add-to-cart').removeClass( "disabled" )


            }else if(data.status == 3){

                $(loader).hide();
                $('.cart-icon').show()

                if(locale == 'ar'){
                    $(alarm_text).html("يرجى تحديد جميع الخيارات")
                }else{
                    $(alarm_text).html("please select all options")
                }

                $(alarm).css('display', 'flex');
                $('.add-to-cart').removeClass( "disabled" )


            }else if(data.status == 2){

                $(loader).hide();
                $('.cart-icon').show()

                if(locale == 'ar'){
                    $(alarm_text).html("الكمية المطلوبة غير متاحه حاليا")
                }else{
                    $(alarm_text).html("The requested quantity not available")
                }

                $(alarm).css('display', 'flex');
                $('.add-to-cart').removeClass( "disabled" )

            }
        }
    })










    if ($("#selectSize .size-box ul").hasClass('selected')) {

    } else {
        $('#selectSize').addClass('cartMove');
    }
});




$('.add-fav').on('click' , function(e){

    e.preventDefault();
    var url = $(this).data('url');
    var fav = '.fav-' + $(this).data('product_id');

    $.ajax({
        url: url,
        method: 'GET',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
            console.log(data)
            if(data == 1){
                $(fav).css("color", "#f01c1c");
                $('.fav-noty').addClass("show");
                setTimeout(function () {
                    $('.fav-noty').removeClass("show");

                }, 5000);
            }
            if(data == 2){
                $(fav).css("color", "#ffffff");
            }
        }
    });
});



$('.cart-quantity').on('click' , function(e){

    e.preventDefault();


    var url = $(this).data('url');
    var quantity = parseInt($(this).val());



    var formData = new FormData();
    formData.append('quantity' , quantity);

    console.log(quantity);

    var qty = $(this);

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            console.log(parseInt(data));
            qty.val(parseInt(data));

        }

    });



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

    calculateShipping()

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





$(document).ready(function(){
    getStates()



});

function calculateShipping(){

    var country_id = $('.country-select').find(":selected").data('country_id');
    var state_id = $('.state-select').find(":selected").data('state_id');
    var city_id = $('.city-select').find(":selected").data('city_id');
    var url = $('.country-select').data('url_shipping');

    var formData = new FormData();

    formData.append('country_id' , country_id );
    formData.append('state_id' , state_id );
    formData.append('city_id' , city_id );

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            console.log(data);

            if(data.status == 1){

                var value = $('input[name="shipping_option"]:checked').val();

                if(value == '1'){
                    $('.shipping-amount').text(data.shipping_amount + data.currency);
                    $('.checkout-total').text((data.shipping_amount+data.total) + data.currency);
                }else if(value == '2'){
                    $('.checkout-total').text((data.total) + data.currency);
                }else{
                    $('.shipping-amount').text(data.shipping_amount + data.currency);

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



function mouseDown() {
    $('.price-range').closest('form').submit();
    console.log(35354454334535);
}



$(".price-range").mouseup(function() {
    $('.price-range').closest('form').submit();
    console.log(35354454334535);
  });

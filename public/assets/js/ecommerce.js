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


$('.filter').change(function(){
    $('.product-form').submit();
});




// $(".price-filter").click(function() {
//     $('.product-form').submit();
// });

$(".price-range").mouseup(function() {
    $('.product-form').submit();
});

$('.color-selector ul li').on('click', function (e) {
    // $(".color-selector ul li").removeClass("active");
    $(this).toggleClass("active");
});

// $(".color-li").click(function() {
//     $(this).toggleClass('active');
// });


$('.size-box ul li').on('click', function (e) {
    var attribute_id = $(this).data('attribute-id');
    $(".attribute-box-"+ attribute_id +" ul li").removeClass("active");
    $('#selectSize').removeClass('cartMove');
    $(this).addClass("active");
    $(this).parent().addClass('selected');
});

$('.size-box select').on('change', function (e) {
    var attribute_id = $(this).find(":selected").data('attribute-id');

    if(attribute_id){
        var option = ".attribute-box-"+ attribute_id +" select option";
        $(option).removeClass("active");
        $('#selectSize').removeClass('cartMove');
        $(this).find(":selected").addClass("active");

        var product_id = $(this).find(":selected").data('product-id');
        var url = $(this).find(":selected").data('url');
        var locale = $(this).find(":selected").data('locale');
        var currency = $(this).find(":selected").data('currency');

        // console.log(product_id , url ,locale, currency);

        getPrice(product_id , url ,locale, currency);

    }else{
        $("select option").removeClass("active");

    }
    // $(this).parent().addClass('selected');
});



$('.attribute-select').on('click' , function(e){

    e.preventDefault();

    var product_id = $(this).data('product-id');
    var url = $(this).data('url');
    var locale = $(this).data('locale');
    var currency = $(this).data('currency');


    getPrice(product_id , url ,locale, currency);


    getInstallmentPrice();




});


function getPrice(product_id , url ,locale, currency){


    var price_tag = '.ecommerce-product-price-' + product_id;

    var variations = [];

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

                // console.log(data)

                var append_data = data;


                // if(data.discount_price == 0){
                //     var append_data = `<h4>`+ data.sale_price + currency + `</h4>`;
                // }else{
                //     var append_data = `<h4><del>`+ data.sale_price + currency + `</del>` + data.discount_price + ` ` + currency + `</h4>`;
                // }

                $(price_tag).append(append_data);

            }

        }
    });




}


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


$('.review-order-btn').on('click' , function(e){

    e.preventDefault

    const elements = document.querySelectorAll('.rate');

    var check = 0;

    elements.forEach((element) => {

        var rating = $(element).attr('data-rating');
        var field = '.rating-' + $(element).data('order') + '-' + $(element).data('product');
        $(field).val(rating)

        console.log(rating , field);


        $(element).closest('form').find('input').each(function() {
            if ($(this).prop('required') && $(this).val() == '' ) {
                check++;
            }
        });

    });


    if(check == 0){
        $(element).closest('form').submit(function () {
            $('.btn').attr("disabled", true);
        });
    }
});




$('.quantity-right-plus').on('click', function () {

    var $qty = $(this).parent('span').parent('div').find('.qty-input');
    var max = $qty.data('max');
    var currentVal = parseInt($qty.val());
    if (!isNaN(currentVal) && currentVal < max) {
        $qty.val(currentVal + 1);
    }
});
$('.quantity-left-minus').on('click', function () {
    var $qty = $(this).parent('span').parent('div').find('.qty-input');
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
    var can_rent = $(this).data('rent');
    var product_id = $(this).data('product_id');
    var loader = '.spin-' + product_id;
    var $qty = $(".qty-input");
    var currentVal = parseInt($qty.val());

    var cart_icon = '.cart-icon-' + product_id;
    var cart_text = '.cart-text-' + product_id;
    var cart_added = '.cart-added-' + product_id;

    var from = '.from-' + product_id;
    var to = '.to-' + product_id;

    if(isNaN(currentVal)){
        currentVal = 1;
    }

    var variations = [];

    var alarm = '.alarm-' + product_id ;
    var alarm_text = '.alarm-text-' + product_id;



    $(".product-attributes-"+ product_id+ " .active").each(function() {
        variations.push($(this).data('variation-id'));
    });

    // console.log(variations);

    $(alarm).css('display', 'none');
    $(loader).show();
    $(cart_icon).hide()


    from = $(from).val();
    to = $(to).val();

    var formData = new FormData();


    formData.append('variations' , variations );
    formData.append('product_id' , product_id );
    formData.append('qty' , currentVal );
    formData.append('from' , from );
    formData.append('to' , to );
    formData.append('can_rent' , can_rent );

    $('.add-to-cart').addClass( "disabled" )


    // console.log(variations , product_id , currentVal);


    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            //  console.log(data);

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


        $(".cart-subtotal").text(parseFloat($(".cart-subtotal").text()) + (parseInt(data.qty) * parseFloat(data.product_price)));



        $('.add-to-cart').removeClass( "disabled" )


            }else if(data.status == 3){

                $(loader).hide();
                $(cart_icon).show()

                if(locale == 'ar'){
                    $(alarm_text).html("يرجى تحديد جميع الخيارات")
                }else{
                    $(alarm_text).html("please select all options")
                }


                $(alarm).css('display', 'flex');
                setTimeout(function () {
                    $(alarm).css('display', 'none');
                }, 5000);
                $('.add-to-cart').removeClass( "disabled" )


            }else if(data.status == 2){

                $(loader).hide();
                $(cart_icon).show()

                if(locale == 'ar'){
                    $(alarm_text).html("الكمية المطلوبة غير متاحه حاليا")
                }else{
                    $(alarm_text).html("The requested quantity not available")
                }

                $(alarm).css('display', 'flex');
                setTimeout(function () {
                    $(alarm).css('display', 'none');
                }, 5000);
                $('.add-to-cart').removeClass( "disabled" )

            }else{
                $('.add-to-cart').removeClass( "disabled" )

            }
        }
    })










    if ($("#selectSize .size-box ul").hasClass('selected')) {

    } else {
        $('#selectSize').addClass('cartMove');
    }
});



$('.rent-date').on('input', function (e) {


    e.preventDefault();
    var url = $(this).data('url');
    var product_id = $(this).data('product_id');
    var from = '.from-' + product_id;
    var to = '.to-' + product_id;
    var end = '.end-' + product_id;

    var $qty = $(".qty-input");
    var currentVal = parseInt($qty.val());

    if(isNaN(currentVal)){
        currentVal = 1;
    }

    var fromDate = $(from).val();
    var toDate = $(to).val();

    console.log(fromDate,toDate);

    var formData = new FormData();

    formData.append('product_id' , product_id );
    formData.append('qty' , currentVal );
    formData.append('from' , fromDate );
    formData.append('to' , toDate );

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data.status == 1){
                $(to).val(data.end);
            }else{

                console.log(data)

                $('.days-'+ product_id).html(data.days);
                $('.vat-'+ product_id).html(data.vat);
                $('.total-'+ product_id).html(data.total);
                $(end).val(data.end);
                // $(to).val(data.days);


            }
        }
    })
});


// $('#passport').on('change', function (e) {
//     if ($('#passport')[0].files.length > 0) {
//         $('#id').prop('required', false);
//       }
// });

// $('#id').on('change', function (e) {
//     if ($('#id')[0].files.length > 0) {
//         $('#passport').prop('required', false);
//       }
// });

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
            // console.log(data)
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



$('.quantity-left-minus').on('click' , function(e){

    e.preventDefault();

    var element = $(this).parent('span').parent('div').find('.qty-input');
    var url = element.data('url');
    var quantity = parseInt(element.val());
    var span = '.total-' + element.data('id');
    var currency = element.data('currency');
    var total = '.cart-total';
    var discount = '.cart-discount';


    var formData = new FormData();
    formData.append('quantity' , quantity);

    // console.log(quantity);

    var qty = element;

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            // console.log(parseInt(data.qty));
            qty.val(parseInt(data.qty));
            $(span).html(parseInt(data.qty) * (parseFloat(data.product_price).toFixed(2)) + currency);
            $(total).html(parseFloat(data.total).toFixed(2) + currency);
            $(discount).html(parseFloat(data.discount).toFixed(2) + currency);

        }

    });



});

$('.quantity-right-plus').on('click' , function(e){

    e.preventDefault();

    var element = $(this).parent('span').parent('div').find('.qty-input');
    var url = element.data('url');
    var quantity = parseInt(element.val());
    var span = '.total-' + element.data('id');
    var currency = element.data('currency');
    var total = '.cart-total';
    var discount = '.cart-discount';



    var formData = new FormData();
    formData.append('quantity' , quantity);

    // console.log(quantity);

    var qty = element;

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            // console.log(parseInt(data.qty));
            qty.val(parseInt(data.qty));
            $(span).html(parseInt(data.qty) * (parseFloat(data.product_price).toFixed(3)) + currency);
            $(total).html(parseFloat(data.total).toFixed(2) + currency);
            $(discount).html(parseFloat(data.discount).toFixed(2) + currency);

        }

    });



});





// function mouseDown() {
//     $('.price-range').closest('form').submit();
//     console.log(35354454334535);
// }






function openSearch() {
    document.getElementById("search-overlay").style.display = "block";
}

function closeSearch() {
    document.getElementById("search-overlay").style.display = "none";
}




$('.search-input').focusout( function(e){
    e.preventDefault();
    if($('.search-result:hover').length != 0){
        $('.search-result').show()

    }else{
        $('.search-result').hide()

    }
});


$('.search-input').focus( function(e){
    e.preventDefault();
    $('.search-result').show()
});


$('.search-input').on('input' , function(e){
    e.preventDefault();
    var search = $(this).val();
    var url = $(this).data('url');
    var locale = $(this).data('locale');
    var result_class = '.search-result';

    // console.log(search , url , locale , 500)

    if(search != ''){
        getSearch(search , locale , url , result_class)
    }else{
        $(result_class).children().remove().end()
    }
});




function getSearch(search , locale , url , result_class) {


    var search = search;
    var locale = locale;
    var url = url;
    var result_class = result_class;
    var formData = new FormData();
    formData.append('search' , search);
    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
            if(data.status == 1){

                $(result_class).children().remove().end()
                $(result_class).show()
                var array = data.elements;
                if(array.length == 0){
                    $(result_class).append(
                        '<div class="empty-message">'+(locale == 'ar' ? 'لا توجد نتائج بحث!' : 'No results found!')+'</div>'
                    )
                }else{
                    array.forEach(element => {
                        $(result_class).append(
                            `<a style="padding:10px;" href='`+element.url+`' class="man-section">
                                <div class="image-section">
                                    <img src="` + element.image + `">
                                </div>

                                <div class="description-section">
                                    <h4>`+ (locale == 'ar' ? element.name_ar : element.name_en) +`
                                    </h4>
                                </div>
                            </a>`
                        )
                    });
                }

            }else{
                $(result_class).children().remove().end()

                $(result_class).append(
                    '<p>' + (locale == 'ar' ? 'لا توجد نتائج بحث!' : 'No results found!') + '</p>'
                )
            }
        }
    });
}



$('.phone').on("input" , function(e){


    digits = $(this).data('phone_digits');
    value = this.value;
    var filter = /\D/g;


    if (!filter.test(value) && value.length == digits) {




        $(this).css('border', '1px solid green');
    }
    else {


        this.value = this.value.replace(/\D/g, '');


        $(this).css('border', '1px solid red');
    }
});


$('input[name="company"]').on('change' , function(e){
    e.preventDefault();
    var company_id = $('input[name="company"]:checked').val();
    getMonths(company_id);
    getInstallmentPrice();

});


$('.months-select').on('change' , function(e){
    e.preventDefault();
    getInstallmentPrice();
});


$('.advanced-amount').on('input' , function(e){
    e.preventDefault();
    getInstallmentPrice();
});

function getInstallmentPrice() {

    var product_id = $('.data').data('product_id');
    var url = $('.data').data('price_url');






    var variations = [];
    $(".product-attributes-"+ product_id+ " .active").each(function() {
        variations.push($(this).data('variation-id'));
    });




    var formData = new FormData();
    formData.append('product_id' , product_id );

    for (var i = 0; i < variations.length; i++) {
        formData.append('variations[]', variations[i]);
      }


    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            console.log(data.combination);

            if(data.combination){
                $('.combination_id').val(data.combination);
            }

            getInstallmentData(data.price);
        }
    });





}



function getInstallmentData(price) {


    var company_id = company_id;
    var price = price;

    var locale = $('.data').data('locale');
    var currency = $('.data').data('currency');

    var url = $('input[name="company"]:checked').data('installment_url');

    var type = $('input[name="company"]:checked').data('type');
    var admin_expenses = $('input[name="company"]:checked').data('admin_expenses');
    var amount = $('input[name="company"]:checked').data('amount');

    var advanced_amount = $('.advanced-amount').val();
    var months = $('.months-select').find(":selected").val();


    var company_id = $('input[name="company"]:checked').val();


    var formData = new FormData();
    formData.append('company_id' , company_id );
    formData.append('type' , type );
    formData.append('admin_expenses' , admin_expenses );
    formData.append('amount' , amount );
    formData.append('advanced_amount' , advanced_amount );
    formData.append('type' , type );
    formData.append('months' , months );
    formData.append('price' , price );


    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data.status == 1){
                $('.admin_expenses').html(data.admin_expenses + ' ' + currency);
                $('.monthly_installment').html(data.installment_month + ' ' + currency);
            }else{
                $('.admin_expenses').html(0 + ' ' + currency);
                $('.monthly_installment').html(0 + ' ' + currency);
            }

        }
    });


}


function getMonths(company_id) {


    var company_id = company_id;
    var url = $('.data').data('months_url');

    var formData = new FormData();
    formData.append('company_id' , company_id );

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data.status == 1){


                $('.months-select').children().remove().end()


                $('.months-select').append(
                    `<option value="">`+(data.locale == 'ar' ? 'حدد مدة التقسيط' : 'select installment period') +`</option>`
                )
                var array = data.months;
                array.forEach(element => {
                    $('.months-select').append(
                        `<option value="`+ element +`">`+ element + ' ' +  (data.locale == 'ar' ? 'شهور' : 'months') +`</option>`
                    )
                });

            }else{
                $('.months-select').children().remove().end()
            }

        }
    });


}

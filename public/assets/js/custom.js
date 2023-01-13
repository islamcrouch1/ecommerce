$(document).ready(function(){


    $('.colorpicker').colorpicker();

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


    $('.sonoo-search').change(function(){
        $(this).closest('form').submit();
    });

    $('.sonoo-form').change(function(){
        $(this).closest('form').submit();
    });


    $('#copy').click(function(){
        copyLink();
    });


    // display hex color input when select color attribute
    $('.attribute-select').on('change', function() {
        var text = $(this).find(":selected").data('text');
        if(text == "color" || text == "colors" || text == "Color" || text == "Colors") {
            $('.color-hex').show();
        }else{
            $('.color-hex').hide();
        }
    });


    // display digital file input when select cproduct type digital
    $('.product-type').on('change', function() {
        var type = $(this).find(":selected").val();

        $('.p-variation').hide();


        if(type == "digital") {
            $('.digital-file').show();
        }else{
            $('.digital-file').hide();
        }

        if(type == "simple" || type == "variable") {
            $('.product-weight').show();
        }else{
            $('.product-weight').hide();
        }

        if(type == "variable") {
            $('.product-attributes').show();
        }else{
            $('.product-attributes').hide();
        }



    });


        // display home page slider inputs when select homepage slider
        $('.select-slider').on('change', function() {
            var type = $(this).find(":selected").val();

            if(type == "3") {
                $('.text-1-ar').show();
                $('.text-2-ar').show();
                $('.text-1-en').show();
                $('.text-2-en').show();
                $('.text-button-ar').show();
                $('.text-button-en').show();

            }else{
                $('.text-1-ar').hide();
                $('.text-2-ar').hide();
                $('.text-1-en').hide();
                $('.text-2-en').hide();
                $('.text-button-ar').hide();
                $('.text-button-en').hide();
            }
        });


    // display product variations input when select product attribute
    $('.product-attribute-select').on('change', function() {

        $('.p-variation').hide();

         $('.product-attribute-select option').each(function() {
            $('.product-variations-'+ $(this).val()).show()
         });


    });


    // add flash news arabic
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="input-group mt-3"><input style="width:40%" class="form-control" type="text" name="flash_news_ar[]" value="" placeholder="arabic"/><input style="width:40%" class="form-control" type="text" name="flash_news_en[]" value="" placeholder="english" /><a href="javascript:void(0);" class="remove_button"><span class="input-group-text" id="basic-addon1"><span class="far fa-trash-alt text-danger fs-2"></span></span></a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


    function copyLink() {

        /* Get the text field */
        var copyText = document.getElementById("page-link");
        var locale = document.getElementById("locale");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

    }






    $(".img").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.img-prev').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]); // convert to base64 string
        }
    });



    $(".imgs").change(function() {
        if (this.files) {
            var filesAmount = this.files.length;
            $('#gallery').empty();
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var image = `
                                <img src="` + event.target.result + `" style="width:100px"  class="img-thumbnail img-prev">
                           `;
                    $('#gallery').append(image);
                }
                reader.readAsDataURL(this.files[i]);
            }
        }
    });



    $("#show-pass").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password svg').addClass( "fa-eye-slash" );
            $('#show_hide_password svg').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password svg').removeClass( "fa-eye-slash" );
            $('#show_hide_password svg').addClass( "fa-eye" );
        }
    });


    var startMinute = 1;
    var time = startMinute * 60;

    setInterval(updateCountdown , 1000);

    function updateCountdown(){
        var minutes = Math.floor(time / 60);
        var seconds = time % 60 ;
        seconds < startMinute ? '0' + seconds : seconds;
        $('.counter_down').html(minutes + ':' + seconds)
        if(minutes == 0 && seconds == 0){
            $('.resend').css('pointer-events' , 'auto');
        }else{
            time--;
        }
    }





    $('.add-fav').on('click' , function(e){

        e.preventDefault();
        var url = $(this).data('url');
        var fav = '.fav-' + $(this).data('id');

        $.ajax({
            url: url,
            method: 'GET',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if(data == 1){
                    $(fav).removeClass('far');
                    $(fav).addClass('fas');
                    $(".fav-icon").text(parseInt($(".fav-icon").text()) + 1);
                }
                if(data == 2){
                    $(fav).addClass('far');
                    $(fav).removeClass('fas');
                    $(".fav-icon").text(parseInt($(".fav-icon").text()) - 1);
                }
            }
        });
    });


    $('.cart-quantity').on('click' , function(e){

        e.preventDefault();

        var stock_id = $(this).data('stock_id');
        var input = '.quantity-' + stock_id ;

        var url = $(input).data('url');
        var quantity = $(input).val();

        var formData = new FormData();
        formData.append('quantity' , quantity);

        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if(data == 1){

                }
                if(data == 2){

                }
            }
        });
    });




});



function downloadAll() {
    var div = document.getElementById("allImages");
    console.log(div);
    var images = div.getElementsByTagName("img");
    console.log(images)

    for (i = 0; i < images.length; i++) {
        console.log(images[i]);
        downloadWithName(images[i].src, images[i].src);
    }
}

function downloadWithName(uri, name) {
    function eventFire(el, etype) {
        if (el.fireEvent) {
            (el.fireEvent('on' + etype));
        } else {
            var evObj = document.createEvent('MouseEvent');
            evObj.initMouseEvent(etype, true, false,
                window, 0, 0, 0, 0, 0,
                false, false, false, false,
                0, null);
            el.dispatchEvent(evObj);
        }
    }

    var link = document.createElement("a");
    link.download = name;
    link.href = uri;
    eventFire(link, "click");
}


$('.country-select').on('change' , function(e){
    e.preventDefault();
    getStates();
});



$(document).ready(function(){
    getStates();
});



function getStates(){

    var country_id = $('.country-select').find(":selected").data('country_id');
    var url = $('.country-select').data('url');
    var locale = $('.country-select').data('locale');

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

            console.log(data);

            if(data.status == 1){

                $('.state-select').children().remove().end()

                var array = data.states;
                array.forEach(element => {
                    $('.state-select').append(
                        `<option value="`+ element.id +`">`+ (locale == 'ar' ? element.name_ar : element.name_en) +`</option>`
                    )
                });

            }else{
                $('.state-select').children().remove().end()
            }

        }
    });
}




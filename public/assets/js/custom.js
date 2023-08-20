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


    $('.country-select').on('change' , function(e){
        e.preventDefault();
        getStates();
    });

    $('.state-select').on('change' , function(e){
        e.preventDefault();
        getCities();
    });

    $(document).ready(function(){
        getStates()
    });






    function getStates(){

        var country_id = $('.country-select').find(":selected").data('country_id');
        var url = $('.country-select').data('url');

        var selected_state = $('.state-select').find(":selected").data('selected_state');


        var formData = new FormData();

        formData.append('country_id' , country_id );
        formData.append('selected_state' , selected_state );

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


                        selected = element.id == selected_state ? 'selected' : '';

                        $('.state-select').append(
                            `<option data-state_id="`+ element.id +`" value="`+ element.id +`" `+ selected +`>`+ (data.locale == 'ar' ? element.name_ar : element.name_en) +`</option>`
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

        var selected = $('.city-select').find(":selected").data('selected_city');

        var formData = new FormData();

        formData.append('state_id' , state_id );
        formData.append('selected' , selected );


        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {


                console.log(data , state_id , selected);


                if(data.status == 1){

                    $('.city-select').children().remove().end()

                    var array = data.cities;
                    array.forEach(element => {

                        selected_city = element.id == selected ? 'selected' : '';


                        $('.city-select').append(
                            `<option data-city_id="`+ element.id +`" value="`+ element.id +`" `+ selected_city +` >`+ (data.locale == 'ar' ? element.name_ar : element.name_en) +`</option>`
                        )
                    });

                    calculateShipping()

                }else{
                    $('.city-select').children().remove().end()
                }

            }
        });
    }


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
        $('.stock-status').on('change', function() {

            var type = $(this).find(":selected").val();
            var id =  $(this).data("id");

            if(type == "IN") {
                $('.discount_price-'+id).show();
                $('.purchase_price-'+id).show();
                $('.sale_price-'+id).show();
            }else{
                $('.discount_price-'+id).hide();
                $('.purchase_price-'+id).hide();
                $('.sale_price-'+id).hide();
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

        if(type == "digital" || type == "service") {
            $('.cost').show();
        }else{
            $('.cost').hide();
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


    // display digital file input when select cproduct type digital
    $('.offer-type').on('change', function() {

        var type = $(this).find(":selected").val();
        console.log(type);
        if(type == "product_quantity_discount") {
            $('.amount').show();
            $('.qty').show();
            $('.amount-field').attr('required' , true);
            $('.qty-field').attr('required' , true);

        }else{
            $('.amount').hide();
            $('.qty').hide();
            $('.amount-field').attr('required' , false);
            $('.qty-field').attr('required' , false);
        }

        if(type == "bundles_offer") {
            $('.amount').show();
            $('.amount-field').attr('required' , true);

        }else{
            $('.amount').hide();
            $('.amount-field').attr('required' , false);
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



    // add flash news arabic
    var maxFieldLink = 20; //Input fields increment limitation
    var addButtonLink = $('.add_button_link'); //Add button selector
    var wrapperLink = $('.field_wrapper_link'); //Input field wrapper
    var fieldHTMLLink = '<div class="input-group mt-3"><input style="width:25%" class="form-control" type="text" name="quick_links_ar[]" value="" placeholder="arabic"/><input style="width:25%" class="form-control" type="text" name="quick_links_en[]" value="" placeholder="english" /><input style="width:30%" class="form-control" type="text" name="quick_links_url[]" value="" placeholder="link" /><a href="javascript:void(0);" class="remove_button"><span class="input-group-text" id="basic-addon1"><span class="far fa-trash-alt text-danger fs-2"></span></span></a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButtonLink).click(function(){
        //Check maximum number of input fields
        if(x < maxFieldLink){
            x++; //Increment field counter
            $(wrapperLink).append(fieldHTMLLink); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapperLink).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


    // add accounts
    var maxField = 50; //Input fields increment limitation
    var addButton = $('.add_account'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter

            const  accounts = $('.div-data').data('accounts');
            var locale = $('.div-data').data('locale');
            var text1 = locale == 'ar' ? 'حدد الحساب' : 'select account';
            var text2 = '';


             accounts.forEach(function(element) {
                text2 += '<option value="'+ element.id +'">'+ (locale == 'ar' ? element.name_ar : element.name_en) +'</option>';
            });

            console.log(text2);




            var fieldHTML = `
            <div class="input-group mt-3">
                <select
                    class="form-select from-account-select"
                    aria-label="" name="accounts[]"  data-level="1"
                    required>
                    <option value="">`+ text1  +`</option>`+ text2 +`
                </select>
                <input name="dr_amount[]" class="form-control"  type="number"
                placeholder="`+ (locale == 'ar' ? 'مدين' : 'debit') +`" min="0" step="0.01" required />
                <input name="cr_amount[]" class="form-control"  type="number"
                placeholder="`+ (locale == 'ar' ? 'دائن' : 'credit') +`" min="0" step="0.01" required />
                <a href="javascript:void(0);" class="remove_button">
                    <span class="input-group-text" id="basic-addon1">
                        <span class="far fa-trash-alt text-danger fs-2"></span>
                    </span>
                </a>
            </div>`; //New input field html

            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


    $('.field_wrapper').on('change' , '.from-account-select' , function(e){
        e.preventDefault();
        var elem = $(this);
        getAccounts(elem , 'from');

    });


    function getAccounts(elem , dir){


        var url = $('.div-data').data('url');
        var locale = $('.div-data').data('locale');
        var account_id = elem.find(":selected").val();
        var account_name = elem.find(":selected").text();
        var level = elem.data('level');

        var formData = new FormData();
        formData.append('account_id' , account_id );
        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {

                if(data.status == 1){
                    for (var i = 20; i >= level; i--) {
                        $('.'+dir+'-account'+i).remove();
                      }

                    var array = data.elements;
                    if(array.length == 0){
                        return;
                    }
                    var options = '';

                    array.forEach(element => {
                        options += `<option value="`+element.id+`">
                                    `+element.name+`
                                    </option>`;
                    });

                    elem.parent().prepend(
                        `<select
                            class="form-select `+dir+`-account-select"
                            aria-label="" name="accounts[]" required>
                                <option value="">`+(locale == 'ar' ? 'حدد الحساب' : 'select account')+`</option>`
                            +options+
                        `</select>
                        `
                    );

                    elem.closest('.form-select').remove();



                }
            }
        });
    }



    // add fields
    var maxField = 1000; //Input fields increment limitation
    var addButton = $('.add_field'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper

    var x = 0; //Initial field counter is 1

    var level = $('.data-x').data('x');

    if(level){
        x = level;
    }

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields

        if(x < maxField){
            x++; //Increment field counter

            console.log(x);

            var locale = $(this).data('locale');

            var type = $('.select_type').find(":selected").val();


            switch(type) {
                case 'name':
                  typeTextAr = 'اسم' ;
                  typeTextEn = type ;
                  break;
                case 'text':
                    typeTextAr = 'نص' ;
                    typeTextEn = type ;
                case 'photo':
                    typeTextAr = 'صورة' ;
                    typeTextEn = type ;
                case 'number':
                    typeTextAr = 'رقم' ;
                    typeTextEn = type ;
                case 'checkbox':
                    typeTextAr = 'اختيار من متعدد' ;
                    typeTextEn = type ;
                case 'radio':
                    typeTextAr = 'اختيار واحد' ;
                    typeTextEn = type ;
                break;
                default:
                  // code block
              }

              var fieldHTMLOption = `<div style="display:none" class="col-md-2 mt-2">
                                        <input name="options[`+x+`][]" class="form-control" value="0" type="text"
                                             required />
                                    </div>`;
              var text8 = locale == 'ar' ? 'اضافة خيارات' : 'add options';


              if(type == 'checkbox' || type == 'radio'){
                fieldHTMLOption = `<div class="col-md-2 mt-2">
                                        <button href="javascript:void(0);" data-x="`+x+`" data-type="`+type+`" data-locale="`+locale+`"
                                            class="btn btn-outline-primary btn-sm add_option me-1 mb-1 mt-1"
                                            type="button">`+text8+`
                                        </button>
                                    </div>`;
              }

            var text1 = locale == 'ar' ? 'نوع الحقل' : 'field type';
            var text2 = locale == 'ar' ? 'الاسم عربي' : 'field name arabic';
            var text3 = locale == 'ar' ? 'الاسم انجليزي' : 'field name english';
            var text4 = locale == 'ar' ? 'نقاط الحقل' : 'field score';
            var text5 = locale == 'ar' ? 'حقل اجباري' : 'field required';
            var text6 = locale == 'ar' ? 'حذف' : 'delete';

            var text7 = locale == 'ar' ? typeTextAr : typeTextEn;



            var fieldHTML = `<div class="row div-`+x+`">

                                <div class="col-md-2 mt-2">
                                    <label class="form-label" for="field_name_en">`+text1+`</label>
                                    <input name="type[]" class="form-control stage-field" value="`+type+`" type="text"
                                         required disabled />
                                </div>

                                <div style="display:none" class="col-md-2 mt-2">
                                    <input name="level[]" class="form-control stage-field" value="`+x+`" type="text"
                                         required disabled />
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label class="form-label" for="field_name_ar">`+text2+`</label>
                                    <input name="field_name_ar[]" class="form-control"
                                        value="" type="text" autocomplete="on"
                                        id="field_name_ar" autofocus required />
                                </div>

                                <div class="col-md-3 mt-2">
                                    <label class="form-label" for="field_name_en">`+text3+`</label>
                                    <input name="field_name_en[]" class="form-control "
                                        value="" type="text" autocomplete="on"
                                        id="field_name_en" autofocus required />
                                </div>

                                <div class="col-md-1 mt-2">
                                    <label class="form-label" for="field_score">`+text4+`</label>
                                    <input name="field_score[]" class="form-control" value="0" min="0"
                                        type="number" autocomplete="on" id="field_score" autofocus required />
                                </div>

                                <div class="col-md-1 mt-2">
                                    <label class="form-label" for="is_required">`+text5+`</label>
                                    <div>
                                        <label class="switch">
                                            <input id="is_required" class="form-control " name="is_required[`+x+`][]"
                                                type="checkbox">
                                            <span class="slider round"></span>
                                        </label>

                                    </div>
                                </div>

                                <div class="col-md-1 mt-2">
                                    <label class="form-label" for="is_required">`+text6+`</label>
                                    <div>
                                        <a href="javascript:void(0);" data-x="`+x+`" class="remove_button m-2">
                                            <span id="basic-addon1">
                                                <span class="far fa-trash-alt text-danger fs-2"></span>
                                            </span>
                                        </a>
                                    </div>

                                </div>`+fieldHTMLOption+`

                            </div>`; //New input field html

            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        var x = $(this).data('x');
        $('.div-'+x).remove(); //Remove field html
        x--; //Decrement field counter
    });


    $('.field_wrapper').on('change' , '.from-account-select' , function(e){
        e.preventDefault();
        var elem = $(this);
        getAccounts(elem , 'from');

    });



    //Once add button is clicked
    $(wrapper).on('click', '.add_option', function(e){

        var locale = $(this).data('locale');
        var type = $(this).data('type');
        var x = $(this).data('x');
        var div = '.div-' + x;

        var text = locale == 'ar' ? 'اسم الخيار' : 'option name';

        var fieldHTML = `<div class="col-md-2 mt-2">
                            <label class="form-label" for="options">`+text+`</label>
                            <div class="input-group">
                                <input name="options[`+x+`][]" class="form-control"
                                        value="" type="text" autocomplete="on"
                                        id="options" autofocus required />
                                <a href="javascript:void(0);" class="remove_button_option">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="far fa-trash-alt text-danger fs-2"></span>
                                    </span>
                                </a>
                            </div>
                        </div>`; //New input field html

        $(div).append(fieldHTML); //Add field html

    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button_option', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });



    $('.submit-form').on('click' , function(e){

        e.preventDefault

        var check = 0;

        $(this).closest('form').find('input').each(function() {
            if ($(this).prop('required') && $(this).val() == '' ) {
                check++;
            }
        });

          if(check == 0){

            $('.stage-field').attr("disabled", false);

            $(this).closest('form').submit(function () {
                $('.btn').attr("disabled", true);
            });
        }


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

    $(".cover").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.img-prev-cover').css("background-image", "url(" + e.target.result + ")");
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


    $('.delete-media').on('click' , function(e){

        e.preventDefault();



        var media_id = $(this).data('media_id');
        var div = '.product-image-' + media_id ;
        var url = $(this).data('url');

        console.log(url , div , media_id);

        var formData = new FormData();
        formData.append('media_id' , media_id);

        $.ajax({
            url: url,
            data: formData,
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                console.log(data);

                if(data == 1){
                    $(div).remove();
                }
                if(data == 0){

                }
            }
        });
    });

    $('.stock-qty').on('change', function() {

        var value = $(this).val();
        console.log(value);

        $(".qty").each(function(){
            $(this).val(value);
       })

    });

    $('.stock-purchase_price').on('change', function() {

        var value = $(this).val();
        console.log(value);

        $(".purchase_price").each(function(){
            $(this).val(value);
       })

    });

    $('.stock-sale_price').on('change', function() {

        var value = $(this).val();
        console.log(value);

        $(".sale_price").each(function(){
            $(this).val(value);
       })

    });

    $('.stock-discount_price').on('change', function() {

        var value = $(this).val();
        console.log(value);

        $(".discount_price").each(function(){
            $(this).val(value);
       })

    });

    $('.stock-limit').on('change', function() {

        var value = $(this).val();
        console.log(value);

        $(".limit").each(function(){
            $(this).val(value);
       })

    });

    $('.stock-status_all').on('change', function() {

        var value = $(this).val();
        console.log(value);

        $(".status_all").each(function(){
            $(this).val(value).change();

       })

    });

});


$('.sonoo-search').change(function(){
    $(this).closest('form').submit();
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



$('.from-account').on('change' , '.from-account-select' , function(e){
    e.preventDefault();
    var elem = $(this);
    getAccounts(elem , 'from');

});

$('.to-account').on('change' , '.to-account-select' , function(e){
    e.preventDefault();
    var elem = $(this);
    getAccounts(elem , 'to');

});



function getAccounts(elem , dir){


    var url = elem.data('url');
    var locale = elem.data('locale');
    var account_id = elem.find(":selected").val();
    var account_name = elem.find(":selected").text();
    var level = elem.data('level');

    var formData = new FormData();
    formData.append('account_id' , account_id );
    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data.status == 1){
                for (var i = 20; i >= level; i--) {
                    $('.'+dir+'-account'+i).remove();
                  }

                var array = data.elements;
                if(array.length == 0){
                    return;
                }
                var options = '';

                array.forEach(element => {
                    options += `<option value="`+element.id+`">
                                `+element.name+`
                                </option>`;
                });

                $('.'+dir+'-account').append(
                    `<div class="mb-3 `+(dir+'-account'+level)+`">
                        <select
                            class="form-select `+dir+`-account-select"
                            aria-label="" name="`+dir+`_account" id="`+dir+`_account"
                            data-url="`+url+`" data-level="`+(level+1)+`" data-locale="`+locale+`"
                            required>
                            <option value="">`+(locale == 'ar' ? 'حدد الحساب' : 'select account')+`</option>`
                            +options+
                        `</select>
                    </div>`
                );

            }
        }
    });
}


function printInvoice(){

    $('.no-print').hide();
    window.print();
}



const elements = document.querySelectorAll('.model-search');

elements.forEach((element) => {

    var choices = new Choices(element , {"removeItemButton":true});
    element.addEventListener(
    'search',
    function(event) {


        var search = event.detail.value;
        var url = $(this).data('url');
        var locale = $(this).data('locale');
        var type = $(this).data('type');
        var field_type = $(this).data('field_type');
        var parent = $(this).data('parent');
        var account_type = $(this).data('account_type');
        var account_id = $(this).data('account_id');

        // var account_type = $('.acc-type').find(":selected").val();

        if(search == ''){
            choices.clearChoices();
        }

        var formData = new FormData();

        formData.append('search' , search );
        formData.append('type' , type );
        formData.append('field_type' , field_type );
        formData.append('parent' , parent );
        formData.append('account_type' , account_type );
        formData.append('account_id' , account_id );

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

                    choices.clearChoices();

                    var array = data.elements;

                    array.forEach(element => {
                        choices.setChoices(
                            [
                              { value: field_type == 'search' ? search : element.id , label: data.type  == 'untranslated' ? element.name : (locale == 'ar' ? element.name_ar : element.name_en) }

                            ],
                            'value',
                            'label',
                            false,
                          );
                    });

                }else{
                    choices.clearChoices();
                }

            }
        });

    },
    false,
  );

});




$('.insurance').on('input' , function(e){
    e.preventDefault();
    getSalary();
});

$('.penalties_amount').on('input' , function(e){
    e.preventDefault();
    getSalary();
});

$('.rewards_amount').on('input' , function(e){
    e.preventDefault();
    getSalary();
});




$('.loans').on('input' , function(e){
    e.preventDefault();
    getSalary();
});



function getSalary(){

    var salary = $('.salary_filed').val();
    var insurance = $('.insurance').val();
    var rewards_amount = $('.rewards_amount').val();
    var loans = $('.loans').val();
    var penalties_amount = $('.penalties_amount').val();
    var total_absence = $('.total_absence').val();



    $('.net_salary').val( ((parseFloat(salary) +  parseFloat(rewards_amount)) - (parseFloat(insurance) + parseFloat(loans) + parseFloat(penalties_amount) + parseFloat(total_absence))).toFixed(2))
    $('.total_deduction').val(((parseFloat(insurance) + parseFloat(loans) + parseFloat(penalties_amount) + parseFloat(total_absence))).toFixed(2))

}

navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

function successCallback(position) {

  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;

  $(".latitude-input").val(latitude);
  $(".longitude-input").val(longitude);
}

function errorCallback(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
          alert("User denied the request for Geolocation.");
          break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
          break;
      }
}

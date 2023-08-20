$('.com-select').on('change' , function(e){
    e.preventDefault();

    // $('.combinations-div').children().remove().end()
    var locale = $('.product-select').data('locale');

    var combinations = [];

    $('.selected_combinations').each(function(i, sel){
        combinations.push($(sel).val());
    });

    var options = $('.com-select option');

    $.map(options ,function(option) {


        if(!combinations.includes(option.value)){
            $('.combinations-div').append(

                `<div class="row item">
                    <div class="col-md-3 d-flex flex justify-content-center align-items-center">
                        <label class="form-label" for="qty">` + option.text +`</label>
                    </div>
                    <div style="display:none;" class="col-md-3">
                        <div class="mb-3">
                            <input name="selected_combinations[]" class="form-control selected_combinations" value="` + option.value +`" type="number"
                            id="selected_combinations" required />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="qty">` + (locale == 'ar' ? 'الكمية' : 'quantity') +`</label>
                            <input name="qty[]" class="form-control com-quantity" min="0" value="0" type="number"
                            id="qty" required />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="price">` + (locale == 'ar' ? 'السعر' : 'price')+`</label>
                            <input name="price[]" class="form-control com-price" min="0" step="0.01" value="0" type="number"
                            id="price" required />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="total">` + (locale == 'ar' ? 'الاجمالي' : 'total')+`</label>
                            <input name="total[]" class="form-control com-total" min="0" step="0.01" value="0" type="number"
                            id="total" disabled required />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label class="form-label" for="delete">` + (locale == 'ar' ? 'حذف' : 'delete')+`</label>
                            <a href="javascript:void(0);" class="delete">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="far fa-trash-alt text-danger fs-2"></span>
                                </span>
                            </a>
                        </div>
                    </div>

                </div>`
            );
        }
    });

    getTotal();

});


$('.combinations-div').on('click', '.delete', function(e){
    e.preventDefault();
    $(this).parent('div').parent('div').parent('div').remove();
    getTotal();
});

{/* <div class="col-md-3 d-flex flex justify-content-center align-items-center">
                    <a href="javascript:void(0);" class="remove_button"><span id="basic-addon1"><span class="far fa-trash-alt text-danger fs-2"></span></span></a>
                </div> */}

//Once remove button is clicked
// $('.combinations-div').on('click', '.remove_button', function(e){
//     e.preventDefault();
//     $(this).closest('.item').remove(); //Remove field html
// });


$('.combinations-div').on('input', '.com-quantity', function(e){
    e.preventDefault();
    var quantity = $(this).val();
    var price = $(this).closest('.item').find('.com-price').val();
    var total = quantity * price ;
    $(this).closest('.item').find('.com-total').val(total);
    getTotal();
});

$('.combinations-div').on('input', '.com-price', function(e){
    e.preventDefault();
    var price = $(this).val();
    var quantity = $(this).closest('.item').find('.com-quantity').val();
    var total = quantity * price ;
    $(this).closest('.item').find('.com-total').val(total);
    getTotal();
});

$('.purchase-tax').on('change' , function(e){
    e.preventDefault();
    getTotal();
});


$('.discount').on('input' , function(e){
    e.preventDefault();
    getTotal();
});


$('.shipping').on('input' , function(e){
    e.preventDefault();
    getTotal();
});

const element = document.querySelector('.product-select');
const choices = new Choices(element , {"removeItemButton":true});

element.addEventListener(
    'search',
    function(event) {


        var search = event.detail.value;
        var url = $('.product-select').data('url');
        var locale = $('.product-select').data('locale');

        var formData = new FormData();

        formData.append('search' , search );

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
                              { value: element.id , label: (locale == 'ar' ? element.name_ar : element.name_en) ,  disabled: (element.product_type == 'digital' || element.product_type == 'service') ? true : false  }

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

const element_2 = document.querySelector('.com-select');
const choices_2 = new Choices(element_2 , {"removeItemButton":true});


$('.product-select').on('change' , function(e){
    e.preventDefault();

    var count = 0;
    choices_2.clearChoices();
    $(this).find('option').each(function() {
        getCom($(this).val());
        count++;
        console.log(count)

    });
    // if(count == 0){
    //     $('.combinations-div').children().remove().end()
    // }

});



function getCom(product_id , combinations = []){

    var url = $('.product-select').data('url_com');
    var formData = new FormData();
    formData.append('product_id' , product_id );
    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data.status == 1){
                $('.combinations-select').show()
                $('.com-select').attr('required' , true);
                var array = data.elements;
                array.forEach(element => {
                    choices_2.setChoices(
                        [{ value: element.id , label:  element.name  ,  selected : combinations.includes(element.id) ? true : false }],
                        'value',
                        'label',
                        false,
                      );
                });
            }
        }
    });

}


function getTotal(){

    var qty = [];
    var price = [];
    var combinations = [];
    var tax = [];
    var url = $('.product-select').data('url_cal');
    var discount = $('.discount').val();
    var shipping = $('.shipping').val();


    $("input[name^=qty]").each(function() {
        qty.push($(this).val());
    });

    $("input[name^=price]").each(function() {
        price.push($(this).val());
    });

    // $('.com-select :selected').each(function(i, sel){
    //     compinations.push($(sel).val());
    // });

    $('.selected_combinations').each(function(i, sel){
        combinations.push($(sel).val());
    });

    $('.purchase-tax :selected').each(function(i, sel){
        tax.push($(sel).val());
    });

    // $('input.purchase-tax:checkbox:checked').each(function () {
    //     tax.push($(this).val());
    // });

    var formData = new FormData();

    formData.append('qty' , qty);
    formData.append('price' , price);
    formData.append('compinations' , combinations);
    formData.append('tax' , tax);
    formData.append('discount' , discount);
    formData.append('shipping' , shipping);

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
            if(data.status == 1){

                console.log(data.total , data.subtotal ,data.vat_amount ,data.wht_amount  ,data.discount);

                $('.subtotal').text(data.subtotal);
                $('.total').text(data.total);
                $('.vat-amount').text(data.vat_amount);
                $('.wht-amount').text(data.wht_amount);
                $('.discount-value').text(data.discount);
                $('.shipping-value').text(data.shipping);



                $('.taxes-data').remove();

                    var array = data.taxes;
                    array.forEach(element => {

                        var fieldHTML = `<tr class="taxes-data">
                                            <th class="text-900">`+ element.name +`:</th>
                                            <td class="fw-semi-bold vat-amount">`+ element.tax_amount +`</td>
                                        </tr>`;

                        $('.taxes-table tr:first').after(fieldHTML)
                    });


            }
        }
    });
}




$(document).ready(function(){

    var locale = $('.product-select').data('locale');
    var products = $('.product-select').data('products');


    var array = products;
    var checkArray = [];
    var combinations = [];
    var combinationsData = [];

    array.forEach(element => {
        combinations.push(element.pivot.product_combination_id);
        combinationsData[element.pivot.product_combination_id] = element.pivot;
        if(!checkArray.includes(element.id)){
            choices.setChoices(
                [
                  { value: element.id , label: (locale == 'ar' ? element.name_ar : element.name_en) ,  disabled: (element.product_type == 'digital' || element.product_type == 'service') ? true : false , selected: true}
                ],
                'value',
                'label',
                false,
            );
            checkArray.push(element.id);
        }
    });



    $('.product-select').find('option').each(function() {
        getCom($(this).val() , combinations);
    });



    setTimeout(function () {

        var options = $('.com-select option');

        $.map(options ,function(option) {

            console.log(option.value)

            $('.combinations-div').append(

                `<div class="row item">
                    <div class="col-md-3 d-flex flex justify-content-center align-items-center">
                        <label class="form-label" for="qty">` + option.text +`</label>
                    </div>
                    <div style="display:none;" class="col-md-3">
                        <div class="mb-3">
                            <input name="selected_combinations[]" class="form-control selected_combinations" value="` + option.value +`" type="number"
                            id="selected_combinations" required />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="qty">` + (locale == 'ar' ? 'الكمية' : 'quantity') +`</label>
                            <input name="qty[]" class="form-control com-quantity" min="0" value="` + combinationsData[option.value].qty  +`" type="number"
                            id="qty" required />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="price">` + (locale == 'ar' ? 'السعر' : 'price')+`</label>
                            <input name="price[]" class="form-control com-price" min="0" step="0.01" value="` + combinationsData[option.value].product_price  +`" type="number"
                            id="price" required />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="total">` + (locale == 'ar' ? 'الاجمالي' : 'total')+`</label>
                            <input name="total[]" class="form-control com-total" min="0" step="0.01" value="` + combinationsData[option.value].total  +`" type="number"
                            id="total" disabled required />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label class="form-label" for="delete">` + (locale == 'ar' ? 'حذف' : 'delete')+`</label>
                            <a href="javascript:void(0);" class="delete">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="far fa-trash-alt text-danger fs-2"></span>
                                </span>
                            </a>
                        </div>
                    </div>

                </div>`
            );
        });



        getTotal();

    }, 3000);


    $('.combinations-div').on('click', '.delete', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
        getTotal();
    });



    console.log(products , combinations ,combinationsData );






});

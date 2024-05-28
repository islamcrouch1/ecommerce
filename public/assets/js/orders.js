const element = document.querySelector('.product-select');
const choices = new Choices(element , {"removeItemButton":true});

const element_2 = document.querySelector('.com-select');
const choices_2 = new Choices(element_2 , {"removeItemButton":true});

element.addEventListener(
    'search',
    function(event) {


        var search = event.detail.value;
        var url = $('.data').data('products_search_url');
        var locale = $('.data').data('locale');

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


                if(data.status == 1){

                    choices.clearChoices();

                    var array = data.elements;
                    array.forEach(element => {

                        choices.setChoices(
                            [
                              { value: element.id , label: (locale == 'ar' ? element.name_ar : element.name_en) }
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

$('.product-select').on('change' , function(e){
    e.preventDefault();
    var count = 0;
    choices_2.clearChoices();
    $(this).find('option').each(function() {
        getCom($(this).val());
        count++;
    });
});

function getCom(product_id , combinations = []){

    var url = $('.data').data('get_combinations_url');
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

                    console.log(element);

                    choices_2.setChoices(
                        [{ value: element.id , label:  element.name , customProperties:  [element.price , element.product_id , data.units_category_id,element.can_rent] ,  selected : combinations.includes(element.id) ? true : false }],
                        'value',
                        'label',
                        false,
                      );
                });


            }
        }
    });

}

$('.com-select').on('change' , function(e){
    e.preventDefault();

    var locale = $('.data').data('locale');
    var combinations = [];

    $('.selected_combinations').each(function(i, sel){
        combinations.push($(sel).val());
    });

    var options = $('.com-select option');

    $.map(options ,function(option) {

        if(!combinations.includes(option.value)){


            data = $(option).data('custom-properties').split(',');
            var class_name = 'units-select-' + data[2] + '-' + option.value;

            console.log(data);

            const currentDate = getCurrentDate();


            if(data[3] == 'on'){




                var days_input = `


                                <div class="col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label" for="days">` + (locale == 'ar' ? 'عدد الايام' : 'days') +`</label>
                                        <input name="days[]" class="form-control com-days" min="1" value="1" type="number"
                                        id="days"  />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="start_date">` + (locale == 'ar' ? 'تاريخ بداية التاجير' : 'start date') +`</label>
                                        <input name="start_date[]" class="form-control com-start_date" value="`+ currentDate +`" min="`+ currentDate +`" type="datetime-local"
                                        id="start_date"  />
                                    </div>
                                </div>



                                `;
            }else{

                var days_input = `


                                <div  style="display:none;"  class="col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label" for="days">` + (locale == 'ar' ? 'عدد الايام' : 'days') +`</label>
                                        <input name="days[]" class="form-control com-days" min="1" value="1" type="number"
                                        id="days" required />
                                    </div>
                                </div>

                                <div  style="display:none;"  class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="start_date">` + (locale == 'ar' ? 'تاريخ بداية التاجير' : 'start date') +`</label>
                                        <input name="start_date[]" class="form-control com-start_date" value="`+ currentDate +`" min="`+ currentDate +`" type="datetime-local"
                                        id="start_date"  />
                                    </div>
                                </div>



                                `;
            }




            $('.combinations-div').append(

                `<div class="row item">
                    <div class="col-md-3 d-flex flex justify-content-center align-items-center">
                        <label class="form-label" for="qty">` + option.text +`</label>
                    </div>
                    <div style="display:none;" class="col-md-3">
                        <div class="mb-2">
                            <input name="selected_combinations[]" class="form-control selected_combinations" value="` + option.value +`" type="number"
                            id="selected_combinations" required />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label class="form-label" for="qty">` + (locale == 'ar' ? 'الكمية' : 'quantity') +`</label>
                            <input name="qty[]" class="form-control com-quantity" min="0" value="0" type="number"
                            id="qty" required />
                        </div>
                    </div>`
                    +
                    days_input
                    +
                    `<div class="col-md-1">
                        <div class="mb-3">
                            <label class="form-label" for="qty">` + (locale == 'ar' ? 'وحدة القياس' : 'UoM') +`</label>
                            <select class="form-select `+ class_name +`" name="units[]" id="units">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label class="form-label" for="price">` + (locale == 'ar' ? 'سعر البيع' : 'sale price')+`</label>
                            <input name="price[]" data-product_id="`+ data[1] +`" class="form-control com-price" min="0" step="0.01" value="0" type="number"
                            id="price" required />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="total">` + (locale == 'ar' ? 'الاجمالي' : 'total')+`</label>
                            <input name="total[]" class="form-control com-total" min="0" value="0" step="0.01" type="number"
                            id="total" disabled required />
                        </div>
                    </div>

                    <div style="display:none" class="col-md-3">
                        <div class="mb-3">
                            <input name="prods[]" value="`+ data[1] +`" class="form-control"  type="number"
                            id="prods" required />
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

        getUnits(data[2] , option.value);

    });

    getTotal();
});

function getUnits(units_category_id , compination_id , combinationsData = []){

    var url = $('.data').data('get_units');
    var locale = $('.data').data('locale');
    var select = '.units-select-' + units_category_id + '-' + compination_id;
    var formData = new FormData();
    formData.append('units_category_id' , units_category_id );


    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {

            if(data.status == 1){
                $(select).children().remove().end()
                var array = data.elements;
                var selected = '';

                array.forEach(element => {

                    if(combinationsData.length > 0){
                        selected = combinationsData[compination_id].unit_id == element.id ? 'selected' : '';
                    }else{
                        selected = element.type == 'default' ? 'selected' : '';
                    }

                    $(select).append(
                        `<option value="`+ element.id +`" `+ selected +`>`+ (locale == 'ar' ? element.name_ar : element.name_en) +`</option>`
                    )
                });
            }else{
                $(select).children().remove().end()
            }

        }
    });

}

function getTotal(){

    var qty = [];
    var price = [];
    var combinations = [];
    var products = [];
    var tax = [];
    var url = $('.data').data('calculate_total');
    var discount = $('.discount').val();
    var shipping = $('.shipping').val();
    var currency_id = $('.currency').find(":selected").val();

    var days = [];

    $("input[name^=qty]").each(function() {
        qty.push($(this).val());
    });

    $("input[name^=days]").each(function() {
        days.push($(this).val());
    });

    console.log(days);

    $("input[name^=price]").each(function() {
        price.push($(this).val());
        products.push($(this).data('product_id'));
    });


    $('.selected_combinations').each(function(i, sel){
        combinations.push($(sel).val());
    });

    $('.tax-select :selected').each(function(i, sel){
        tax.push($(sel).val());
    });


    var formData = new FormData();

    formData.append('qty' , qty);
    formData.append('days' , days);
    formData.append('price' , price);
    formData.append('products' , products);
    formData.append('compinations' , combinations);
    formData.append('tax' , tax);
    formData.append('discount' , discount);
    formData.append('shipping' , shipping);
    formData.append('currency_id' , currency_id);


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


                $('.subtotal').text(printAmountWithSymbol(data.subtotal , data.symbol));
                $('.total').text(printAmountWithSymbol(data.total, data.symbol));
                $('.discount-value').text(printAmountWithSymbol(data.discount, data.symbol));
                $('.shipping-value').text(printAmountWithSymbol(data.shipping, data.symbol));


                $('.taxes-data').remove();

                var array = data.taxes;
                array.forEach(element => {

                    var fieldHTML = `<tr class="taxes-data">
                                        <th class="text-900">`+ element.name +`:</th>
                                        <td class="fw-semi-bold vat-amount">`+ printAmountWithSymbol(element.tax_amount, data.symbol) +`</td>
                                    </tr>`;

                    $('.taxes-table tr:first').after(fieldHTML)
                });


            }
        }
    });
}

function printAmountWithSymbol(amount , symbol){
    return amount + ' ' + symbol;
}


function getCurrentDate() {
    const now = new Date();
    const year = now.getFullYear();
    const month = ('0' + (now.getMonth() + 1)).slice(-2); // Months are zero-indexed
    const day = ('0' + now.getDate()).slice(-2);
    const hours = ('0' + now.getHours()).slice(-2);
    const minutes = ('0' + now.getMinutes()).slice(-2);
    const seconds = ('0' + now.getSeconds()).slice(-2);
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

$('.combinations-div').on('click', '.delete', function(e){
    e.preventDefault();
    $(this).parent('div').parent('div').parent('div').remove();
    getTotal();
});

$('.combinations-div').on('input', '.com-quantity', function(e){
    e.preventDefault();
    var quantity = $(this).val();
    var price = $(this).closest('.item').find('.com-price').val();
    var days = $(this).closest('.item').find('.com-days').val();

    var total = quantity * price * days;
    $(this).closest('.item').find('.com-total').val(total);
    getTotal();
});

$('.combinations-div').on('input', '.com-price', function(e){
    e.preventDefault();
    var price = $(this).val();
    var quantity = $(this).closest('.item').find('.com-quantity').val();
    var days = $(this).closest('.item').find('.com-days').val();
    var total = quantity * price * days;
    $(this).closest('.item').find('.com-total').val(total);
    getTotal();
});


$('.combinations-div').on('input', '.com-days', function(e){
    e.preventDefault();
    var days = $(this).val();
    var quantity = $(this).closest('.item').find('.com-quantity').val();
    var price = $(this).closest('.item').find('.com-price').val();

    if (days <= 0) {
        days = 1;
    }

    var total = quantity * price * days;
    $(this).closest('.item').find('.com-total').val(total);
    getTotal();
});



$('.tax-select').on('change' , function(e){
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

$('.currency').on('change' , function(e){
    e.preventDefault();
    getTotal();
});



$(document).ready(function(){

    var locale = $('.data').data('locale');
    var disabled = $('.data').data('disabled');

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

            data = $(option).data('custom-properties').split(',');
            var class_name = 'units-select-' + data[2] + '-' + option.value;

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
                            <label class="form-label" for="qty">` + (locale == 'ar' ? 'وحدة القياس' : 'UoM') +`</label>
                            <select class="form-select `+ class_name +`" name="units[]" id="units" `+ disabled +` >

                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="price">` + (locale == 'ar' ? 'سعر البيع' : 'sale price')+`</label>
                            <input name="price[]" data-product_id="`+ data[1] +`" class="form-control com-price" min="0" step="0.01" value="` + combinationsData[option.value].product_price  +`" type="number"
                            id="price" required `+ disabled +` />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label" for="total">` + (locale == 'ar' ? 'الاجمالي' : 'total')+`</label>
                            <input name="total[]" class="form-control com-total" min="0" value="` + combinationsData[option.value].total  +`" step="0.01" type="number"
                            id="total" disabled required />
                        </div>
                    </div>

                    <div style="display:none" class="col-md-3">
                        <div class="mb-3">
                            <input name="prods[]" value="`+ data[1] +`" class="form-control"  type="number"
                            id="prods" required />
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

            getUnits(data[2] , option.value , combinationsData);
        });

        getTotal();

    }, 3000);


    $('.combinations-div').on('click', '.delete', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
        getTotal();
    });









});

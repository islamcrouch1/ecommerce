$('.com-select').on('change' , function(e){
    e.preventDefault();

    $('.combinations-div').children().remove().end()
    var locale = $('.product-select').data('locale');

    var options = $('.com-select option');

    $.map(options ,function(option) {

        data = $(option).data('custom-properties').split(',');

        $('.combinations-div').append(

            `<div class="row item">
                <div class="col-md-3 d-flex flex justify-content-center align-items-center">
                    <label class="form-label" for="qty">` + option.text +`</label>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" for="qty">` + (locale == 'ar' ? 'الكمية' : 'quantity') +`</label>
                        <input name="qty[]" class="form-control com-quantity" min="0" value="0" type="number"
                        id="qty" required />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" for="price">` + (locale == 'ar' ? 'سعر البيع' : 'sale price')+`</label>
                        <input name="price[]" data-product_id="`+ data[1] +`" class="form-control com-price" min="0" value="`+ data[0] +`" type="number"
                        id="price" required />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label" for="total">` + (locale == 'ar' ? 'الاجمالي' : 'total')+`</label>
                        <input name="total[]" class="form-control com-total" min="0" value="0" type="number"
                        id="total" disabled required />
                    </div>
                </div>

                <div style="display:none" class="col-md-3">
                    <div class="mb-3">
                        <input name="prods[]" value="`+ data[1] +`" class="form-control"  type="number"
                        id="prods" required />
                    </div>
                </div>

            </div>`
        );

    });

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


$('.combinations-div').on('change', '.com-quantity', function(e){
    e.preventDefault();
    var quantity = $(this).val();
    var price = $(this).closest('.item').find('.com-price').val();
    var total = quantity * price ;
    $(this).closest('.item').find('.com-total').val(total);
    getTotal();
});

$('.combinations-div').on('change', '.com-price', function(e){
    e.preventDefault();
    var price = $(this).val();
    var quantity = $(this).closest('.item').find('.com-quantity').val();
    var total = quantity * price ;
    $(this).closest('.item').find('.com-total').val(total);
    getTotal();
});

$('.sale-tax').on('change' , function(e){
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

const element_2 = document.querySelector('.com-select');
const choices_2 = new Choices(element_2 , {"removeItemButton":true});


$('.product-select').on('change' , function(e){
    e.preventDefault();

    var count = 0;
    choices_2.clearChoices();
    $(this).find('option').each(function() {
        getCom($(this).val());
        count++;
    });
    if(count == 0){
        $('.combinations-div').children().remove().end()
    }

});



function getCom(product_id){

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
                        [{ value: element.id , label:  element.name , customProperties:  [element.price , element.product_id] }],
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
    var compinations = [];
    var products = [];
    var tax = [];
    var url = $('.product-select').data('url_cal');

    $("input[name^=qty]").each(function() {
        qty.push($(this).val());
    });

    $("input[name^=price]").each(function() {
        price.push($(this).val());
        products.push($(this).data('product_id'));
    });

    $('.com-select :selected').each(function(i, sel){
        compinations.push($(sel).val());
    });

    $('input.sale-tax:checkbox:checked').each(function () {
        tax.push($(this).val());
    });

    var formData = new FormData();

    formData.append('qty' , qty);
    formData.append('price' , price);
    formData.append('products' , products);
    formData.append('compinations' , compinations);
    formData.append('tax' , tax);

    $.ajax({
        url: url,
        data: formData,
        method: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
            if(data.status == 1){

                console.log(data.total , data.subtotal ,data.vat_amount ,data.wht_amount);

                $('.subtotal').text(data.subtotal);
                $('.total').text(data.total);
                $('.vat-amount').text(data.vat_amount);
                $('.wht-amount').text(data.wht_amount);
            }
        }
    });
}

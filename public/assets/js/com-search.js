$('.com-select').on('change' , function(e){
    e.preventDefault();

    $('.combinations-div').children().remove().end()

    var options = $('.com-select option');

    $.map(options ,function(option) {
        $('.combinations-div').append(
            `<div class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label" for="qty">` + option.text +`</label>
                    </div>
                    <div class="col-md-8">
                        <input name="qty[]" class="form-control" min="0" value="0" type="number"
                        id="qty" required />
                    </div>
                </div>
            </div>`
        );
    });

});




const element = document.querySelector('.product-select');
const choices = new Choices(element);

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
    var url = $('.product-select').data('url_com');
    var product_id = $(this).find(":selected").val();

    var product_name = $(this).find(":selected").text();

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

            console.log(data);

            if(data.status == 1){

                choices_2.clearChoices();
                $('.combinations-div').children().remove().end()
                $('.combinations-select').show()
                $('.com-select').attr('required' , true);

                var array = data.elements;
                array.forEach(element => {

                    choices_2.setChoices(
                        [
                            { value: element.id , label:  element.name  }

                          ],
                        'value',
                        'label',
                        false,
                      );

                });

            }else{
                $('.combinations-div').children().remove().end()
                choices_2.clearChoices();
                $('.combinations-select').hide();
                $('.com-select').attr('required' , false);
                $('.combinations-div').append(
                    `<div class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="qty">` + product_name +`</label>
                            </div>
                            <div class="col-md-8">
                                <input name="qty[]" class="form-control" min="0" value="0" type="number"
                                id="qty" required />
                            </div>
                        </div>
                    </div>`
                );
            }

        }
    });



});

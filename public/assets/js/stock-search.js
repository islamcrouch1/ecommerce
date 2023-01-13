$('.product-search').on('change' , function(e){
    e.preventDefault();

    $(this).closest('form').submit();
});




const element = document.querySelector('.product-search');
const choices = new Choices(element);

element.addEventListener(
    'search',
    function(event) {


        var search = event.detail.value;
        var url = $('.product-search').data('url');
        var locale = $('.product-search').data('locale');

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

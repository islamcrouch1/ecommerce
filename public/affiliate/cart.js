$(document).ready(function() {

    var stock = $('.size-variant li.active').data('stock');
    $( "input[type=text][name=stock_id]" ).val(stock)
    var quantity = $( "input[type=text][name=quantity]" ).val();
    $( "input[type=text][name=quantity_order]" ).val(quantity)




})


$('.color-select').click(function(){

    var id = $(this).data('id');
    var color = $(this).data('color');
    var label = '.p-' + id + '-' + color;
    var labl = '.labl-size1-' + id;
    // var image = '#image-' + $(this).data('image');
    // var url = $(this).data('url');
    // var img = '#pruduct-image' + id;

    // $('.product-image-thumb').removeClass('active');
    // $(image).addClass("active");
    // $(img).attr('src' , url);


    $(labl).removeClass('active')
    $(labl).hide();
    $(label).first().addClass('active')
    $(label).show();

});




$( "#submit-order" ).click(function(event) {
    event.preventDefault();

    var id = $(this).data('id');
    var stock = $('.size-variant li.active').data('stock');


    var form = $('#form-order');
    // Trigger HTML5 validity.
    var reportValidity = form[0].reportValidity();

    var quantity = $( "input[type=text][name=quantity]" ).val();

    $( "input[type=text][name=quantity_order]" ).val(quantity)
    $( "input[type=text][name=stock_id]" ).val(stock)


    

    // Then submit if form is OK.
    if(reportValidity){
        form.submit();
        $("#submit-order").attr("disabled", true);
    }

  });
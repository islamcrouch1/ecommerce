$(document).ready(function(){
    var $container = $('.navbar-vertical-content');
    var $scrollTo = $('.active');
    $container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop() - 50, scrollLeft: 0},300);

});



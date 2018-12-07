$(document).ready(function()
{
    /*
    var instance = M.Carousel.init({
        fullWidth: true,
        indicators: true
    });
    */
    // Or with jQuery

    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        indicators: true
    });

    if ( $('.carousel a').length > 1 ) {
        setInterval(function() {
          $('.carousel').carousel('next');
        }, 6000); // every 2 seconds
    }

    $('.control-left').click(function(){
        $('.carousel').carousel('prev');
    });

    $('.control-right').click(function(){
        $('.carousel').carousel('next');
    });

    /* Chama a função filtros que está no font init.js */
    owlFiltros();

    $("#owl-locais").owlCarousel({
        pagination : false,
        navigationText: ['<div style="background:url(/imgs/arrows.png);"></div>', '<div style="background:url(/imgs/arrows.png);"></div>'],
        navigation: true,
        items : 3,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,2],
        itemsTablet: [500,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });

    $("#owl-parceiros").owlCarousel({
        autoPlay : 6000,
        items : 6,
        itemsDesktop : [979,5],
        itemsDesktopSmall : [700,4],
        itemsTablet: [500,3], //2 items between 600 and 0
        itemsMobile : [360,2] // itemsMobile disabled - inherit from itemsTablet option
    });

});

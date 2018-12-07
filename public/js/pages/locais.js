/*function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);*/

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

    $('.control-left').click(function(){
        $('.carousel').carousel('prev');
    });
    
    $('.control-right').click(function(){
        $('.carousel').carousel('next');
    });
 
    /* Chama a função filtros que está no font init.js */
    owlFiltros();
    
    $("#owl-casas").owlCarousel({
        autoPlay : 4000,
        items : 4,
        itemsDesktop : [1199,3],
        itemsDesktopSmall : [979,2],
        itemsTablet: [600,1], //2 items between 600 and 0
        itemsMobile : [360,1] // itemsMobile disabled - inherit from itemsTablet option
    });
    
});
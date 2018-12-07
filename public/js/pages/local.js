/*function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);*/

$(document).ready(function()
{
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
    
    $("#owl-galeria").owlCarousel({
        autoPlay : 4000,
        items : 4,
        itemsDesktop : [1600,4],
        itemsDesktopSmall : [1300,3],
        itemsTablet: [850,2], //2 items between 600 and 0
        itemsMobile : [600,1] // itemsMobile disabled - inherit from itemsTablet option
    });
    
});
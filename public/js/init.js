//var elem = document.querySelector('.sidenav');
//var instance = M.Sidenav.init(elem, options);
var idInterval = 0;


(function($){
  $(function(){
    //$('.button-collapse').sideNav();
    eventsLayout();
    eventsButtons();
    eventSocialNetworks();
    pesquisa();
  }); // end of document ready
})(jQuery); // end of jQuery name space

function eventSocialNetworks()
{
    $('.btSocialNetwork').click(function()
    {
        var url = $(this).attr('href');
        var title = $(this).attr('title');

        switch( $(this).attr('title') )
        {
            case 'Facebook':
                var w = 630;
                var h = 360;
                var left = screen.width/2 - 630/2;
                var top = screen.height/2 - 360/2;

                window.open('http://www.facebook.com/sharer.php?u='+url, 'Compartilhar no facebook', 'toolbar=no, location=no, directories=no, status=no, ' + 'menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+ ', height=' + h + ', top=' + top + ', left=' + left);
                break;
            case 'Twitter':
                var ulrSN = "http://twitter.com/home?status="+url;
                window.open(ulrSN,'ADverso', 'toolbar=0, status=0, width=650, height=450');
                break;
            case 'Whatsapp':
                // code block
                break;
        }


        return false;
    });
}

function eventsLayout()
{
    $('.tooltipped').tooltip();
    // Menu lateral mobile
    //$('.sidenav').sidenav();
    $('.sidenav').sidenav();

    $('.social-itens ul li:eq(1)').hover(function(){
        $('.primeiro-item-social.add').toggleClass('hover-primeiro-item-social');
    });

    $('.social-itens-rodape ul li:eq(1)').hover(function(){
        $('.primeiro-item-social-rodape.add').toggleClass('hover-primeiro-item-social-rodape');
    });

    $('.principal-itens ul li:eq(1)').hover(function(){
        $('.primeiro-item-principal.add').toggleClass('hover-primeiro-item-principal');
    });


    $('.icon-search').click(function(){
        //$('.input-search').removeClass('hide');
        $('.input-search').removeClass('hide');
        $('.input-search').hide();
        $('.input-search').show('fast');
    });


    $('.close-search').click(function(){
        $('.input-search').hide('fast', function() {
            $('.input-search').addClass('hide');
        });
    });

    $('.voltar-ao-topo').click(function() {
        $('html, body').animate({scrollTop:0}, 'slow');
    });

    $('.owl-filtros .item').hover(function() {
        var cor = '#333333';
        if ( $(this).attr('data-background-color') ) {
            cor = $(this).attr('data-background-color');
        }

        $( '.material-tooltip' ).css( "background-color", cor );
    });

}

function eventsButtons()
{
    $('.fechar-menu-mobile').click(function() {
        $('.sidenav').sidenav('close');
    });
}

function owlFiltros() {
    $("#owl-filtros").owlCarousel({
        pagination : false,
        navigationText: ['<div style="background:url(/imgs/arrows.png);"></div>', '<div style="background:url(/imgs/arrows.png);"></div>'],
        navigation: true,
        items : 8,
        itemsDesktop : [1400,7],
        itemsDesktopSmall : [1180,6],
        itemsTablet: [800,5], //2 items between 600 and 0
        itemsTabletSmall: [630,4], //2 items between 600 and 0
        itemsMobile : [400,2] // itemsMobile disabled - inherit from itemsTablet option
    });

    $("#owl-filtros-meses").owlCarousel({
        pagination : false,
        navigationText: ['<div style="background:url(/imgs/arrows.png);"></div>', '<div style="background:url(/imgs/arrows.png);"></div>'],
        navigation: true,
        items : 8,
        itemsDesktop : [1400,5],
        itemsDesktopSmall : [1180,4],
        itemsTablet: [800,3], //2 items between 600 and 0
        itemsTabletSmall: [580,2], //2 items between 600 and 0
        itemsMobile : [420,1] // itemsMobile disabled - inherit from itemsTablet option
    });

    $("#owl-filtros-dias").owlCarousel({
        pagination : false,
        navigationText: ['<div style="background:url(/imgs/arrows.png);"></div>', '<div style="background:url(/imgs/arrows.png);"></div>'],
        navigation: true,
        items : 8,
        itemsDesktop : [1400,7],
        itemsDesktopSmall : [1180,6],
        itemsTablet: [800,5], //2 items between 600 and 0
        itemsTabletSmall: [630,4], //2 items between 600 and 0
        itemsMobile : [400,2] // itemsMobile disabled - inherit from itemsTablet option
    });
}

function pesquisa() {
    var elem = document.querySelector('#modalBusca');
    var options = {
        opacity: 0.9
    };
    var register;
    var instanceModalBusca = M.Modal.init(elem, options);

    $(document).ready(function()
    {
        /* MODAL NewsLetter */
        // $('.cadastrar-newsletter').click(function() {
        //     // register = JSON.parse( $(this).attr('rel') );
        //
        //     instanceModalBusca.open();
        //
        //     var nome = $('#newsletter #name').val();
        //     var email = $('#newsletter #email').val();
        //     $('#modalNewsLetter #name').val(nome);
        //     $('#modalNewsLetter #email').val(email);
        //     // $("#modalVideos .video-container").html(register.link);
        // });

        $('.icon-search').click(function(){
            // instanceModalBusca.close();
            instanceModalBusca.open();
        });


    });
}

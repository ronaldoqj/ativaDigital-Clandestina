// Variaveis de inicialização
var paginacaoHome = 0;
var numeroDeRegistros = 6;
var cat = [];
var search = '';

// Gets e Sets
function setPaginacaoHome ($paginacao) { paginacaoHome = $paginacao; }
function getPaginacaoHome () { return paginacaoHome; }

function getNumeroDeRegistros () { return numeroDeRegistros; }

function setCat ($cat) { cat = $cat; }
function setSearch ($search) { search = $search; }

function getCat () { return cat; }
function getSearch () { return search; }


$(document).ready(function()
{
    $('#locais .carregarmais').click(function() {
        ajaxEventoCarregarMais();
    });

    $('#form-lugares #bt-search').click(function()
    {
        var search = $('#form-lugares #search').val();
        setPaginacaoHome(0);
        if ( search.length < 4 ) {
            search = '';
        }
        setSearch(search);
        ajaxEventoCarregarMais();
        return false;
    });


    $('#filtros .box-cat').click(function()
    {
        var data = JSON.parse($(this).attr('data'));
        var aCat = getCat();
        setPaginacaoHome(0);

        if ($(this).hasClass('active'))
        {
            // Desativa
            $(this).removeClass('active');
            // Remove item do array
            const index = aCat.indexOf(data.id);
            aCat.splice(index, 1);
            // FIM Remove item do array
            setCat(aCat);
        }
        else
        {
            // Ativa
            $(this).addClass('active');
            aCat.push(data.id);
            setCat(aCat);
        }

        ajaxEventoCarregarMais();
    });

    // Inicia Carregando as primeiros registros
    ajaxEventoCarregarMais();
});

function ajaxEventoCarregarMais()
{
    var retorno;

    var ajax = $.ajax({
        url: '/ajax_selectLugares',
        method: "GET",
        data: { paginacao: getPaginacaoHome(),
                NRegistros: getNumeroDeRegistros(),
                cat: getCat(),
                search: getSearch() }
    });

    ajax.done(function (data)
    {
        var string;
        var countHome = 0;
//console.log(data);
//return false;

        if (data.length == 0)
        {
            string  = '<div class="col s12 m12 l12 xl12 center-align">';
            string += '  <h2>';
            string += '    Nenhum registro existente para essa pesquisa.';
            string += '  </h2>';
            string += '</div>';
            $("#locais .row").html(string);
            $("#locais .conteiner-carregar-mais").hide('slow');
            return false;
        }

        for (var key in data)
        {
            // console.log(data[key]);
            // console.log(data[key].categorias[0]);
            // console.log(JSON.parse(data[key].data));

            var $img = '/images/default.png';
            var banner_principal_namefilefull = '';
            var imagem_principal_namefilefull = '';

            try {
                if ( data[key].banner_principal_namefilefull != null )
                banner_principal_namefilefull = data[key].banner_principal_namefilefull;
            } catch(err) {}
            try {
                if ( data[key].imagem_principal_namefilefull != null )
                imagem_principal_namefilefull = data[key].imagem_principal_namefilefull;
            } catch(err){}

            if (banner_principal_namefilefull != '') { $img = '/' + banner_principal_namefilefull }
            if (imagem_principal_namefilefull != '') { $img = '/' + imagem_principal_namefilefull }

            var titleLink = data[key].name;

            var cor;
            try {
                cor = data[key].categorias[0].color;
            } catch(err) {
                cor = '#000000';
            }
            var imgCategoria;
            try {
                imgCategoria = '/' + data[key].categorias[0].namefilefull;
            } catch(err) {
                imgCategoria = '/images/default.png';
            }

            var subtitle = '';
            if ( data[key].sub_title != null ) { subtitle = data[key].sub_title; }

            string  = '';
            string += '<div class="col s12 m6 xl4 item-append">';
            string += ' <div class="espacamento-cards">';
            string += '     <a href="/lugares/lugar/'+data[key].id+'/'+data[key].nameLink+'">';
            string += '     <div class="box-container">';
            string += '       <div class="box-local">';

            string += '         <div class="img-local" style="background-image: url('+$img+')"></div>';
            string += '         <div class="text-local">';
            string += '             <p class="truncate">'+data[key].name+'&nbsp;</p>';
            string += '             <p class="truncate">'+subtitle+'&nbsp;</p>';
            string += '         </div>';

            string += '       </div>';
            string += '     </div>';
            string += '     </a>';
            string += ' </div>';
            string += '</div>';

            if (paginacaoHome == 0 && countHome == 0) {
                if (countHome == 0) {
                    $("#locais .row").html(string);
                    countHome++;
                }
            } else {
                $("#locais .row").append(string);
            }

            $( "#locais .row .item-append" ).fadeTo( "slow" , 1, function() {
                $(this).removeClass('item-append');
            });

        }

        // Incrementa Paginação
        setPaginacaoHome(getPaginacaoHome() + getNumeroDeRegistros());
        retorno = data;

        // Oculta botão "carregar mais"
        console.log(data[0].nextRegister);
        if (data[0].nextRegister == false || data.length < getNumeroDeRegistros()) {
            $("#locais .conteiner-carregar-mais").hide('slow');
        } else {
            $("#locais .conteiner-carregar-mais").show('slow');
        }
    });
    ajax.fail(function (jqXHR, textStatus) { console.log( "jqXHR: " + jqXHR );
                                             console.log( "Request failed: " + textStatus ); });

    return retorno;
}

// Variaveis de inicialização
var paginacaoHome = 0;
var numeroDeRegistros = 6;
var mes = [];
var dia = [];
var cat = [];
var search = '';
var listaRelacionada = {};

// Gets e Sets
function setPaginacaoHome ($paginacao) { paginacaoHome = $paginacao; }
function getPaginacaoHome () { return paginacaoHome; }

function getNumeroDeRegistros () { return numeroDeRegistros; }

function setMes ($mes) { mes = $mes; }
function setDia ($dia) { dia = $dia; }
function setCat ($cat) { cat = $cat; }
function setSearch ($search) { search = $search; }
function setListaRelacionada ($lr) { listaRelacionada = $lr; }

function getMes () { return mes; }
function getDia () { return dia; }
function getCat () { return cat; }
function getSearch () { return search; }
function getListaRelacionada () { return listaRelacionada; }
function processaRecomendacao()
{
    var recomendacao_id = $('#recomendacao_id').val();
    var recomendacao_tabela = $('#recomendacao_tabela').val();
    setListaRelacionada ({'id' : recomendacao_id, 'tabela' : recomendacao_tabela});
}

$(document).ready(function()
{
    processaRecomendacao();

    $('#card .carregarmais').click(function() {
        ajaxEventoCarregarMais();
    });

    $('#form-conteudo #bt-search').click(function()
    {
        var search = $('#form-conteudo #search').val();
        setPaginacaoHome(0);
        if ( search.length < 4 ) {
            search = '';
        }
        setSearch(search);
        ajaxEventoCarregarMais();
        return false;
    });

    $('#filtros .box-mes').click(function()
    {
        var data = JSON.parse($(this).attr('data'));
        setPaginacaoHome(0);

        if ($(this).hasClass('ative'))
        {
            // Desativa
            $(this).removeClass('ative');
            var aMeses = getMes();
            // Remove item do array
            const index = aMeses.indexOf(data.numero);
            aMeses.splice(index, 1);
            // FIM Remove item do array
            setMes(aMeses);
        }
        else
        {
            // Ativa
            $(this).addClass('ative');
            var aMeses = getMes();
            aMeses.push(data.numero);
            setMes(aMeses);
        }

        ajaxEventoCarregarMais();
    });

    $('#filtros .box-dia').click(function()
    {
        var data = JSON.parse($(this).attr('data'));
        setPaginacaoHome(0);

        if ($(this).hasClass('active'))
        {
            // Desativa
            $(this).removeClass('active');
            var aDias = getDia();
            // Remove item do array
            const index = aDias.indexOf(data.numero);
            aDias.splice(index, 1);
            // FIM Remove item do array
            setDia(aDias);
        }
        else
        {
            // Ativa
            $(this).addClass('active');
            var aDias = getDia();
            aDias.push(data.numero);
            setDia(aDias);
        }

        ajaxEventoCarregarMais();
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
        url: '/ajax_selectEvents',
        method: "GET",
        data: { paginacao: getPaginacaoHome(),
                NRegistros: getNumeroDeRegistros(),
                mes: getMes(),
                dia: getDia(),
                cat: getCat(),
                search: getSearch(),
                PesquisaRelacionada: JSON.stringify(getListaRelacionada())
               }
    });

    ajax.done(function (data)
    {
        var string;
        var countHome = 0;

        if (data.length == 0)
        {
            string  = '<div class="col s12 m12 l12 xl12 center-align">';
            string += '  <h2>';
            string += '    Nenhum registro existente para essa pesquisa.';
            string += '  </h2>';
            string += '</div>';
            $("#card .row").html(string);
            $("#card .conteiner-carregar-mais").hide('slow');
            return false;
        }

        for (var key in data)
        {
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

            string  = '';
            string += '<div class="col s12 m6 xl4 item-append">';
            string += ' <a href="/evento/'+data[key].id+'/'+data[key].nameLink+'">';
            string += '   <div class="card" style="box-shadow: 12px 12px '+cor+'; background-image: url('+$img+')">';
            string += '     <div class="card-background">';

            if (data[key].calendario != null)
            {
                string += '<div class="card-calendario">';
                string += '    <ul>';
                string += '        <li>'+data[key].calendario[0].nomeDia+'</li>';
                string += '        <li>'+data[key].calendario[0].numeroDia+'</li>';
                string += '        <li>'+data[key].calendario[0].nomeMes+'</li>';
                string += '    </ul>';

              if (data[key].calendario.length > 2)
              {
                string += '    <ul>';
                string += '      <li><div class="divisao"></div></li>';
                string += '      <li class="divisorLi">'+data[key].calendario[1]+'</li>';
                string += '      <li><div class="divisao"></div></li>';
                string += '    </uL>';
                string += '    <ul>';
                string += '        <li>'+data[key].calendario[2].nomeDia+'</li>';
                string += '        <li>'+data[key].calendario[2].numeroDia+'</li>';
                string += '        <li>'+data[key].calendario[2].nomeMes+'</li>';
                string += '    </ul>';
              }
                string += '</div>';
            }

            string += '       <div class="card-texto valign-wrapper" style="background-color: '+cor+'50;">';
            string += '         <div style="background-image: url('+imgCategoria+')"></div>';
            string += '         <ul>';
            string += '           <li>'+data[key].name+'</li>';
            string += '         </ul>';
            string += '       </div>';

            string += '     </div>';
            string += '   </div>';
            string += ' </a>';
            string += '</div>';

            if (paginacaoHome == 0 && countHome == 0) {
                if (countHome == 0) {
                    $("#card .row").html(string);
                    countHome++;
                }
            } else {
                $("#card .row").append(string);
            }

            $( "#card .row .item-append" ).fadeTo( "slow" , 1, function() {
                $(this).removeClass('item-append');
            });

        }

        // Incrementa Paginação
        setPaginacaoHome(getPaginacaoHome() + getNumeroDeRegistros());
        retorno = data;

        // Oculta botão "carregar mais"
        if (data[0].nextRegister == false || data.length < getNumeroDeRegistros()) {
            $("#card .conteiner-carregar-mais").hide('slow');
        } else {
            $("#card .conteiner-carregar-mais").show('slow');
        }
    });
    ajax.fail(function (jqXHR, textStatus) { console.log( "jqXHR: " + jqXHR );
                                             console.log( "Request failed: " + textStatus ); });

    return retorno;
}

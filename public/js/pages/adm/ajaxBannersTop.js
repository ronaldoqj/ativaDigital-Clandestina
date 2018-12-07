$(document).ready(function()
{
    $('.checkbox-register-home').click(function() {
        var id = $(this).attr('rel-id');
        var ativo = 'N';
        var table = $(this).attr('rel-table');
        var column = $(this).attr('rel-column');
        if ( $(this).is(':checked') ) {
            ativo = 'S';
        }

        bannerTopoProgramacao(id, ativo, table, column, this);
    });
    $('.checkbox-register').click(function() {
        var id = $(this).attr('rel-id');
        var ativo = 'N';
        var table = $(this).attr('rel-table');
        var column = $(this).attr('rel-column');
        if ( $(this).is(':checked') ) {
            ativo = 'S';
        }

        bannerTopoProgramacao(id, ativo, table, column, this);
    });

    $(".order-banners").change(function() {
        var id = $(this).attr('rel-id');
        var ativo = 'N';
        var table = $(this).attr('rel-table');
        var column = $(this).attr('rel-column');
        var value = $(this).val();

        orderBannerTopo(id, ativo, table, column, value, this);
    });

    // order-banners
});

// Ajax banners ----------------------------------------------------------------

function orderBannerTopo(id, ativo, table, column, value, obj)
{
    var ajax = $.ajax({
        url: '/ajax_bannersTopsOrders',
        method: "GET",
        data: { id: id,
                table: table,
                column: column,
                value: value }
    });

    ajax.done(function (data)
    {
        $('#' + data.column + '-' + data.id).addClass("sombra-update");
        setTimeout(function() {
            $('#' + data.column + '-' + data.id).removeClass("sombra-update");
        }, 20);
    });
    ajax.fail(function (jqXHR, textStatus) {});
}
// Ajax banner topo --------------------------------------------------------

function bannerTopoProgramacao(id, ativo, table, column, obj)
{
    // console.log(obj);
    // console.log(JSON.stringify(obj));
    var ajax = $.ajax({
        url: '/ajax_bannersTops',
        method: "GET",
        data: { id: id,
                ativo: ativo,
                table: table,
                column: column }
    });

    ajax.done(function (data)
    {
        // console.log(data.column);
        // span-register_27
        // console.log('#teste_'+data);

        switch(data.table) {
            case 'programacoes':
                if (data.column == 'home')
                {
                    if ($('#span-register-home_'+data.id).hasClass('active'))
                    {
                        // Desativa
                        $('#span-register-home_'+data.id).removeClass('active');
                    }
                    else
                    {
                        // Ativa
                        $('#span-register-home_'+data.id).addClass('active');
                    }
                }
                if (data.column == 'banner')
                {
                    if ($('#span-register_'+data.id).hasClass('active'))
                    {
                        // Desativa
                        $('#span-register_'+data.id).removeClass('active');
                    }
                    else
                    {
                        // Ativa
                        $('#span-register_'+data.id).addClass('active');
                    }
                }
                break;
            case 'casas':
                if (data.column == 'home')
                {
                    if ($('#span-register-home_'+data.id).hasClass('active'))
                    {
                        // Desativa
                        $('#span-register-home_'+data.id).removeClass('active');
                    }
                    else
                    {
                        // Ativa
                        $('#span-register-home_'+data.id).addClass('active');
                    }
                }
                if (data.column == 'banner')
                {
                    if ($('#span-register_'+data.id).hasClass('active'))
                    {
                        // Desativa
                        $('#span-register_'+data.id).removeClass('active');
                    }
                    else
                    {
                        // Ativa
                        $('#span-register_'+data.id).addClass('active');
                    }
                }
                break;
            case 'noticias':
                if (data.column == 'home')
                {
                    if ($('#span-register-home_'+data.id).hasClass('active'))
                    {
                        // Desativa
                        $('#span-register-home_'+data.id).removeClass('active');
                    }
                    else
                    {
                        // Ativa
                        $('#span-register-home_'+data.id).addClass('active');
                    }
                }
                if (data.column == 'banner')
                {
                    if ($('#span-register_'+data.id).hasClass('active'))
                    {
                        // Desativa
                        $('#span-register_'+data.id).removeClass('active');
                    }
                    else
                    {
                        // Ativa
                        $('#span-register_'+data.id).addClass('active');
                    }
                }
                break;
        }

    });
    ajax.fail(function (jqXHR, textStatus) {});
}

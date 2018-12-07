$(document).ready(function()
{

    $('.delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro?'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name="idQuemSomos"]').val(id);
            $('#form-delete').submit();
        }
    });

    $('.imagesList').click(function() {
        var img = $(this).attr('rel');
        $("#imageThumb").attr("src", img);
        $('#modalImage').modal();
    });

    $('.order').click(function() {
        var id = $(this).attr('rel');
        $('#form-order input[name*="id"]').val(id);
        $('#form-order').submit();
    });

    // ================================================================================
    // Exclusivos para quem-somos-update
    // ================================================================================

    $('.btns-delete-imgs-principais').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro?'))
        {
            var id = $(this).attr('relId');
            var campo = $(this).attr('relCampo');
            var acao = $(this).attr('relAcao');
            $("#form-delete input[name*='id']").val(id);
            $("#form-delete input[name*='action']").val(acao);
            $("#form-delete input[name*='campo']").val(campo);
            $('#form-delete').submit();
        }
    });

    // $('.edit-image').click(function() {
    //     var id = $(this).attr('rel');
    //     var name = $(this).parent().parent().find('.inputNomeImagem').val();
    //       $('#form-images input[name="id"]').val(id);
    //       $('#form-images input[name="idQuemSomos"]').val('');
    //       $('#form-images input[name="action"]').val('edit-image-galeria');
    //       $('#form-images input[name="name"]').val(name);
    //
    //       $('#form-images').submit();
    // });
    //
    // $('.delete-image').click(function() {
    //     var id = $(this).attr('rel');
    //     var idQuemSomos = $(this).attr('rel2');
    //     if (confirm('Tem certeza que deseja deletar esta imagem?'))
    //     {
    //         $('#form-images input[name="id"]').val(id);
    //         $('#form-images input[name="idQuemSomos"]').val(idQuemSomos);
    //         $('#form-images input[name="action"]').val('delete-image-galeria');
    //         $('#form-images input[name="name"]').val('');
    //         $('#form-images').submit();
    //     }
    // });

});

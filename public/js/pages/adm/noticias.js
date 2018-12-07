$(document).ready(function()
{
    $('#bt-cadastrar-editar').click(function()
    {
        // Desabilita o botao
        $(this).disabled = true;

        var select = $('#selectCategoria').val();
        $('input[name="categorias"]').val(select);
    });

    $('.delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro?'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name="idNoticia"]').val(id);
            $('#form-delete').submit();
        }
    });

    $('.imagesList').click(function() {
        var img = $(this).attr('rel');
        $("#imageThumb").attr("src", img);
        $('#modalImage').modal();
    });



    // ================================================================================
    // Exclusivos para noticias-update
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

    $('.order-image').click(function() {
        var id = $(this).attr('rel');
        var idNoticia = $(this).attr('rel2');
        $('#form-images input[name="id"]').val(id);
        $('#form-images input[name="idNoticia"]').val(idNoticia);
        $('#form-images input[name="action"]').val('order-image-galeria');

        $('#form-images').submit();
    });

    $('.edit-image').click(function() {
        var id = $(this).attr('rel');
        var name = $(this).parent().parent().find('.inputNomeImagem').val();
          $('#form-images input[name="id"]').val(id);
          $('#form-images input[name="idNoticia"]').val('');
          $('#form-images input[name="action"]').val('edit-image-galeria');
          $('#form-images input[name="name"]').val(name);

          $('#form-images').submit();
    });

    $('.delete-image').click(function() {
        var id = $(this).attr('rel');
        var idNoticia = $(this).attr('rel2');
        if (confirm('Tem certeza que deseja deletar esta imagem?'))
        {
            $('#form-images input[name="id"]').val(id);
            $('#form-images input[name="idNoticia"]').val(idNoticia);
            $('#form-images input[name="action"]').val('delete-image-galeria');
            $('#form-images input[name="name"]').val('');
            $('#form-images').submit();
        }
    });

    $('.btn-delete-galeria').click(function() {
        var idNoticia = $(this).attr('rel');
        if (confirm('Tem certeza que deseja deletar esta galeria?'))
        {
            $('#form-images input[name="id"]').val('');
            $('#form-images input[name="idNoticia"]').val(idNoticia);
            $('#form-images input[name="action"]').val('delete-galeria');
            $('#form-images input[name="name"]').val('');
            $('#form-images').submit();
        }
    });

});

$(document).ready(function()
{

    $('.delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro?'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name="idParceiro"]').val(id);
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

});

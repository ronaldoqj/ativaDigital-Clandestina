//function atualizar() { location.reload(true) } window.setInterval("atualizar()",3000);

$(document).ready(function()
{

    $('.edit').click(function() {
        var register = JSON.parse( $(this).attr('rel') );
        $(".img-modal").attr("src", '/'+register.namefilefull);
        $(".img-modal").css({'border-color': register.color});
        $('#modalEdit input[name*="id"]').val(register.id);
        $('#modalEdit input[name*="name"]').val(register.name);
        $('#modalEdit input[name*="color"]').val(register.color);
        $('#modalEdit textarea[name*="description"]').val(register.description);
        $('#modalEdit input[name*="nameImage"]').val(register.namefile);

        $('#modalEdit').modal();
    });

    $('.CATEGORIAS-thumbs').click(function() {
        var path = $(this).attr('rel');
        $("#imageThumb").attr("src", path);
        $('#modalImage').modal();
    });

    $('.delete').click(function()
    {
        if (confirm('Tem certeza que deseja deletar este registro'))
        {
            var id = $(this).attr('rel');
            $('#form-delete input[name*="id"]').val(id);
            $('#form-delete').submit();
        }
    });

});

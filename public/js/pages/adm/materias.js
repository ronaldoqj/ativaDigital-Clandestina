$(document).ready(function()
{
    var type = $('#formIni input[name*="type"]').val();

    $(".input-data").mask("00/00/0000");

    /*
    trataTiposDeMaterias($('#type'), '#register ');
    $('#register #type').change(function() {
        trataTiposDeMaterias($(this), '#register ');
    });

    $('#edit #type').change(function() {
        trataTiposDeMaterias($(this), '#edit ');
    });
    */
    /*
    function trataTiposDeMaterias(objThis, Form)
    {
        var obj = objThis;

        switch( $(obj).val() ) {
        case 'normal':
            $(Form + '.backgroundbanner').html('Background*');
            $(Form + 'select[name*="colunista"]').removeAttr("required");
            $(Form + '#avatar').hide('slow');
            break;
        case 'especial':
            $(Form + '.backgroundbanner').html('Banner*');
            $(Form + 'select[name*="colunista"]').removeAttr("required");
            $(Form + '#avatar').hide('slow');
            break;
        case 'coluna':
            $(Form + '#avatar').show('slow');
            $(Form + '.backgroundbanner').html('Banner*');
            $(Form + 'select[name*="colunista"]').attr("required", "true");
            break;
        }
    }
    */

    $('.edit').click(function() {
        var file = JSON.parse( $(this).attr('rel') );
        var data = $(this).attr('relData');
        var image = file.namefilefull != null ? '/'+file.namefilefull : '/images/default.png';

        $(".img-modal").attr("src", image);

        $('#modalEdit select[name*="colunista"] option').removeAttr('selected').filter('[value='+file.colunista+']').attr('selected', true);
        $('#modalEdit select[name*="backgroundbanner"] option').removeAttr('selected').filter('[value='+file.backgroundbanner+']').attr('selected', true);

        if (file.ativo == 'S') { $('#modalEdit input[name*="ativo"]').attr("checked", true); }
        else { $('#modalEdit input[name*="ativo"]').attr("checked", false); }

        $('#modalEdit input[name*="id"]').val(file.id);
        $('#modalEdit input[name*="assunto"]').val(file.assunto);
        $('#modalEdit input[name*="data"]').val(data);
        $('#modalEdit input[name*="title"]').val(file.title);
        $('#modalEdit input[name*="subtitle"]').val(file.subtitle);
        CKEDITOR.instances['textEdit1'].setData(file.text1);
        $('#modalEdit select[name*="image"] option').removeAttr('selected').filter('[value='+file.image+']').attr('selected', true);
        $('#modalEdit select[name*="video"] option').removeAttr('selected').filter('[value='+file.video+']').attr('selected', true);
        $('#modalEdit select[name*="galeria"] option').removeAttr('selected').filter('[value='+file.galeria+']').attr('selected', true);
        CKEDITOR.instances['textEdit2'].setData(file.text2);
        $('#modalEdit textarea[name*="text2"]').text(file.text2);
        $('#modalEdit input[name*="facebook"]').val(file.facebook);
        $('#modalEdit input[name*="twitter"]').val(file.twitter);
        $('#modalEdit input[name*="whatsapp"]').val(file.whatsapp);

        $('#modalEdit').modal();
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

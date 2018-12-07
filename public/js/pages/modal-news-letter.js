var elem = document.querySelector('#modalNewsLetter');
var options = {
  opacity: 0.9
};
var register;
var instance = M.Modal.init(elem, options);

$(document).ready(function()
{
    /* MODAL NewsLetter */
    $('.cadastrar-newsletter').click(function() {
        // register = JSON.parse( $(this).attr('rel') );

        instance.open();

        var nome = $('#newsletter #name').val();
        var email = $('#newsletter #email').val();
        $('#modalNewsLetter #name').val(nome);
        $('#modalNewsLetter #email').val(email);
        // $("#modalVideos .video-container").html(register.link);
    });

    $('#modalNewsLetter .cadastrar-newsletter-modal').click(function(){
        // instance.close();
        if ($('#modalNewsLetter #name').val() != '' && $('#modalNewsLetter #email').val() != '')
        {
            registerNewsLetter();
        }
    });


});


function registerNewsLetter()
{
    var retorno;
    var categorias = [];


    var aChk = $('#modalNewsLetter input[name=categoria]');

    for (var i=0;i<aChk.length;i++)
    {
         if (aChk[i].checked == true) {
            categorias.push(aChk[i].value);
         }
    }

    var ajax = $.ajax({
        url: '/ajax_registerNewsLetter',
        method: "GET",
        data: {
                name: $('#modalNewsLetter #name').val(),
                email: $('#modalNewsLetter #email').val(),
                whatsapp: $('#modalNewsLetter #whatsapp').val(),
                categorias: categorias
              }
    });

    ajax.done(function (data)
    {
        $('#modalNewsLetter .modal-content').html('<div class="col s12 title-sections">Inscrição realizada com sucesso.</div>');
    });
    ajax.fail(function (jqXHR, textStatus) {
        $('#modalNewsLetter .modal-content').html('<div class="col s12 title-sections">Não foi possível realizar a inscrição.</div>');
    });

    return retorno;
}

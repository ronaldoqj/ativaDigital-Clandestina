<?php
    /* Controla Menus */
    $home = '';
    $agenda = '';
    $conteudo = '';
    $lugares = '';
    $quemSomos = '';
    $parceiros = '';
    $contato = '';
    $active = 'active';

    if ( isset($return['menus']) )
    {
        if ($return['menus'] == 'home') { $home = $active; }
        if ($return['menus'] == 'agenda') { $agenda = $active; }
        if ($return['menus'] == 'conteudo') { $conteudo = $active; }
        if ($return['menus'] == 'lugares') { $lugares = $active; }
        if ($return['menus'] == 'quem somos') { $quemSomos = $active; }
        if ($return['menus'] == 'parceiros') { $parceiros = $active; }
        if ($return['menus'] == 'contato') { $contato = $active; }

    }
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" maximum-scale="1.0"/>


    @yield('metatags')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clandestina</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    @yield('css')

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122078779-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-122078779-1');
    </script>
</head>
<body>











  <!-- Modal Newsletter -->
  <div id="modalBusca" class="modal ">
      <div class="modal-content">
          <div class="form-news-letter">
              <div class="col s12 title-sections">BUSCA</div>

              <form action="/pesquisa" method="post">
                  {{ csrf_field() }}
                  <div class="col s12 l6 offset-l3">
                      <input type="text" class="browser-default input-pesquisa" id="pesquisa" placeholder="Digite sua pesquisa" name="pesquisa" maxlength="240" />
                  </div>
                  <div class="col s12 l6 offset-l3">
                      <input type="submit" class="browser-default buscar-modal bt-pesquisa" value="BUSCAR" />
                  </div>
              </form>
          </div>
      </div>

      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
      </div>
  </div>









    <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view z-depth-1">
                <div class="fechar-menu-mobile">X</div>

                <div class="menu-mobile-info">
                    <div><a href="/"><img src="/imgs/clandestina.png" width="205" height="35" alt="CLANDESTINA" title="CLANDESTINA" /></a></div>
                    <div><a href="#">Revista Clandestina</a></div>
                    <div class="p-l-16"></div>
                    <div><a href="#">oi@clandestina.com.br</a></div>
                    <div><a href="#">clandestina.com.br</a></div>
                </div>
            </div>
        </li>
        <li><a class="waves-effect" href="/">Home</a></li>
        <li><a class="waves-effect {{$home}}" href="/agenda">Agenda</a></li>
        <li><a class="waves-effect {{$conteudo}}" href="/conteudo">Conteúdo</a></li>
        <li><a class="waves-effect {{$lugares}}" href="/lugares">Lugares</a></li>
        <li><a class="waves-effect {{$quemSomos}}" href="/quem-somos">Quem Somos</a></li>
        <li><a class="waves-effect {{$parceiros}}" href="/parceiros">Parceiros</a></li>
        <li><a class="waves-effect {{$contato}}" href="/contato">Contato</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader">Redes Sociais</a></li>
        <li><a class="waves-effect" target="_blank" href="https://www.facebook.com/revistaclandestina/" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i> <span class="m-l--20">Facebook</span></a> </li>
        {{--<li><a class="waves-effect" target="_blank" href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i>  <span class="m-l--20">Twitter</span></a>  </li>--}}
        {{--<li><a class="waves-effect" target="_blank" href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i> <span class="m-l--20">Whatsap</span></a>  </li>--}}
        <li><a class="waves-effect" target="_blank" href="https://www.instagram.com/revistaclandestina/" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i><span class="m-l--20">Instagran</span></a></li>
        <li>&nbsp;<br/>&nbsp;</li>
    </ul>

    <div class="menu-desktop topo z-depth-2">
      <div class="container">
                <div class="logo left valign-wrapper"><a href="/"><img src="/imgs/clandestina.png" width="205" height="35" alt="CLANDESTINA" title="CLANDESTINA" /></a></div>
                <div class="menus">
                    <div class="menu-social">
                        <div class="social-itens">
                            <ul>
                                <li><a target="_blank" href="https://www.facebook.com/revistaclandestina/" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                                {{--<li><a target="_blank" href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>--}}
                                {{--<li><a target="_blank" href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>--}}
                                <li><a target="_blank" href="https://www.instagram.com/revistaclandestina/" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu-principal">
                        <div class="principal-itens">

                            <ul>
                                <li><a class="{{$home}}" href="/">HOME</a></li>
                                <li><a class="{{$agenda}}" href="/agenda">AGENDA</a></li>
                                <li><a class="{{$conteudo}}" href="/conteudo">CONTEÚDO</a></li>
                                <li><a class="{{$lugares}}" href="/lugares">LUGARES</a></li>
                                <li><a class="{{$quemSomos}}" href="/quem-somos">QUEM SOMOS</a></li>
                                <li><a class="{{$parceiros}}" href="/parceiros">PARCEIROS</a></li>
                                <li><a class="{{$contato}}" href="/contato">CONTATO</a></li>
                                <li><a href="#" title="search"><i class="fontello-icon icon-lupa icon-search">&#xe810;</i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
        <div class="clearfix"></div>
      </div>
    </div>

    <div class="menu-mobile z-depth-1 clearfix">
        <div class="container">
            <!-- <div class="menu-icone"><a href="#" data-target="slide-out" class="sidenav-trigger"><i class="fontello-icon icon-menu">&#xe800;</i></a></div> -->
            <div class="menu-icone"><a href="#" data-target="slide-out" class="sidenav-trigger"><img src="/imgs/icon-menu-mobile.png" width="19" height="11" alt="CLANDESTINA" title="CLANDESTINA" /></div>
            <div class="menu-lupa"><a href="#" title="search"><i class="fontello-icon icon-lupa icon-search">&#xe810;</i></a></div>
            <div class="logo center valign-wrapper logo-mobile-left"><a href="/"><img src="/imgs/clandestina.png" width="205" height="35" alt="CLANDESTINA" title="CLANDESTINA" /></a></div>
        </div>
    </div>

    <div id="height-topo"></div>
    <!-- <div class="container-content"> -->
    @yield('content')
    <!-- </div> -->


    <div id="footer-only-desktop" class="hide-on-med-and-down">
      <div class="container">
          <div class="row">
              <div class="col m6">
     	    				<div class="logo-footer">
     	    					<img src="/imgs/clandestina.png" class="responsive-img" />
     	    				</div>

     	    				<p>
     	    					A Clandestina é uma revista digital de agenda e conteúdo de cultura em Porto Alegre.
                    Um espaço que se propõe aberto e busca a participação de quem acredita na potência da
                    cultura como transformadora da vida cotidiana.
     	    				</p>

	                <!--
     	    				<div class="seguidores">
     	    					<b>15k</b> followers
     	    				</div>
                  -->

     	    				<div class="siga-nos">
     	    					Siga-nos:
     	    					<a target="_blank" href="https://www.facebook.com/revistaclandestina/"><i class="fontello-icon icon-facebook">&#xe80d;</i></a>
     	    					{{--<a target="_blank" href="#"><i class="fontello-icon icon-twitter">&#xe802;</i></a>--}}
     	    					{{--<a target="_blank" href="#"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a>--}}
     	    					{{--<a target="_blank" href="#"><i class="fontello-icon icon-youtube">&#xe804;</i></a>--}}
                    <a target="_blank" href="https://www.instagram.com/revistaclandestina/"><i class="fontello-icon icon-instagram">&#xe80e;</i></a>
     	    				</div>
              </div>

   	    			<!--<div class="col m6">
   	    				<h4>INSTAGRAM</h4>
   	    				<ul class="instagram">
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_1.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_2.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_3.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_4.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_5.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_6.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_7.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_8.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_9.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_1.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_2.png"></a></li>
     	    					<li><a href="#"><img src="/imgs/DELETAR/instagram_3.png"></a></li>
   	    				</ul>
   	    				<a href="#" class="view-more-photos">View more photos</a>
   	    			</div>
   	    			-->

          </div>
          {{--
          <div class="row">
              <div class="col m5 offset-m7 cadastre-se">

                  <form method="post">
                      {{ csrf_field() }}
                      <input type="text" class="browser-default" placeholder="Seu Email..." name="email" />
                      <input type="submit" class="browser-default" value="CADASTRE-SE" />
                  </form>

              </div>
          </div>
          --}}
      </div>
    </div>


    <footer class="page-footer">

        <div class="menu-desktop footer z-depth-2">
          <div class="container">

              <div class="menu-mobile-rodape height-30"></div>
              {{--
              <div class="cadastre-se menu-mobile-rodape ">
                <form action="" method="post">
                  <table><tr>
                      <td><input type="text" class="browser-default" placeholder="seu e-mail..." value="" /></td>
                      <td><input type="submit" class="browser-default" value="CADASTRE-SE" /></td>
                  </tr></table>
                </form>
              </div>
              --}}
              <div class="menus">
                <div class="menu-social">
                  <div class="social-itens">
                    <ul>
                      <li><a target="_blank" href="https://www.facebook.com/revistaclandestina/" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a></li>
                      {{--<li><a target="_blank" href="#" title="Twitter"><i class="fontello-icon icon-twitter">&#xe802;</i></a></li>--}}
                      {{--<li><a target="_blank" href="#" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a></li>--}}
                      <li><a target="_blank" href="https://www.instagram.com/revistaclandestina/" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="menu-principal">
                  <div class="principal-itens">
                    <ul>
                      <li><a class="{{$home}}" href="/">HOME</a></li>
                      <li><a class="{{$agenda}}" href="/agenda">AGENDA</a></li>
                      <li><a class="{{$conteudo}}" href="/conteudo">CONTEÚDO</a></li>
                      <li><a class="{{$lugares}}" href="/lugares">LUGARES</a></li>
                      <li><a class="{{$quemSomos}}" href="/quem-somos">QUEM SOMOS</a></li>
                      <li><a class="{{$parceiros}}" href="/parceiros">PARCEIROS</a></li>
                      <li><a class="{{$contato}}" href="/contato">CONTATO</a></li>
                      <li><a href="#" title="search"><i class="fontello-icon icon-lupa icon-search">&#xe810;</i></a></li>
                    </ul>
                  </div>
                </div>

                <div class="menu-mobile-rodape voltar-ao-topo">
                    <div class="seta-up"></div>
                    <p>Voltar ao topo</p>
                </div>

                <div class="menu-mobile-rodape height-30"></div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>

        <div class="clearfix"></div>
        <div class="footer-copyright">
            <div class="container center">
                <a class="orange-text text-lighten-3" href="http://alternativadigital.com.br"><img src="/imgs/alternativa-digital.png" width="80" height="37" /></a>
            </div>
        </div>
    </footer>

    <!--  Scripts-->
    <!--script src="https://code.jquery.com/jquery-2.1.1.min.js"></script-->
    <script src="/plugins/jquery/v3.2.1/jquery.min.js"></script>
    <script src="/js/materialize.js"></script>
    <script src="/js/init.js"></script>
    @yield('js')
</body>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
</html>

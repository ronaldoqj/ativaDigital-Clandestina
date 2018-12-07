<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clandestina') }}</title>

    <!-- Fonte Google -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Bootstrap CSS CDN -->
    <!-- <link href="/plugins-frameworks/bootstrap/v4.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="/css/adm-layout.css">
    @yield('css')
    @yield('jsHead')
</head>
<body>
  @php
      $title = 'AD Verso';
  @endphp
  @isset($return['title'])
      @php
          $home = '';
          $programacoes = '';
          $categorias = '';
          $bancoImagens = '';
          $galeria = '';
          $casas = '';
          $noticias = '';
          $quemSomos = '';
          $parceiros = '';
          $materias = '';
          $tvadverso = '';
          $usuario = '';

          $title = $return['title'];

          if($title == 'ORDEM DE APRESENTAÇÃO HOME') { $home = 'active'; }
          if($title == 'Categorias-Banco de Imagens' ||
             $title == 'Categorias-Matéria' ||
             $title == 'Categorias-Colunista') { $categorias = 'active'; }
          if($title == 'Categorias') { $categorias = 'active'; }
          if($title == 'Banco de imagens') { $bancoImagens = 'active'; }
          if($title == 'Galerias') { $galeria = 'active'; }
          if($title == 'Notícias' || $title == 'Atualizar Notícias') { $noticias = 'active'; }
          if($title == 'Quem Somos' || $title == 'Atualizar Quem Somos') { $quemSomos = 'active'; }
          if($title == 'Parceiros' || $title == 'Atualizar Parceiros') { $parceiros = 'active'; }
          if($title == 'Programações' || $title == 'Atualizar Programações') { $programacoes = 'active'; }
          if($title == 'Casas' || $title == 'Atualizar Casa') { $casas = 'active'; }
          if($title == 'Matérias') { $materias = 'active'; }
          if($title == 'TV ADVerso') { $tvadverso = 'active'; }
          if($title == 'Usuário') { $usuario = 'active'; }
      @endphp
  @endisset
    <div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
                <div class="titulo-menu-header text-center">
                    <h3><img src="/images/LogoClandestina-160x19.png" /></h3>
                    <strong><img src="/images/LogoClandestinaA-31x40.png" /></strong>
                </div>
                <div class="sidebar-header">
                    <!-- <h3 class="text-center"><img src="/images/avatar-adm.png" /></h3>
                    <strong>AD</strong> -->
                    <div class="adm-avatar-menu"><img class="img-fluid rounded-circle" src="/images/avatar-adm.png" /></div>
                    <div class="adm-info-avatar-menu">
                        <ul>
                            <li>{{ Auth::user()->name }}</li>
                            <li>{{ Auth::user()->funcao }}</li>
                        </ul>
                    </div>
                    <div style="clear:both;"></div>
                </div>

                <ul class="list-unstyled components">
                    <!-- <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                            <i class="material-icons">home</i>
                            Home
                        </a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">Seção Topo</a></li>
                            <li><a href="#">Seção Filtros</a></li>
                            <li><a href="#">Seção Eventos</a></li>
                            <li><a href="#">Seção Multimídia</a></li>
                            <li><a href="#">Seção Casas</a></li>
                            <li><a href="#">Seção Parceiros</a></li>
                        </ul>
                    </li> -->

                    <li class="titulos-menus-adm">Conteúdo Portal</li>

                    <li class="{{$programacoes}}">
                        <a href="/adm/programacoes">
                            <i class="material-icons">web</i>
                            Programação
                        </a>
                    </li>
                    <li class="{{$casas}}">
                        <a href="/adm/casas">
                            <i class="material-icons">home</i>
                            Casas
                        </a>
                    </li>
                    <li class="{{$noticias}}">
                        <a href="/adm/noticias">
                            <i class="material-icons">photo_library</i>
                            Notícias
                        </a>
                    </li>
                    <li class="{{$quemSomos}}">
                        <a href="/adm/quem-somos">
                            <i class="material-icons">photo_library</i>
                            Quem Somos
                        </a>
                    </li>
                    <li class="{{$parceiros}}">
                        <a href="/adm/parceiros">
                            <i class="material-icons">photo_library</i>
                            Parceiros
                        </a>
                    </li>
                    <!-- <li class="{{$bancoImagens}}">
                        <a href="">
                            <i class="material-icons">photo_library</i>
                            Quem Somos
                        </a>
                    </li>
                    <li class="{{$galeria}}">
                        <a href="">
                            <i class="material-icons">photo_library</i>
                            Contato
                        </a>
                    </li> -->
                </ul>

                <ul class="list-unstyled list-unstyled-top">
                    <li class="titulos-menus-adm">Admin</li>

                    <li class="{{$usuario}}">
                        <a href="/adm/usuario">
                            <i class="material-icons">person</i>
                            Usuário
                        </a>
                    </li>
                    <li class="{{$categorias}}">
                        <a href="/adm/categorias">
                            <i class="material-icons">apps</i>
                            Categorias
                        </a>
                    </li>
                    <!--
                    <li class="{{$categorias}}">
                      <a href="#categorias" data-toggle="collapse" aria-expanded="false">
                        <i class="material-icons">apps</i>
                        Categorias
                      </a>
                      <ul class="collapse list-unstyled" id="categorias">
                        <li>
                          <a href="/adm/categorias/galeria">
                            <i class="material-icons">loyalty</i>
                            Banco de Imagens
                          </a>
                        </li>
                        <li>
                          <a href="/adm/categorias/colunista">
                            <i class="material-icons">loyalty</i>
                            Colunista
                          </a>
                        </li>
                        <li>
                          <a href="/adm/categorias/materia">
                            <i class="material-icons">loyalty</i>
                            Matéria
                          </a>
                        </li>
                      </ul>
                    </li>
                     -->
                </ul>
                <div class="m-b-40"></div>
                <!-- <ul class="list-unstyled CTAs">
                    <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li>
                    <li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>
                </ul> -->
            </nav>

            <!-- Page Content Holder -->
            <div id="content">

                <nav class="navbar navbar-default">

                    <div class="container-fluid">
                        <i id="sidebarCollapse" class="material-icons">view_compact</i>

                        <table class="table-home-title">
                          <tr>
                            <td class="title">{{$title}}</td>
                          </tr>
                        </table>

                        <div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>

                </nav>

                @yield('content')

            </div>
    </div>


    <?php /*
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    */ ?>

    <!-- <script src="/plugins-frameworks/jquery/v3.3.1/jquery-3.3.1.min.js"></script>
    <script src="/plugins-frameworks/bootstrap/v4.0.0/js/boostrap.min.js"></script>
    <script src="/plugins-frameworks/bootstrap/v4.0.0/js/popperV1.12.9.min.js"></script> -->
    <script src="/plugins/jquery/v3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    <!-- Scripts -->
    @yield('js')

</body>
</html>

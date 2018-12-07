<?php
    $categorias = $return['categorias'];
    $banners = $return['banners'];
    $meses = $return['meses'];
    $eventos = $return['eventos'];
    $noticias = $return['noticias'];
    $casas = $return['casas'];
    $parceiros = $return['parceiros'];

    $filtrosMesesDias = $return['filtrosMesesDias'];
?>
@extends('layouts.site')

@section('metatags')
<!-- FACEBOOK -->
<meta property="og:locale" content="pt_BR">
<meta property="og:url" content="http://www.clandestina.com.br">
<meta property="og:title" content="Clandestina">
<meta property="og:site_name" content=" Clandestina">
<meta property="og:description" content="A Clandestina nasce de um sonho. Um sonho de cidade viva, vivaz, vivida. Um sonho de gente reunida, de informação ao acesso de todos, de cultura do povo na boca do povo. Temos uma vontade ambiciosa de ajudar a fortalecer a cena de Porto Alegre e enxergamos nossa iniciativa como uma das muitas engrenagens que, juntas, podem sim gerar transformação. ">
<meta property="og:image" content="http://www.clandestina.com.br/clandestina.jpg">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="500">
<meta property="og:image:height" content="500">
<meta property="og:type" content="website">
@endsection

@section('css')
    <link href="/css/pages/home.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <!-- OWL -->
    <link href="/plugins/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins/owl_carousel/owl.theme.css" rel="stylesheet">
@endsection

@section('js')
    <script src="/js/pages/home.js"></script>
    <script src="/js/pages/modal-news-letter.js"></script>
    <script src="/js/pages/ajaxCards.js"></script>
    <!-- OWL -->
    <script src="/plugins/owl_carousel/owl.carousel.js"></script>
@endsection

@section('content')

<!-- Modal Newsletter -->
<div id="modalNewsLetter" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="form-news-letter">
            <div class="col s12 title-sections">RECEBA NOSSA AGENDA</div>

            <form method="post">
                {{ csrf_field() }}
                <div class="col s12 l6 offset-l3">
                    <input type="text" class="browser-default" id="name" placeholder="NOME*" name="name" maxlength="240" />
                </div>
                <div class="col s12 l6 offset-l3">
                    <input type="text" class="browser-default" id="email" placeholder="E-MAIL*" name="email" maxlength="100" />
                </div>
                <div class="col s12 l6 offset-l3">
                    <input type="text" class="browser-default" id="whatsapp" placeholder="WHATSAPP" name="whatsapp" maxlength="20" />
                </div>

                <div class="categorias">
                    <div class="interesses">Selecione os assuntos de interesse</div>
                @foreach($categorias as $categoria)
                    <label for="checkbox{{$categoria->id}}">
                        <input type="checkbox" id="checkbox{{$categoria->id}}" value="{{$categoria->id}}|{{$categoria->name}}" name="categoria" />
                        <span>
                            <div class="img-categorias" style="background-image: url('/{{$categoria->namefilefull}}');"></div>
                        </span>
                    </label>
                    <!-- <div class="img-categorias" style="background-image: url('/{{$categoria->namefilefull}}');"></div> -->
                @endforeach
                </div>
                <div class="col s12 l6 offset-l3">
                    <input type="button" class="browser-default cadastrar-newsletter-modal" value="CADASTRAR" />
                </div>
            </form>
        </div>
    </div>

    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<div class="clearfix"></div>
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
@if($banners->count())
<div class="carousel carousel-slider center">
    <?php /*
    <div class="left-right">
        <div class="container">
            <div class="row">
                <div class="col s6"><div class="controls-styles control-left"></div></div>
                <div class="col s6"><div class="controls-styles control-right right"><i class="medium material-icons corrige-seta">chevron_right</i></div></div>
            </div>
        </div>
    </div>
    */ ?>

    @foreach($banners as $banner)
    <?php
        $img = '/images/default.png';
        if ( $banner->banner_principal_namefilefull != '' ) { $img = '/' . $banner->banner_principal_namefilefull; }
        $titleLink = str_slug($banner->name, '-');

        $link = '/';
        switch ($banner->tabela) {
            case "programacoes":
                $link = '/evento/'.$banner->id.'/'.$titleLink;
                break;
            case "noticias":
                $link = '/conteudo/noticia/'.$banner->id.'/'.$titleLink;
                break;
            case "casas":
                $link = '/lugares/lugar/'.$banner->id.'/'.$titleLink;
                break;
        }
    ?>

    <a href="{{$link}}">
    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('{{asset($img)}}');">
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l6 offset-l6">

                        <table style="color: #000;"><tr><td>
                            <p>
                                @if ( isset($banner->calendario[0]) )
                                <div class="datas" style="border-color: #000;">
                                    <span>
                                        <p>{{$banner->calendario[0]['dia']}}</p>
                                        <div class="divisao" style="background-color: #000;"></div>
                                        <p>{{strtoupper($banner->calendario[0]['mes'])}}</p>
                                    </span>

                                    @if( count($banner->calendario) > 1 )
                                    <span>
                                        <div class="A-topo" style="background-color: #000;"></div>
                                        <div class="Div-A">{{$banner->calendario[1]}}</div>
                                        <div class="A-button" style="background-color: #000;"></div>
                                    </span>
                                    <span>
                                        <p>{{$banner->calendario[2]['dia']}}</p>
                                        <div class="divisao" style="background-color: #000;"></div>
                                        <p>{{strtoupper($banner->calendario[2]['mes'])}}</p>
                                    </span>
                                    @endif
                                </div>
                                @endif
                                <div class="clearfix"></div>
                            </p>
                            <p><span>{{$banner->title_banner != '' ? $banner->title_banner : $banner->name}}</span></p>

                        </td></tr></table>

                    </div>
                    @if($banner->legenda_banner != '')
                        <div class="legenda-banner">{{$banner->legenda_banner}}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </a>
    @endforeach

    <?php /*
    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('/imgs/DELETAR/bannerhome1.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l6 offset-l6">
                        <table style="color: #474142;"><tr><td>
                            <p>
                                <div class="datas" style="border-color: #474142;">
                                    <span>
                                        <p>03</p>
                                        <div class="divisao" style="background-color: #474142;"></div>
                                        <p>AGO</p>
                                    </span>
                                    <span>
                                        <div class="A-topo" style="background-color: #474142;"></div>
                                        <div class="Div-A">A</div>
                                        <div class="A-button" style="background-color: #474142;"></div>
                                    </span>
                                    <span>
                                        <p>03</p>
                                        <div class="divisao" style="background-color: #474142;"></div>
                                        <p>AGO</p>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </p>
                            <p>FANTASMA</p>
                            <p>FÁBIO ZIMBRES</p>
                            <p>NA BOLSA DE ARTE</p>
                        </td></tr></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('/imgs/DELETAR/bannerhome1.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l6 offset-l6">
                        <table><tr><td>
                            <p>
                                <div class="datas">
                                    <span>
                                        <p>03</p>
                                        <p>AGO</p>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </p>
                            <p>FANTASMA</p>
                            <p>FÁBIO ZIMBRES</p>
                            <p>NA BOLSA DE ARTE</p>
                        </td></tr></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('/imgs/DELETAR/bannerhome1.jpg');">
            <div class="container">
                <table><tr><td>
                    <p>FANTASMA</p>
                    <p>FÁBIO ZIMBRES</p>
                    <p>NA BOLSA DE ARTE</p>
                </td></tr></table>
            </div>
        </div>
    </div>

    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('/imgs/DELETAR/bannerhome1.jpg');">
            <div class="container">
                <table><tr><td>
                    <p>FANTASMA</p>
                </td></tr></table>
            </div>
        </div>
    </div>
    */ ?>

    <?php /*
    <div class="carousel-item amber white-text" href="#two!">
        <h2>Second Panel</h2>
        <p class="white-text">This is your second panel</p>
    </div>
    */ ?>
</div>
@endif
{{--
<div class="container">
    <div class="coracao hide-on-med-and-down"></div>
</div>
--}}
<!-- ======================================================================= -->
<!-- Filtros                                                                 -->
<!-- ======================================================================= -->

<section id="filtros">
    <div class="container">
        <div class="col s12 title-sections"><a href="/agenda">AGENDA</a></div>

        <div class="s12">
            <div class="box-filtro-meses">
                <div id="owl-filtros-meses" class="owl-filtros-meses">

                    <?php /*
                    @foreach($meses as $mes)
                        @if ($loop->first)
                            <div class="item"><div class="box-mes ative"><p>{{$mes['nome']}}</p></div></div>
                        @else
                            <div class="item"><div class="box-mes"><p>{{$mes['nome']}}</p></div></div>
                        @endif
                    @endforeach
                    */ ?>
                    @foreach($filtrosMesesDias['meses'] as $item)
                        <div class="item"><div class="box-mes" data="{{json_encode($item)}}"><p>{{$item['nome']}}</p></div></div>
                    @endforeach
                    <?php /*
                    <div class="item"><div class="box-mes ative"><p>JANEIRO</p>  </div></div>
                    <div class="item"><div class="box-mes"><p>FEVEREIRO</p></div></div>
                    <div class="item"><div class="box-mes"><p>MARÇO</p>    </div></div>
                    <div class="item"><div class="box-mes"><p>ABRIL</p>    </div></div>
                    <div class="item"><div class="box-mes"><p>MAIO</p>     </div></div>
                    <div class="item"><div class="box-mes"><p>JUNHO</p>    </div></div>
                    <div class="item"><div class="box-mes"><p>JULHO</p>    </div></div>
                    <div class="item"><div class="box-mes"><p>AGOSTO</p>   </div></div>
                    <div class="item"><div class="box-mes"><p>SETEMBRO</p> </div></div>
                    <div class="item"><div class="box-mes"><p>OUTUBRO</p>  </div></div>
                    <div class="item"><div class="box-mes"><p>NOVEMBRO</p> </div></div>
                    <div class="item"><div class="box-mes"><p>DEZEMBRO</p> </div></div>
                    */ ?>
                </div>
            </div>
        </div>
        <div class="clearfix h-20"></div>
        <div class="s12">
            <div class="box-filtro-dias">
                <div id="owl-filtros-dias" class="owl-filtros-dias">

                    @foreach($filtrosMesesDias['dias'] as $item)
                        <div class="item"><div class="box-dia" data="{{json_encode($item)}}"><div><p>{{$item['numero']}}</p><p>{{$item['nome']}}</p></div></div></div>
                    @endforeach

                    <?php /*
                    <div class="item"><div class="box-dia active"><div><p>01</p><p>SÁB</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>02</p><p>DOM</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>03</p><p>SEG</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>04</p><p>TER</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>05</p><p>QUA</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>06</p><p>QUI</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>07</p><p>SEX</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>08</p><p>SÁB</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>09</p><p>DOM</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>10</p><p>SEG</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>11</p><p>TER</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>12</p><p>QUA</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>13</p><p>QUI</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>14</p><p>SEX</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>15</p><p>SÁB</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>16</p><p>DOM</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>17</p><p>SEG</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>18</p><p>TER</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>19</p><p>QUA</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>20</p><p>QUI</p></div></div></div>
                    <div class="item"><div class="box-dia"><div><p>21</p><p>SEX</p></div></div></div>
                    */ ?>
                </div>
            </div>
        </div>
        <div class="clearfix h-30"></div>

        <div class="row">
              <div class="col s12">
                  <div class="box-filtro">
                      <div id="owl-filtros" class="owl-filtros">

                          @foreach($categorias as $categoria)
                              <div class="item tooltipped box-cat" data="{{json_encode($categoria)}}" data-position="bottom" data-tooltip="{{$categoria->name}}" data-background-color="{{$categoria->color}}">
                                  <div class="img-categorias" style="background-image: url('/{{$categoria->namefilefull}}'); /*border-color: {{$categoria->color}};*/"></div>
                              </div>
                          @endforeach
                          <!--
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Música" data-background-color="#ff0000">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria1.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Cinema" data-background-color="#78b3ae">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria2.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Teatro">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria3.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Arte">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria4.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Literatura">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria5.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Dança">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria6.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Festa de Rua">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria7.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Boate">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria8.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Gastronomia">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria9.png'); border-color: red;"></div>
                          </div>
                          <div class="item tooltipped" data-position="bottom" data-tooltip="Grátis">
                              <div class="img-categorias" style="background-image: url('/imgs/DELETAR/categorias/categoria10.png'); border-color: red;"></div>
                          </div>
                           -->
                      </div>
                  </div>
              </div>
        </div>

        <div class="clearfix h-5"></div>

    </div>
</section>

<!-- ======================================================================= -->
<!-- Cards                                                                   -->
<!-- ======================================================================= -->
<section id="card">
    <div class="container">

        <div class="row">
            @foreach($eventos as $evento)
                <?php
                    $img = '/images/default.png';
                    if ( $evento->banner_principal_namefilefull != '' ) { $img = '/' . $evento->banner_principal_namefilefull; }
                    if ( $evento->imagem_principal_namefilefull != '' ) { $img = '/' . $evento->imagem_principal_namefilefull; }
                    $titleLink = str_slug($evento->name, '-');

                    $cor = '#000000';
                    if (isset($evento->categorias->toArray()[0]->color)) {
                        $cor = $evento->categorias->toArray()[0]->color;
                    }
                ?>
                <div class="col s12 m6 xl4">
                    <a href="/evento/{{$evento->id}}/{{$titleLink}}">
                    <div class="card" style="box-shadow: 12px 12px {{$cor}}; background-image: url('{{asset($img)}}')">
                        <div class="card-background">
                            <div class="card-calendario">
                                <ul>
                                    <li>Dom</li>
                                    <li>03</li>
                                    <li>Ago</li>
                                </ul>
                                <ul>
                                  <li><div class="divisao"></div></li>
                                  <li class="divisorLi">A</li>
                                  <li><div class="divisao"></div></li>
                                </uL>
                                <ul>
                                    <li>SEG</li>
                                    <li>19</li>
                                    <li>SET</li>
                                </ul>
                            </div>
                            <div class="card-texto valign-wrapper" style="background-color: {{$cor}}50;">
                                @if ( isset($evento->categorias->toArray()[0]->namefilefull) )
                                <div style="background-image: url('{{asset('/'.$evento->categorias->toArray()[0]->namefilefull)}}')"></div>
                                @endif
                                <ul>
                                  <li>{{str_limit($evento->name, 35, '...')}}</li>
                                  <!-- <li>{!!str_limit($evento->texto_evento, 35, '...')!!}</li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach()
            <?php /*
            <div class="col s12 m6 xl4">
                <a href="/evento">
                <div class="card" style="box-shadow: 12px 12px #f7cd82; background-image: url('/imgs/DELETAR/evento1.jpg')">
                    <div class="card-background">
                        <div class="card-calendario">
                            <ul>
                                <li>01</li>
                                <li>SAB</li>
                            </ul>
                        </div>
                        <div class="card-texto valign-wrapper" style="background-color: #f7cd8250;">
                            <div style="background-image: url('/imgs/DELETAR/categorias/categoria1.png')"></div>
                            <ul>
                                <li>Foo fighters</li>
                                <li>Estádio beira-rio</li>
                            </ul>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col s12 m6 xl4">
                <a href="/evento">
                <div class="card" style="box-shadow: 12px 12px #46b29d; background-image: url('/imgs/DELETAR/evento2.jpg')">
                    <div class="card-background">
                        <div class="card-calendario">
                            <ul>
                                <li>01</li>
                                <li>SAB</li>
                            </ul>
                        </div>
                        <div class="card-texto valign-wrapper" style="background-color: #46b29d50;">
                            <div style="background-image: url('/imgs/DELETAR/categorias/categoria2.png')"></div>
                            <ul>
                                <li>Foo fighters</li>
                                <li>Estádio beira-rio</li>
                            </ul>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col s12 m6 xl4">
                <a href="/evento">
                <div class="card" style="box-shadow: 12px 12px #f24150; background-image: url('/imgs/DELETAR/evento3.jpg')">
                    <div class="card-background">
                        <div class="card-calendario">
                            <ul>
                                <li>01</li>
                                <li>SAB</li>
                            </ul>
                        </div>
                        <div class="card-texto valign-wrapper" style="background-color: #f2415050;">
                            <div style="background-image: url('/imgs/DELETAR/categorias/categoria3.png')"></div>
                            <ul>
                                <li>Foo fighters</li>
                                <li>Estádio beira-rio</li>
                            </ul>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            */ ?>
        </div>
    </div>
    <div class="container conteiner-carregar-mais">
        <div class="col s12 center-align">
            <input type="button" class="carregarmais" value="CARREGAR MAIS" />
        </div>
    </div>
</section>


<!-- ======================================================================= -->
<!-- Newsletter                                                              -->
<!-- ======================================================================= -->
<section id="newsletter">
      <div class="container-fluid">
          <div class="pomba hide-on-med-and-down"></div>
          <div class="container">

            <div class="row">
                <div class="col s12 title-sections">RECEBA NOSSA AGENDA</div>
                <form method="post">
                    {{ csrf_field() }}
                    <div class="col s12 l6 offset-l3">
                        <input type="text" class="browser-default" placeholder="NOME" id="name" name="name" maxlength="240" />
                    </div>
                    <div class="col s12 l6 offset-l3">
                        <input type="text" class="browser-default" placeholder="E-MAIL" id="email" name="email" maxlength="100" />
                    </div>
                    <div class="col s12 l6 offset-l3">
                        <input type="button" class="browser-default cadastrar-newsletter" value="CADASTRAR" />
                    </div>
                </form>
            </div>
          </div>
      </div>
</section>



<!-- ======================================================================= -->
<!-- Conteúdo                                                                -->
<!-- ======================================================================= -->
<section id="conteudo">
      <div class="container-fluid">
          <div class="container">
              <div class="megafone hide-on-med-and-down"></div>
              <div class="row">
                  <div class="col s12 title-sections conteudo-home"><a href="/conteudo">CONTEÚDO</a></div>
              </div>
              <div id="card-conteudo" class="row">

                  @foreach($noticias as $noticia)
                      <?php
                          $img = '/images/default.png';
                          if ( $noticia->banner_principal_namefilefull != '' ) { $img = '/' . $noticia->banner_principal_namefilefull; }
                          if ( $noticia->imagem_principal_namefilefull != '' ) { $img = '/' . $noticia->imagem_principal_namefilefull; }
                          $titleLink = str_slug($noticia->name, '-');
                          $cor = '#000000';
                          if (isset($noticia->categorias->toArray()[0]->color)) {
                              $cor = $noticia->categorias->toArray()[0]->color;
                          }

                          if ($noticia->pelicula == 'player' ) {
                              $pelicula = 'url(/imgs/Home/play.png), ';
                          } elseif ($noticia->pelicula == 'galeria' ) {
                              $pelicula = 'url(/imgs/Home/galeria.png), ';
                          } else {
                              $pelicula = 'url(/imgs/Home/padrao.png), ';
                          }
                      ?>
                      <div class="col s12 m6 xl4">
                          <div>
                              <a href="/conteudo/noticia/{{$noticia->id}}/{{$titleLink}}">
                                  <div class="box-card" style="border-color: {{$cor}};">
                                      <div class="img-card" style="background-image: {{$pelicula}} url('{{asset($img)}}')"><div><div></div></div></div>
                                      <div class="texto-card">
                                          <?php
                                              $date = new DateTime($noticia->created_at);
                                          ?>
                                          <div class="data-conteudo">{{$date->format('d/m/Y')}}</div>
                                          <div class="titulo-conteudo">{{str_limit($noticia->name, 200, '')}}</div>
                                          <div class="texto hide-on-small-only">{{$noticia->sub_title}}</div>
                                      </div>
                                  </div>
                                  <div class="leia-mais hide-on-small-only" style="border-color: {{$cor}}; background-color: {{$cor}};"><div>leia mais</div></div>
                              </a>
                          </div>
                      </div>
                  @endforeach()


                  <?php /*
                  <div class="col s12 m6 xl4">
                      <div>
                          <a href="">
                              <div class="box-card" style="border-color: #324d5c;">
                                  <div class="img-card" style="background: url('/imgs/DELETAR/conteudo1.jpg') no-repeat;"><div><div></div></div></div>
                                  <div class="texto-card">
                                      <div class="titulo-conteudo">BRUNO 9LI</div>
                                      <div class="texto hide-on-small-only">Inspirations come from daily life experiences of the diverse population of its residents (European, Japanese and Latin American descent) as well as his search for life's meaning through spirituality, alchemy and cultural symbolisms.</div>
                                  </div>
                              </div>
                              <div class="leia-mais hide-on-small-only" style="border-color: #324d5c; background-color: #324d5c;"><div>leia mais</div></div>
                          </a>
                      </div>
                  </div>
                  <div class="col s12 m6 xl4">
                      <div>
                          <a href="">
                              <div class="box-card" style="border-color: #f7cd82;">
                                  <div class="img-card" style="background: url('/imgs/DELETAR/conteudo2.jpg') no-repeat;"><div><div></div></div></div>
                                  <div class="texto-card">
                                      <div class="titulo-conteudo">BRUNO 9LI</div>
                                      <div class="texto hide-on-small-only">Inspirations come from daily life experiences of the diverse population of its residents (European, Japanese and Latin American descent) as well as his search for life's meaning through spirituality, alchemy and cultural symbolisms.</div>
                                  </div>
                              </div>
                              <div class="leia-mais hide-on-small-only" style="border-color: #f7cd82; background-color: #f7cd82;"><div>leia mais</div></div>
                          </a>
                      </div>
                  </div>
                  <div class="col s12 m6 xl4">
                      <div>
                          <a href="">
                              <div class="box-card" style="border-color: #9e2550;">
                                  <div class="img-card" style="background: url('/imgs/DELETAR/conteudo3.jpg') no-repeat;"><div><div></div></div></div>
                                  <div class="texto-card">
                                      <div class="titulo-conteudo">BRUNO 9LI</div>
                                      <div class="texto hide-on-small-only">Inspirations come from daily life experiences of the diverse population of its residents (European, Japanese and Latin American descent) as well as his search for life's meaning through spirituality, alchemy and cultural symbolisms.</div>
                                  </div>
                              </div>
                              <div class="leia-mais hide-on-small-only" style="border-color: #9e2550; background-color: #9e2550;"><div>leia mais</div></div>
                          </a>
                      </div>
                  </div>


                  <div class="col s12 m6 xl4">
                      <div>
                          <a href="">
                              <div class="box-card" style="border-color: #324d5c;">
                                  <div class="img-card" style="background: url('/imgs/DELETAR/conteudo1.jpg') no-repeat;"><div><div></div></div></div>
                                  <div class="texto-card">
                                      <div class="titulo-conteudo">BRUNO 9LI</div>
                                      <div class="texto hide-on-small-only">Inspirations come from daily life experiences of the diverse population of its residents (European, Japanese and Latin American descent) as well as his search for life's meaning through spirituality, alchemy and cultural symbolisms.</div>
                                  </div>
                              </div>
                              <div class="leia-mais hide-on-small-only" style="border-color: #324d5c; background-color: #324d5c;"><div>leia mais</div></div>
                          </a>
                      </div>
                  </div>
                  <div class="col s12 m6 xl4">
                      <div>
                          <a href="">
                              <div class="box-card" style="border-color: #f7cd82;">
                                  <div class="img-card" style="background: url('/imgs/DELETAR/conteudo2.jpg') no-repeat;"><div><div></div></div></div>
                                  <div class="texto-card">
                                      <div class="titulo-conteudo">BRUNO 9LI</div>
                                      <div class="texto hide-on-small-only">Inspirations come from daily life experiences of the diverse population of its residents (European, Japanese and Latin American descent) as well as his search for life's meaning through spirituality, alchemy and cultural symbolisms.</div>
                                  </div>
                              </div>
                              <div class="leia-mais hide-on-small-only" style="border-color: #f7cd82; background-color: #f7cd82;"><div>leia mais</div></div>
                          </a>
                      </div>
                  </div>
                  <div class="col s12 m6 xl4">
                      <div>
                          <a href="">
                              <div class="box-card" style="border-color: #9e2550;">
                                  <div class="img-card" style="background: url('/imgs/DELETAR/conteudo3.jpg') no-repeat;"><div><div></div></div></div>
                                  <div class="texto-card">
                                      <div class="titulo-conteudo">BRUNO 9LI</div>
                                      <div class="texto hide-on-small-only">Inspirations come from daily life experiences of the diverse population of its residents (European, Japanese and Latin American descent) as well as his search for life's meaning through spirituality, alchemy and cultural symbolisms.</div>
                                  </div>
                              </div>
                              <div class="leia-mais hide-on-small-only" style="border-color: #9e2550; background-color: #9e2550;"><div>leia mais</div></div>
                          </a>
                      </div>
                  </div>
                  */ ?>

              </div>
          </div>
      </div>
</section>



<!-- ======================================================================= -->
<!-- Casas                                                                   -->
<!-- ======================================================================= -->
<section id="locais">
      <div class="container-fluid">
          <div class="sol hide-on-med-and-down"></div>
          <div class="container">

            <div class="row">
                <div class="col s12 title-sections"><a href="/lugares">LUGARES</a></div>
            </div>
            <div class="row">
                <div id="owl-locais" class="owl-locais">

                    @foreach($casas as $casa)
                        <?php
                            $img = '/images/default.png';
                            if ( $casa->banner_principal_namefilefull != '' ) { $img = '/' . $casa->banner_principal_namefilefull; }
                            if ( $casa->imagem_principal_namefilefull != '' ) { $img = '/' . $casa->imagem_principal_namefilefull; }
                            $titleLink = str_slug($casa->name, '-');
                        ?>
                        <div class="item">
                            <a href="/lugares/lugar/{{$casa->id}}">
                            <div class="box-container">
                                <div class="box-local">
                                    <div class="img-local" style="background-image: url('{{asset($img)}}')"></div>
                                    <div class="text-local">
                                        <p class="truncate">{{str_limit($casa->name, 35, '...')}}</p>
                                        <p class="truncate">{{$casa->sub_title}}</p>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    @endforeach()
                    <?php /*
                    <div class="item">
                        <a href="/local">
                        <div class="box-container">
                            <div class="box-local">
                                <div class="img-local" style="background-image: url({{asset('/imgs/DELETAR/local1.jpg')}})"></div>
                                <div class="text-local">
                                    <p class="truncate">AGULHA</p>
                                    <p class="truncate">bar casa noturna</p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="item">
                        <a href="/local">
                        <div class="box-container">
                            <div class="box-local">
                                <div class="img-local" style="background-image: url({{asset('/imgs/DELETAR/local2.jpg')}})"></div>
                                <div class="text-local">
                                    <p class="truncate">AGULHA</p>
                                    <p class="truncate">bar casa noturna</p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="item">
                        <a href="/local">
                        <div class="box-container">
                            <div class="box-local">
                                <div class="img-local" style="background-image: url({{asset('/imgs/DELETAR/local3.jpg')}})"></div>
                                <div class="text-local">
                                    <p class="truncate">AGULHA</p>
                                    <p class="truncate">bar casa noturna</p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    */ ?>
                </div>

                <div class="vitrola hide-on-med-and-down"></div>
            </div>
          </div>
      </div>
</section>


<!-- ======================================================================= -->
<!-- Parceiros                                                               -->
<!-- ======================================================================= -->
@if (count($parceiros))
<section id="parceiros">
      <div class="container-fluid">
          <div class="pomba hide-on-med-and-down"></div>
          <div class="container">
            <div class="row">
                <div class="col s12 title-sections"><a href="/parceiros">PARCEIROS</a>{{-- <span class="hide-on-med-and-down">DA CLANDESTINA</span> --}}</div>
            </div>
            <div class="row">
                <!-- <div class="col s12 title-sections">PARCEIROS <span class="hide-on-med-and-down">DA CLANDESTINA</span></div> -->
                <div id="owl-parceiros" class="owl-parceiros">
                    @foreach($parceiros as $item)
                        <?php
                            $imgLogo = 'images/default.png';

                            if ($item->image_logo_namefilefull != '') {
                                $imgLogo = $item->image_logo_namefilefull;
                            }
                        ?>

                        <div class="item"><a href="/parceiros"><div class="parceiros" style="background-image: url(/{{$imgLogo}})"></div></a></div>
                        <?php /*
                        <div class="item"><a href="/parceiros"><div class="parceiros" style="background-image: url({{asset('/imgs/Parceiros/logo_cinematografica.png')}})"></div></a></div>
                        <div class="item"><a href="/parceiros"><div class="parceiros" style="background-image: url({{asset('/imgs/Parceiros/logo_agulha.png')}})"></div></a></div>
                        <div class="item"><a href="/parceiros"><div class="parceiros" style="background-image: url({{asset('/imgs/Parceiros/logo_fil.png')}})"></div></a></div>
                        <div class="item"><a href="/parceiros"><div class="parceiros" style="background-image: url({{asset('/imgs/Parceiros/logo_zapata.png')}})"></div></a></div>
                        <div class="item"><a href="/parceiros"><div class="parceiros" style="background-image: url({{asset('/imgs/Parceiros/logo_casa_agora.png')}})"></div></a></div>
                        <div class="item"><a href="/parceiros"><div class="parceiros" style="background-image: url({{asset('/imgs/Parceiros/logo_marquise.png')}})"></div></a></div>
                        <div class="item"><a href="/parceiros"><div class="parceiros" style="background-image: url({{asset('/imgs/Parceiros/logo_aldeia.png')}})"></div></a></div>
                        */ ?>
                    @endforeach
                </div>
            </div>
          </div>
      </div>
</section>
@endif

@endsection

<?php
    $categorias = $return['categorias'];
    $banners = $return['banners'];
    $eventos = $return['eventos'];
    $color = '#000';
    $noticias = $return['noticias'];
?>
@extends('layouts.site')

@section('css')
    <link href="css/pages/conteudo.css" rel="stylesheet" />
    <!-- OWL -->
    <link href="/plugins/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins/owl_carousel/owl.theme.css" rel="stylesheet">
@endsection

@section('js')
    <script src="/js/pages/home.js"></script>
    <script src="/js/pages/ajaxConteudo.js"></script>
    <!-- OWL -->
    <script src="/plugins/owl_carousel/owl.carousel.js"></script>
@endsection

@section('content')
<div class="clearfix"></div>
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
@if($banners->count())
<div class="carousel carousel-slider center">
    @foreach($banners as $banner)
    <?php
        $img = '/images/default.png';
        if ( $banner->banner_principal_namefilefull != '' ) { $img = '/' . $banner->banner_principal_namefilefull; }
        $titleLink = str_slug($banner->name, '-');
    ?>
    <a href="/conteudo/noticia/{{$banner->id}}/{{$titleLink}}">
    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('{{asset($img)}}');">
            <div class="container">
                <div class="row">

                    <div class="col s12 m12 l6 offset-l6">

                      <table style="color: {{$color}};"><tr><td>
                        <p><span>{{$banner->title_banner != '' ? $banner->title_banner : $banner->name}}</span></p>
                        <p class="data-banner"><span>{{$banner->data}}</span></p>
                        </td></tr></table>
                    </div>
                </div>
            </div>
            @if($banner->legenda_banner != '')
                <div class="legenda-banner">{{$banner->legenda_banner}}</div>
            @endif
        </div>
    </div>
    </a>
    @endforeach
</div>
@endif
<div class="container hide-on-med-and-down">
    <div class="megafone"></div>
    <div class="busca-conteudo">
        <form id="form-conteudo" action="" method="get">
            <input type="text" id="search" class="browser-default" name="search" placeholder="digite sua busca" value="" />
            <input type="submit" id="bt-search" value="" />
        </form>
    </div>
    <div class="clearfix"></div>
</div>
<!--div class="row">
    <div class="col s12 title-sections">CONTEÚDO</div>
</div-->
<!-- ======================================================================= -->
<!-- Cards                                                                   -->
<!-- ======================================================================= -->
<section id="filtros">
    <div class="container">
        {{-- <div class="col s12 title-sections">AGENDA</div> --}}

        <div class="clearfix h-5"></div>

        <div class="row">
              <div class="col s12">
                  <div class="box-filtro">
                      <div id="owl-filtros" class="owl-filtros">

                          @foreach($categorias as $categoria)
                              <div class="item tooltipped box-cat" data="{{json_encode($categoria)}}" data-position="bottom" data-tooltip="{{$categoria->name}}" data-background-color="{{$categoria->color}}">
                                  <div class="img-categorias" style="background-image: url('/{{$categoria->namefilefull}}'); /*border-color: {{$categoria->color}};*/"></div>
                              </div>
                          @endforeach
                      </div>
                  </div>
              </div>
        </div>

        <div class="clearfix h-5"></div>
    </div>
</section>


<!-- ======================================================================= -->
<!-- Conteúdo                                                                -->
<!-- ======================================================================= -->
<section id="conteudo">
      <div class="container-fluid">
          <div class="container">
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
                                          <div class="titulo-conteudo">{{str_limit($noticia->name, 35, '...')}}</div>
                                          <div class="texto hide-on-small-only">{{$noticia->sub_title}}</div>
                                      </div>
                                  </div>
                                  <div class="leia-mais hide-on-small-only" style="border-color: {{$cor}}; background-color: {{$cor}};"><div>leia mais</div></div>
                              </a>
                          </div>
                      </div>
                  @endforeach()
              </div>
          </div>
      </div>

      <div class="container conteiner-carregar-mais">
          <div class="col s12 center-align">
              <input type="button" class="carregarmais" value="CARREGAR MAIS" />
          </div>
      </div>
</section>

@endsection

<?php
    $categorias = $return['categorias'];
    $banners = $return['banners'];
    $eventos = $return['eventos'];
    $color = '#000';
    $casas = $return['casas'];
?>
@extends('layouts.site')

@section('css')
    <link href="css/pages/casas.css" rel="stylesheet" />
    <!-- OWL -->
    <link href="/plugins/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins/owl_carousel/owl.theme.css" rel="stylesheet">
@endsection

@section('js')
    <script src="/js/pages/home.js"></script>
    <script src="/js/pages/ajaxCasas.js"></script>
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
    <a href="/lugares/lugar/{{$banner->id}}/{{$titleLink}}">
    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('{{asset($img)}}');">
            <div class="container">
                <div class="row">

                    <div class="col s12 m12 l12">
                      <table style="color: {{$color}};"><tr><td class="corrige-td">
                        <p><span>{{$banner->name}}</span></p>
                        {{--
                        @if( $banner->sub_title != '' )
                        <p><span>{!!str_limit(strtoupper($banner->sub_title), 35, '...')!!}</span></p>
                        @endif
                        --}}
                        </td></tr></table>
                    </div>
                </div>
            </div>
        </div>
        @if($banner->legenda_banner != '')
            <div class="legenda-banner">{{$banner->legenda_banner}}</div>
        @endif
    </div>
    </a>
    @endforeach
</div>
@endif

<div class="container hide-on-med-and-down">
    <div class="sol"></div>
    <div class="busca-conteudo">
        <form id="form-lugares" action="" method="get">
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
<!-- Casas                                                                   -->
<!-- ======================================================================= -->
<section id="locais">
      <div class="container-fluid">
          <div class="container">
            <div class="row">

            @foreach($casas as $casa)
                <?php
                $img = '/images/default.png';
                if ( $casa->banner_principal_namefilefull != '' ) { $img = '/' . $casa->banner_principal_namefilefull; }
                if ( $casa->imagem_principal_namefilefull != '' ) { $img = '/' . $casa->imagem_principal_namefilefull; }
                $titleLink = str_slug($casa->name, '-');
                ?>
                <div class="col s12 m6 xl4">
                    <div class="espacamento-cards">
                        <a href="/lugares/lugar/{{$casa->id}}/{{$titleLink}}">
                        <div class="box-container">
                            <div class="box-local">
                                <div class="img-local" style="background-image: url('{{asset($img)}}')"></div>
                                <div class="text-local">
                                    <p class="truncate">{{str_limit($casa->name, 35, '...')}}&nbsp;</p>
                                    <p class="truncate">{{$casa->sub_title}}&nbsp;</p>
                                </div>
                            </div>
                        </div>
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

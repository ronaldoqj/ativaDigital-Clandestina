<?php
    $categorias = $return['categorias'];
    $banners = $return['banners'];
    $meses = $return['meses'];
    $eventos = $return['eventos'];
    $color = '#000';

    $filtrosMesesDias = $return['filtrosMesesDias'];
?>
@extends('layouts.site')

@section('css')
    <link href="css/pages/agenda.css" rel="stylesheet" />
    <!-- OWL -->
    <link href="/plugins/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins/owl_carousel/owl.theme.css" rel="stylesheet">
@endsection

@section('js')
    <script src="/js/pages/home.js"></script>
    <script src="/js/pages/ajaxCards.js"></script>
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
    <a href="/evento/{{$banner->id}}/{{$titleLink}}">
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

                  <?php /*
                    <div class="col l4 hide-on-med-and-down">
                        <table style="color: {{$color}};"><tr><td>
                            <div class="datas" style="border-color: {{$color}};">
                                <span>
                                    <p>{{$banner->calendario[0]['dia']}}</p>
                                    <div class="divisao" style="background-color: {{$color}};"></div>
                                    <p>{{strtoupper($banner->calendario[0]['mes'])}}</p>
                                </span>

                                @if( count($banner->calendario) > 1 )
                                <span>
                                    <div class="A-topo" style="background-color: {{$color}};"></div>
                                    <div class="Div-A">A</div>
                                    <div class="A-button" style="background-color: {{$color}};"></div>
                                </span>
                                <span>
                                    <p>{{$banner->calendario[2]['dia']}}</p>
                                    <div class="divisao" style="background-color: {{$color}};"></div>
                                    <p>{{strtoupper($banner->calendario[2]['mes'])}}</p>
                                </span>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </td></tr></table>
                    </div>

                    <div class="col s12 m12 l4">
                      <table style="color: {{$color}};"><tr><td class="corrige-td">
                        <p><span>{{$banner->name}}</span></p>
                       <!-- @if( $banner->sub_title != '' )
                        <p><span>{!!str_limit(strtoupper($banner->sub_title), 35, '...')!!}</span></p>
                        @endif -->
                        </td></tr></table>
                    </div>
                    */ ?>

                </div>
            </div>
        </div>
    </div>
    </a>
    @endforeach
</div>
@endif
<!-- <div class="container">
    <div class="relogio hide-on-med-and-down"></div>
</div> -->

<div class="container hide-on-med-and-down">
    <div class="relogio hide-on-med-and-down"></div>
    <div class="busca-conteudo">
        <form id="form-conteudo" action="" method="get">
            <input type="text" id="search" class="browser-default" name="search" placeholder="digite sua busca" value="" />
            <input type="submit" id="bt-search" value="" />
        </form>
    </div>
    <div class="clearfix"></div>
</div>

<!-- ======================================================================= -->
<!-- Filtros                                                                 -->
<!-- ======================================================================= -->
<section id="filtros">
    <div class="container">
        <div class="breadcrumbs"><a href="/">HOME</a> / AGENDA</div>
        <div class="col s12 title-sections"><a href="/agenda">AGENDA</a></div>

        <div class="s12">
            <div class="box-filtro-meses">
                <div id="owl-filtros-meses" class="owl-filtros-meses">
                    @foreach($filtrosMesesDias['meses'] as $item)
                        <div class="item"><div class="box-mes" data="{{json_encode($item)}}"><p>{{$item['nome']}}</p></div></div>
                    @endforeach
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
                                    <li>01</li>
                                    <li>SAB</li>
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
        </div>
    </div>
    <div class="container conteiner-carregar-mais">
        <div class="col s12 center-align">
            <input type="button" class="carregarmais" value="CARREGAR MAIS" />
        </div>
    </div>
</section>

@endsection

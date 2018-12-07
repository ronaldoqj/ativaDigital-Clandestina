<?php
    $galeria = $return['galeria'] ;
    $eventos = $return['eventos'];
    $retorno = $return['casa'];
    $color = '#ffc636';
    $filtrosMesesDias = $return['filtrosMesesDias'];

    $imgBanner = '/images/default.png';
    if($retorno->banner_principal_namefilefull != '') {
        $imgBanner = '/'.$retorno->banner_principal_namefilefull;
    }
    $imgImagem = '/images/default.png';
    if($retorno->imagem_principal_namefilefull != '') {
        $imgImagem = '/'.$retorno->imagem_principal_namefilefull;
    }
?>
@extends('layouts.site')

@section('metatags')
<meta property="og:url"           content="{{url("/lugares/lugar/{$retorno->id}/{$retorno->id}")}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$retorno->name}}" />
<meta property="og:description"   content="{{$retorno->sub_title}}" />
<meta property="og:image"         content="{{url("{$imgBanner}")}}" />
@endsection

@section('css')
    <link href="/css/pages/casa.css" rel="stylesheet" />
    <!-- OWL -->
    <link href="/plugins/owl_carousel/owl.carousel.css" rel="stylesheet">
    <link href="/plugins/owl_carousel/owl.theme.css" rel="stylesheet">
    <!-- lightbox  -->
    <link rel="stylesheet" href="/plugins-frameworks/lightbox/css/lightbox.min.css">
    <style>
        .evento-box { background: #9D224E; }
        .content { color: #9D224E; }
    </style>
@endsection

@section('js')
    <script src="/js/pages/local.js"></script>
    <script src="/js/pages/ajaxCards.js"></script>
    <!-- OWL -->
    <script src="/plugins/owl_carousel/owl.carousel.js"></script>
    <!-- lightbox -->
    <script src="/plugins-frameworks/lightbox/js/lightbox.min.js"></script>
@endsection

@section('content')
<div class="clearfix"></div>
<input type="hidden" id="recomendacao_id" name="recomendacao_id" value="{{$retorno->id}}" />
<input type="hidden" id="recomendacao_tabela" name="recomendacao_tabela" value="Casas" />
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
<div class="carousel carousel-slider center">
    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('{{asset($imgBanner)}}');"></div>
    </div>
</div>

<!-- ============================= Conteúdo ================================ -->
<div class="container conteudo">
    <div class="row m-b-0">
        <div class="col s12 m6 l6 xl6 left">
            <p class="titulo">{{$retorno->name}}</p>
            <div class="row valign-wrapper">
                <div class="col s12 m12 l12 xl12 valign-wrapper">
                    <span class="icon-text"> {{$retorno->sub_title}} </span>
                </div>
            </div>
            <div class="col s12 m12 l12 xl12">
              @foreach($retorno->categorias as $categoria)
                  <div class="div-categoria-item" style="background-image: url('{{asset('/'.$categoria->namefilefull)}}');"></div>
              @endforeach
            </div>
        </div>

        <div class="col s12 m6 l6 xl6 right">
            <img class="responsive-img sol" src="{{url('/imgs/Casas/sol.png')}}">
        </div>
    </div>

    <div class="row">
        @if($retorno->diashorarios != '' && $retorno->diashorarios2 != '')
            <div class="col s12 m6 l6 xl6 left">
                <div class="texts">{!!$retorno->diashorarios!!}</div>
            </div>
            <div class="col s12 m6 l6 xl6 left">
                <div class="texts">{!!$retorno->diashorarios2!!}</div>
            </div>
        @else
            <div class="col s12 m12 l12 xl12 left">
                <div class="texts">
                  @if($retorno->diashorarios != '')
                      {!!$retorno->diashorarios!!}
                  @else
                      {!!$retorno->diashorarios2!!}
                  @endif
                </div>
            </div>
        @endif

        <div class="col s12 m12">
            <div class="texts">
                <div class="titulos">Compartilhe</div>
            </div>

            <div class="row">
                <div class="s12 m12 l12 xl12 social">
                  <a href="{{url("/lugares/lugar/{$retorno->id}/{$retorno->name}")}}" title="Facebook" class="btSocialNetwork"><i class="fontello-icon icon-facebook">&#xe80d;</i></a>
                  <a href="{{url("/lugares/lugar/{$retorno->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a>
                  <a href="whatsapp://send?text={{$retorno->name}} - {{url("/lugares/lugar/{$retorno->id}")}}" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a>
                    <!-- <a href="#" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i></a> -->
                </div>
            </div>
        </div>

    </div>
</div>


<!-- ======================================================================= -->
<!-- Galeria                                                                 -->
<!-- ======================================================================= -->
@if(count($galeria))
<div class="container-fluid galeria">
    <div class="container">
        <div class="row">
            <div class="col s12 title-sections">GALERIA DE FOTOS</div>
        </div>
        <div class="row">
            <div id="owl-galeria" class="owl-galeria-index">
                @foreach($galeria as $fileGaleria)
                <div class="item">
                    <div class="foto-style style-1">
                        <a href="/{{$fileGaleria->file_namefilefull}}" data-lightbox="galeria" data-title="{{$fileGaleria->file_name}}">
                            <div class="card-background" style="background-image: url('/{{$fileGaleria->file_namefilefull}}')"></div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif


<!-- ======================================================================= -->
<!-- Cards                                                                   -->
<!-- ======================================================================= -->
@if(count($eventos))
<section id="card">
    <div class="container">
        <div class="col s12 title-sections uppercase"><a href="/agenda">AGENDA {{$retorno->name}}</a></div>
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
@endif


<!-- ======================================================================= -->
<!-- Localização                                                             -->
<!-- ======================================================================= -->
@if($retorno->localizacao != '')
<div class="container-fluid localizacao">
    <div class="container m-b-30">
        <ul>
            <li class="hide-on-small-only"><img class="icon-categoria" src="{{asset('/imgs/icon-localizacao.png')}}" alt="" height="38"></li>
            <li>
                <div class="tituloL1">{{$retorno->name}}</div>
                <div class="tituloL2">
                    {{$retorno->endereco}}
                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div>
        <div class="video-container">{!!$retorno->localizacao!!}</div>
    </div>
</div>
@endif()

@endsection

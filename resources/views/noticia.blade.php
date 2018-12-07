<?php
    $galeria = $return['galeria'] ;
    $retorno = $return['noticia'];
    $color = '#ffc636';

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
<meta property="og:url"           content="{{url("/conteudo/noticia/{$retorno->id}/{$retorno->id}")}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$retorno->name}}" />
<meta property="og:description"   content="{{$retorno->sub_title}}" />
<meta property="og:image"         content="{{url("{$imgBanner}")}}" />
@endsection

@section('css')
    <link href="/css/pages/noticia.css" rel="stylesheet" />
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
    <!-- OWL -->
    <script src="/plugins/owl_carousel/owl.carousel.js"></script>
    <!-- lightbox -->
    <script src="/plugins-frameworks/lightbox/js/lightbox.min.js"></script>
@endsection

@section('content')
<div class="clearfix"></div>
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
            <p class="data-completa">{{$retorno->dataCompleta}}</p>
            <p class="titulo">{{$retorno->name}}</p>
            <span class="subtitulo"> {{$retorno->sub_title}} </span>

            <div class="row valign-wrapper">
                <div class="col s12 m12 l12 xl12 valign-wrapper">

                    <div class="categoria-noticia">
                        <div class="box-icon-categoria">
                            <img class="icon-categoria icons-space" src="{{asset('/'.$retorno->categoria_namefilefull)}}" alt="" height="38">
                        </div>
                        <p>{{$retorno->categoria_name}}</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="col s12 m6 l6 xl6 right">
            <img class="responsive-img megafone" src="{{url('/imgs/Noticias/megafone.png')}}">
        </div>
    </div>

    <div class="row">
        @if($retorno->texto != '' && $retorno->texto2 != '')
            <div class="col s12 m6 l6 xl6 left">
                <div class="texts">{!!$retorno->texto!!}</div>
            </div>
            <div class="col s12 m6 l6 xl6 left">
                <div class="texts">{!!$retorno->texto2!!}</div>
            </div>
        @else
            <div class="col s12 m12 l12 xl12 left">
                <div class="texts">
                  @if($retorno->texto != '')
                      {!!$retorno->texto!!}
                  @else
                      {!!$retorno->texto2!!}
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
                  <a href="{{url("/conteudo/noticia/{$retorno->id}/{$retorno->name}")}}" title="Facebook" class="btSocialNetwork"><i class="fontello-icon icon-facebook">&#xe80d;</i></a>
                  <a href="{{url("/conteudo/noticia/{$retorno->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a>
                    <a href="whatsapp://send?text={{$retorno->name}} - {{url("/conteudo/noticia/{$retorno->id}")}}" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a>
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
                <!--
                <div class="item">
                    <div class="foto-style style-2">
                        <div class="card-background" style="background-image: url('/imgs/Eventos/img2.jpg')"></div>
                        <div class="card-background" style="background-image: url('/imgs/Eventos/img3.jpg')"></div>
                    </div>
                </div>
                <div class="item">
                    <div class="foto-style style-1">
                        <div class="card-background" style="background-image: url('/imgs/Eventos/img4.jpg')"></div>
                    </div>
                </div>
                 -->
            </div>
        </div>
    </div>
</div>
@endif

@endsection

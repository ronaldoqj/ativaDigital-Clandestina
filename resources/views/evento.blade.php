<?php
    $galeria = $return['galeria'] ;
    $eventos = $return['eventos'];
    $retorno = $return['evento'];
    $color = '#000000';
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
<meta property="og:url"           content="{{url("/evento/{$retorno->id}/{$retorno->id}")}}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$retorno->name}}" />
<meta property="og:description"   content="{{$retorno->sub_title}}" />
<meta property="og:image"         content="{{url("{$imgBanner}")}}" />
@endsection

@section('css')
    <link href="/css/pages/evento.css" rel="stylesheet" />
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
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
<div class="carousel carousel-slider center">
    <!--div class="left-right">
        <div class="container">
            <div class="row">
                <div class="col s6"><div class="controls-styles control-left"><i class="medium material-icons corrige-seta">chevron_left</i></div></div>
                <div class="col s6"><div class="controls-styles control-right right"><i class="medium material-icons corrige-seta">chevron_right</i></div></div>
            </div>
        </div>
    </div-->

    <div class="carousel-item white-text" href="#one!">
        <div class="box-content" style="background-image: url('{{asset($imgBanner)}}');">
            @if ( isset($retorno->calendario[0]) )
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l12">
                      <table style="color: {{$color}};"><tr><td>
                          <div class="datas" style="border-color: {{$color}};">
                              <span>
                                  <p>{{$retorno->calendario[0]['dia']}}</p>
                                  <div class="divisao" style="background-color: {{$color}};"></div>
                                  <p>{{strtoupper($retorno->calendario[0]['mes'])}}</p>
                              </span>
                              @if( count($retorno->calendario) > 1 )
                              <span>
                                  <div class="A-topo" style="background-color: {{$color}}"></div>
                                  <div class="Div-A">{{$retorno->calendario[1]}}</div>
                                  <div class="A-button" style="background-color: {{$color}}"></div>
                              </span>
                              <span>
                                  <p>{{$retorno->calendario[2]['dia']}}</p>
                                  <div class="divisao" style="background-color: {{$color}}"></div>
                                  <p>{{strtoupper($retorno->calendario[2]['mes'])}}</p>
                              </span>
                              @endif
                          </div>
                          <div class="clearfix"></div>
                      </td></tr></table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>


<!-- ============================= Conteúdo ================================ -->
<div class="container conteudo">
    <div class="row">
        <div class="col s12 m6 l6 xl6 left">
            <p class="titulo">{{$retorno->name}}</p>
            <span class="subtitulo"> {{$retorno->sub_title}} </span>

            <div class="row valign-wrapper">
                <div class="col s12 m12 l12 xl12 valign-wrapper">
                    @foreach ($retorno->categorias as $categoria)
                    <div class="categorias">
                        <div class="box-icon-categoria">
                            <img class="icon-categoria icons-space" src="{{asset('/'. $categoria->namefilefull)}}" alt="" height="38">
                        </div>
                        <p>{{$retorno->categoria_name}}</p>
                    </div>
                    @endforeach
                </div>
            </div>


            @if ( isset($retorno->calendario[0]) )
            <div class="row">
                <div class="">
                    <div class="col s12 m12 l12 xl12 valign-wrapper">
                        <img src="{{asset('/imgs/icon-calendario.png')}}" alt="" height="38">
                        <span class="icon-text">
                            <?php
                                function nomeMes ($mes) {
                                    $mesAbreviacao = [
                                                      'JAN' => 'janeiro',
                                                      'FEV' => 'fevereiro',
                                                      'MAR' => 'março',
                                                      'ABR' => 'abril',
                                                      'MAI' => 'maio',
                                                      'JUN' => 'junho',
                                                      'JUL' => 'julho',
                                                      'AGO' => 'agosto',
                                                      'SET' => 'setembro',
                                                      'OUT' => 'outubro',
                                                      'NOV' => 'novembro',
                                                      'DEZ' => 'dezembro'
                                                     ];
                                    return $mesAbreviacao[$mes];
                                }
                            ?>
                            {{$retorno->calendario[0]['dia']}} de
                            {{nomeMes(strtoupper($retorno->calendario[0]['mes']))}} de
                            {{$retorno->calendario[0]['ano']}}
                            @if( count($retorno->calendario) > 1 )
                                {{ strtolower($retorno->calendario[1]) }}
                                {{$retorno->calendario[2]['dia']}} de
                                {{nomeMes(strtoupper($retorno->calendario[2]['mes']))}} de
                                {{$retorno->calendario[2]['ano']}}
                            @endif
                        </span>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
            @endif

            @if($retorno->texto_evento != '')
            <div class="texts">{!!$retorno->texto_evento!!}</div>
            @endif()

        </div>

        <div class="col s12 m6 l6 xl6 right">

            @if($retorno->ingressos != '')
            <img class="responsive-img binoculo" src="{{url('/imgs/Eventos/binoculo.png')}}">
               @if($retorno->servico != '')
            <div class="texts">
                <div class="titulos">SERVIÇO</div>
                {!!$retorno->servico!!}
            </div>
            @endif()

            <div class="row valign-wrapper m-t-50">
                <div class="col s12 m12 l12 xl12 valign-wrapper">
                    <img src="{{asset('/imgs/icon-$.png')}}" alt="" height="38">
                    <span class="icon-text bold"> Valores e disponibilidade são responsabilidades dos produtores </span>
                </div>
            </div>
            <div class="texts">
                {!!$retorno->ingressos!!}
            </div>
            @endif()
            @if($retorno->link_ingresso != '')
            <div class="texts">
                <div class="titulos">INGRESSOS</div>
                <p><a href="{{$retorno->link_ingresso}}" target="_blank">{{$retorno->link_ingresso}}</a></p>
            </div>
            @endif()
        </div>

        <div class="col s12 m6 l6 xl6">
            <div class="texts">
                <div class="titulos">Compartilhe</div>
            </div>

            <div class="row">
                <div class="s12 m12 l12 xl12 social">
                    <a href="{{url("/evento/{$retorno->id}/{$retorno->name}")}}" title="Facebook" class="btSocialNetwork"><i class="fontello-icon icon-facebook">&#xe80d;</i></a>
                    <a href="{{url("/evento/{$retorno->id}")}}" title="Twitter" class="btSocialNetwork"><i class="fontello-icon icon-twitter">&#xe802;</i></a>
                    <a href="whatsapp://send?text={{$retorno->name}} - {{url("/evento/{$retorno->id}")}}" title="Whatsapp"><i class="fontello-icon icon-whatsapp">&#xe803;</i></a>
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
<!-- Localização                                                             -->
<!-- ======================================================================= -->

<div class="container-fluid localizacao">
    <div class="container m-b-30">
        <ul>
            <li class="hide-on-small-only"><img class="icon-categoria" src="{{asset('/imgs/icon-localizacao.png')}}" alt="" height="38"></li>
            <li>
                <div class="tituloL1"><a href="/lugares/lugar/{{$retorno->casa_id}}">{{$retorno->casa_name}}</a></div>
                <div class="tituloL2">
                    <?php
                        $enderecoCompleto = $retorno->casa_endereco;
                        if ($retorno->casa_numero != '') {
                            $enderecoCompleto .= ', ' . $retorno->casa_numero;
                        }
                    ?>
                    {{$enderecoCompleto}}
                </div>
                @if ($retorno->casa_telefone != '' || $retorno->casa_celular)
                <div class="tituloL2">
                    <?php
                        $telefoneCompleto = $retorno->casa_telefone;
                        if ($telefoneCompleto != '') {
                            $telefoneCompleto .= ' | ';
                        }
                        $telefoneCompleto .= $retorno->casa_celular;
                    ?>
                    {{$telefoneCompleto}}
                </div>
                @endif
                <a href="/lugares/lugar/{{$retorno->casa_id}}"><input type="button" class="bt-conheca-o-lugar" value="Conheça o lugar" /></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div>
        @if($retorno->casa_localizacao != '')
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d27627.97014479008!2d-51.20568068105883!3d-30.051306290294665!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sPorto+Alegre+Ara%C3%BAjo+porto+viana!5e0!3m2!1spt-BR!2sbr!4v1518147275178" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> -->
        {!!$retorno->casa_localizacao!!}
        <!-- <iframe width="853" height="480" src="{{$retorno->casa_localizacao}}" frameborder="0" allowfullscreen></iframe> -->
        @endif()
    </div>
</div>


<!-- ======================================================================= -->
<!-- Cards                                                                   -->
<!-- ======================================================================= -->
<section id="card">
    <div class="container">
        <div class="col s12 title-sections m-b-10"><a href="/agenda">AGENDA</a></div>
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

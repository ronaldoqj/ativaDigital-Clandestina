<?php
    $colaboradores = $return['quemSomos'];
    $curadores = $return['curadores'];
?>

@extends('layouts.site')

@section('css')
    <link href="/css/pages/quem-somos.css" rel="stylesheet" />
@endsection

@section('js')
@endsection

@section('content')
<div class="clearfix"></div>
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
<div class="container-fluid topo-contato">
</div>

<div class="container">
  <div class="row">
      <div class="breadcrumbs"><a href="/">HOME</a> / QUEM SOMOS</div>
      <div class="col s12 title-sections internas"><a href="/conteudo">QUEM SOMOS</a></div>
  </div>
</div>

<!-- ============================== Textos ================================= -->
<section id="textos">
<!-- <div class="container container-img">
   <img class="responsive-img" width="100%" src="{{url('/imgs/QuemSomos/imagem-principal.jpg')}}">
</div> -->
<div class="container">
    <div class="row">
        <!-- <div class="col s12 m-t-30 m-b-30">
            <img class="responsive-img" src="{{url('/imgs/QuemSomos/logo.png')}}">
        </div> -->

        <div class="col s12 m6 l6 xl6 colunas">
            A Clandestina nasce de um sonho. Um sonho de cidade viva, vivaz, vivida. Um sonho de gente reunida, de informação ao acesso de todos, de cultura do povo na boca do povo. Temos uma vontade ambiciosa de ajudar a fortalecer a cena de Porto Alegre e enxergamos nossa iniciativa como uma das muitas engrenagens que, juntas, podem sim gerar transformação.
            <br><br>
            Nascemos Clandestina porque temos um apreço pelo mistério, pelo que está ali, meio escondido, meio desconhecido.... mas que carrega uma luz própria, o valor das coisas que não são óbvias. Clandestina porque temos muito a descobrir da nossa cidade, porque sabemos quanta vida invisível há pelas ruas, quanta beleza há nas coisas pequenas.

        </div>

        <div class="col s12 m6 l6 xl6 colunas">
            Mas afinal, o que nos leva pra rua, o que é capaz de construir diversidade ou de nos surpreender?
            Quais são os recantos dessa rua onde cada um de nós pode se encontrar, se conhecer, se fundir? E em se conhecendo ou conhecendo aquilo que era mistério, o que gera a possibilidade de compartilhar essa descoberta com outras pessoas? O que nos toca? O que nos une?
             <br><br>
            Essas são algumas das perguntas que nos movem. Por elas e por muito mais, surge a Clandestina, uma revista digital de agenda e conteúdo de cultura em Porto Alegre. Um espaço em construção, que se propõe aberto e busca a participação de quem acredita na potência da cultura como transformadora da vida cotidiana.

        </div>
    </div>
</div>
</section>

@if (count($colaboradores))
<section id="equipe">
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col s12 title-sections">EQUIPE</div>
        </div>
        <div class="row">

            @foreach($colaboradores as $item)
                <?php
                    $imgWidth = 'images/default.png';
                    $imgHeight = $imgWidth;

                    if ($item->image_width_namefilefull != '') {
                        $imgWidth = $item->image_width_namefilefull;
                    } elseif ($item->image_height_namefilefull != '') {
                        $imgWidth = $item->image_height_namefilefull;
                    }

                    if ($item->image_height_namefilefull != '') {
                        $imgHeight = $item->image_height_namefilefull;
                    } elseif ($item->image_width_namefilefull != '') {
                        $imgHeight = $item->image_width_namefilefull;
                    }
                ?>
                <div class="box-equipe">
                    <div class="imagem hide-on-med-and-down" style="background-image: url(/{{$imgHeight}})"></div>
                    <div class="imagem hide-on-large-only" style="background-image: url(/{{$imgWidth}})"></div>
                    <div class="bolhas-decorativas hide-on-med-and-down"></div>
                    <div class="background">
                        <div class="textos">
                            <div class="col s12 title-sections quem-somos"><a>{{$item->name}}</a></div>
                            <div class="clearfix"></div>
                            <p class="title">{{$item->profession}}</p>
                            <p>{!!$item->text!!}</p>
                        </div>
                    </div>
                </div>
            @endforeach

            <?php /*
            <div class="box-equipe">
                <div class="imagem hide-on-med-and-down" style="background-image: url(/imgs/QuemSomos/equipe-amanda-vertical.jpg)"></div>
                <div class="imagem hide-on-large-only" style="background-image: url(/imgs/QuemSomos/equipe-amanda.jpg)"></div>
                <div class="bolhas-decorativas hide-on-med-and-down"></div>
                <div class="background">
                    <div class="textos">
                        <div class="col s12 title-sections quem-somos"><a href="/conteudo">AMANDA UTZIG</a></div>
                        <div class="clearfix"></div>
                        <p class="title">
                            Idealizadora e editora
                        </p>
                        <p>
                            Jornalista e produtora cultural, tem especialização em Jornalismo Literário pela ABJL e Artes da Escrita pela Universidade Nova de Lisboa. Trabalhou com comunicação em escolas, editoras, revistas, secretarias de comunicação e como freelnacer em projetos culturais.
                        </p>
                    </div>
                </div>
            </div>

            <div class="box-equipe">
                <div class="imagem hide-on-med-and-down" style="background-image: url(/imgs/QuemSomos/equipe-marilia-vertical.jpg)"></div>
                <div class="imagem hide-on-large-only" style="background-image: url(/imgs/QuemSomos/equipe-marilia.jpg)"></div>
                <div class="bolhas-decorativas hide-on-med-and-down"></div>
                <div class="background">
                    <div class="textos">
                        <div class="col s12 title-sections quem-somos"><a href="/conteudo">MARÍLIA LIMA</a></div>
                        <div class="clearfix"></div>
                        <p class="title">
                            Acessora de comunicação
                        </p>
                        <p>
                            Jornalista formada pela PUCRS com experiência em comunicação digital e jornalismo cultural. Já trabalhou com curadoria musical, assessoria de imprensa, mídias digitais, fotografia e produção de conteúdo.
                        </p>
                    </div>
                </div>
            </div>

            <div class="box-equipe">
                <div class="imagem hide-on-med-and-down" style="background-image: url(/imgs/QuemSomos/equipe-rodrigo-vertical.jpg)"></div>
                <div class="imagem hide-on-large-only" style="background-image: url(/imgs/QuemSomos/equipe-rodrigo.jpg)"></div>
                <div class="bolhas-decorativas hide-on-med-and-down"></div>
                <div class="background">
                    <div class="textos">
                        <div class="col s12 title-sections quem-somos"><a href="/conteudo">RODRIGO FONTANA</a></div>
                        <div class="clearfix"></div>
                        <p class="title">
                            Idealizador e projetista
                        </p>
                        <p>
                            Geólogo, especialista em sustentabilidade pela FLACAM-Unesco e doutorando pela UFRGS na área de patrimônio geopaisagistico. Desenvolve projetos na área de cultura da Terra com ênfase em educação e gestão sustentável de projetos.
                        </p>
                    </div>
                </div>
            </div>

            <div class="box-equipe">
                <div class="imagem hide-on-med-and-down" style="background-image: url(/imgs/QuemSomos/equipe-lidia-vertical.jpg)"></div>
                <div class="imagem hide-on-large-only" style="background-image: url(/imgs/QuemSomos/equipe-lidia.jpg)"></div>
                <div class="bolhas-decorativas hide-on-med-and-down"></div>
                <div class="background">
                    <div class="textos">
                        <div class="col s12 title-sections quem-somos"><a href="/conteudo">LÍDIA BRANCHER</a></div>
                        <div class="clearfix"></div>
                        <p class="title">
                            Designer gráfica
                        </p>
                        <p>
                            Formada em Design Gráfico pela Uniritter, trabalhou em agências de propaganda, escritórios de design gráfico e web. Sempre desenhou e suas ilustrações são um diferencial dentro de sua produção gráfica. Atualmente trabalha com tecnologias educacionais no Senac, mas sua linha de produção abraça diversas atividades, como ilustrações, artes visuais, graffiti e produção cultural.
                        </p>
                    </div>
                </div>
            </div>
            */ ?>

        </div>
    </div>
</div>
</section>
@endif


@if (count($curadores))
<section id="curadores">
<div class="container">
    <div class="row">
        <div class="col s12 title-sections">CURADORES</div>

        @foreach($curadores as $item)
            <?php
                $img = 'images/default.png';

                if ($item->image_height_namefilefull != '') {
                    $img = $item->image_height_namefilefull;
                }
                if ($item->image_width_namefilefull != '') {
                    $img = $item->image_width_namefilefull;
                }

            ?>
            <div class="col s12 m6 l6 xl4">
                <div class="box-curadores">
                    <div class="img-curadores" style="background-image: url(/{{$img}})"></div>
                    <div class="box-texts-curadores">
                        <div class="title">{{$item->name}}</div>
                        <div class="sub-title">{{$item->profession}}</div>
                        <p>{!!$item->text!!}</p>
                    </div>
                </div>
            </div>
        @endforeach

        <?php /*
        <div class="col s12 m6 l6 xl3">
            <div class="box-curadores">
                <div class="img-curadores" style="background-image: url('{{asset('/imgs/QuemSomos/curador.jpg')}}')"></div>
                <div class="box-texts-curadores">
                    <div class="title">JOÃO PEDRO CÉ</div>
                    <div class="sub-title">música</div>
                    <p>
                        Integrante da banda TEM
                        e realizador do Festival Porto
                        Alegrense de música
                        instrumental
                    </p>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l6 xl3">
            <div class="box-curadores">
                <div class="img-curadores" style="background-image: url('{{asset('/imgs/QuemSomos/curador.jpg')}}')"></div>
                <div class="box-texts-curadores">
                    <div class="title">ANELISE DE CARLI</div>
                    <div class="sub-title">filosofia</div>
                    <p>
                        Professora de comunicação na UFRGS,
                        cabeça na editora Músculo e
                        organizadora da feira gráfica A6.
                    </p>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l6 xl3">
            <div class="box-curadores">
                <div class="img-curadores" style="background-image: url('{{asset('/imgs/QuemSomos/curador.jpg')}}')"></div>
                <div class="box-texts-curadores">
                    <div class="title">GABRIEL SACKS</div>
                    <div class="sub-title">cinema</div>
                    <p>
                        Músico e cineasta.
                    </p>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l6 xl3">
            <div class="box-curadores">
                <div class="img-curadores" style="background-image: url('{{asset('/imgs/QuemSomos/curador.jpg')}}')"></div>
                <div class="box-texts-curadores">
                    <div class="title">LUCAS RIBEIRO</div>
                    <div class="sub-title">artes visuais</div>
                    <p>
                        Curador e proprietário da galeria
                        Fita Tape.
                    </p>
                </div>
            </div>
        </div>
        */ ?>

    </div>
</div>
</section>
@endif

@endsection

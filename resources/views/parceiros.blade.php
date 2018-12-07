<?php
    $parceiros = $return['parceiros'];
?>
@extends('layouts.site')

@section('css')
    <link href="/css/pages/parceiros.css" rel="stylesheet" />
@endsection

@section('js')
@endsection

@section('content')
<div class="clearfix"></div>
<!-- ======================================================================= -->
<!-- Topo                                                                    -->
<!-- ======================================================================= -->
<div class="container-fluid topo-parceiros">
</div>

<!-- ============================== Textos ================================= -->
<section id="textos">
<div class="container">
  <div class="row">
      <div class="breadcrumbs"><a href="/">HOME</a> / PARCEIROS</div>
      <div class="col s12 title-sections internas"><a href="/conteudo">PARCEIROS</a></div>
  </div>
</div>

@if (count($parceiros))
<div class="container">
    <div class="row">

        @foreach($parceiros as $item)
            <?php
                $imgLogo = 'images/default.png';
                $imgBackground = $imgLogo;

                if ($item->image_logo_namefilefull != '') {
                    $imgLogo = $item->image_logo_namefilefull;
                }
                if ($item->image_background_namefilefull != '') {
                    $imgBackground = $item->image_background_namefilefull;
                }
            ?>

            <div class="box-parceiros">
                <div class="box-logo">
                    <img src="/{{$imgLogo}}" class="responsive-img" width="100%" />
                    <div class="clearfix"></div>
                </div>
                <div class="box-img">
                    <img src="/{{$imgBackground}}" class="responsive-img" width="100%" />
                </div>
                <div class="box-textos">
                    <div class="title-parceiro">{{$item->name}}</div>
                    <div class="textos-parceiros">{!!$item->text!!}</div>

                    @if ($item->site != '' || $item->facebook != '' || $item->twitter != '' || $item->instagram != '' || $item->youtube != '')
                    <div class="box-links">
                        <ul>
                            @if ($item->site != '')
                                <?php
                                    $siteOnlyName = explode("http://", $item->site);
                                    if (count($siteOnlyName) > 1) {
                                      $siteOnlyName = $siteOnlyName[1];
                                    } else {
                                      $siteOnlyName = explode("https://", $item->site);
                                      if (count($siteOnlyName) > 1) {
                                        $siteOnlyName = $siteOnlyName[1];
                                      } else {
                                        $siteOnlyName = $item->site;
                                      }
                                    }

                                ?>
                                <li class="link-site"><a href="{{$item->site}}">{{$siteOnlyName}}</a></li>
                            @endif
                            @if ($item->facebook != '')
                                <li class="link-redes_sociais"><a href="{{$item->facebook}}"><img src="/images/adm/facebook.png" class="img-fluid" alt="Facebook" /></a></li>
                            @endif
                            @if ($item->twitter != '')
                                <li class="link-redes_sociais"><a href="{{$item->twitter}}"><img src="/images/adm/twiiter.png" class="img-fluid" alt="Twitter" /></a></li>
                            @endif
                            @if ($item->instagram != '')
                                <li class="link-redes_sociais"><a href="{{$item->instagram}}"><img src="/images/adm/instagram.png" class="img-fluid" alt="Instagram" /></a></li>
                            @endif
                            @if ($item->youtube != '')
                                <li class="link-redes_sociais"><a href="{{$item->youtube}}"><img src="/images/adm/youtube.png" class="img-fluid" alt="youtube" /></a></li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
        @endforeach
        <?php /*
        <div class="box-parceiros">
            <div class="box-logo">
                <img src="/imgs/Parceiros/logo_cinematografica.png" class="responsive-img" width="100%" />
                <div class="clearfix"></div>
            </div>
            <div class="box-img">
                <img src="/imgs/Parceiros/imagem_cinematografica.jpg" class="responsive-img" width="100%" />
            </div>
            <div class="box-textos">
                <div class="title-parceiro">CINEMATOGRÁFICA SUSTENTÁVEL</div>
                <div class="textos-parceiros">
                    A Cinematográfica Sustentável é uma produtora audiovisual sediada em Porto Alegre e focada na área documental. Criada em 2013 pelo diretor e roteirista Pedro Gusmão e pela produtora e montadora Laura Gutiérrez, a Sustentável produz documentários para cinema, televisão, web, política e brand content.
                </div>
                <div class="box-links">
                    <ul>
                        <li><a href=""></a></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="box-parceiros">
            <div class="box-logo">
                <img src="/imgs/Parceiros/logo_agulha.png" class="responsive-img" width="100%" />
                <div class="clearfix"></div>
            </div>
            <div class="box-img">
                <img src="/imgs/Parceiros/imagem_agulha.jpg" class="responsive-img" width="100%" />
            </div>
            <div class="box-textos">
                <div class="title-parceiro">AGULHA</div>
                <div class="textos-parceiros">
                    Localizado no bairro São Geraldo, no quarto distrito de Porto Alegre, o Agulha tem se dedicado a oportunizar a divulgação do trabalho de artistas locais. Um espaço multidisciplinar que recebe e sedia residências artísticas, concertos ao vivo e feiras, além de oferecer um bar com cardápio autoral.
                </div>
                <div class="box-links">
                    <ul>
                        <li><a href=""></a></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="box-parceiros">
            <div class="box-logo">
                <img src="/imgs/Parceiros/logo_fil.png" class="responsive-img" width="100%" />
                <div class="clearfix"></div>
            </div>
            <div class="box-img">
                <img src="/imgs/Parceiros/imagem_fil.jpg" class="responsive-img" width="100%" />
            </div>
            <div class="box-textos">
                <div class="title-parceiro">FIL - CERVEJA ARTESANAL</div>
                <div class="textos-parceiros">
                    Não é exagero dizer que a Cervejaria Fil já nasceu enraizada a conceitos sustentáveis, sendo o mais forte deles o da autossuficiência. Localizada em uma fazenda da família na cidade de Gravataí/RS, a cervejaria se embasa na sustentabilidade de seus processos e alcança hoje um projeto limpo do início ao fim, onde a água vem de uma fonte situada dentro da fazenda, a energia é aproveitada do sol, os resíduos têm como destino horta e alimentação de animais e toda água é reutilizada. A Fil inclusive planta seus próprios lúpulos!
                </div>
                <div class="box-links">
                    <ul>
                        <li><a href=""></a></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="box-parceiros">
            <div class="box-logo">
                <img src="/imgs/Parceiros/logo_zapata.png" class="responsive-img" width="100%" />
                <div class="clearfix"></div>
            </div>
            <div class="box-img">
                <img src="/imgs/Parceiros/imagem_zapata.jpg" class="responsive-img" width="100%" />
            </div>
            <div class="box-textos">
                <div class="title-parceiro">ZAPATA - CERVEJARIA RURAL</div>
                <div class="textos-parceiros">
                    Em funcionamento desde 2015 na zona rural de Viamão/RS e construída em uma antiga casa de produção de cogumelos comestíveis, a fábrica da Zapata foi projetada a partir de um conceito inédito no Brasil, as denominadas Farmhouse Brewery. Essa linha de cervejarias busca a inspiração de suas receitas na natureza, resgatando e valorizando o terroir local, tanto no âmbito de insumos, quanto nas técnicas aplicadas durante o processo de brassagem, fermentação e maturação de cada ceva.
                </div>
                <div class="box-links">
                    <ul>
                        <li><a href=""></a></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="box-parceiros">
            <div class="box-logo">
                <img src="/imgs/Parceiros/logo_casa_agora.png" class="responsive-img" width="100%" />
                <div class="clearfix"></div>
            </div>
            <div class="box-img">
                <img src="/imgs/Parceiros/imagem_casa_agoral.jpg" class="responsive-img" width="100%" />
            </div>
            <div class="box-textos">
                <div class="title-parceiro">CASA ÁGORA</div>
                <div class="textos-parceiros">
                    Inspirada pela paixão de Hélio Luiz Marchioro,  a Casa Ágora  é  um projeto inovador e audacioso na produção e elaboração de vinhos orgânicos e biodinâmicos. Com uma área de 5Ha cultivada com vinhedos, pêssegos e frutas cítricas, e outros 5Ha de mata nativa preservada, a propriedade localizada em Pinto Bandeira/RS é exemplo de cooperativismo em microescala, envolvendo pessoas e comunidades da região.
                </div>
                <div class="box-links">
                    <ul>
                        <li><a href=""></a></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="box-parceiros">
            <div class="box-logo">
                <img src="/imgs/Parceiros/logo_marquise.png" class="responsive-img" width="100%" />
                <div class="clearfix"></div>
            </div>
            <div class="box-img">
                <img src="/imgs/Parceiros/imagem_marquise.jpg" class="responsive-img" width="100%" />
            </div>
            <div class="box-textos">
                <div class="title-parceiro">MARQUISE 51 HUB CRIATIVO</div>
                <div class="textos-parceiros">
                    A Marquise 51 é uma plataforma colaborativa que tem o propósito de fortalecer e criar soluções para o mercado cultural-musical-criativo do Sul do Brasil. Com 10 anos de experiência, é formada por produtores, empresários, artistas e realizadores, que desenvolvem projetos culturais e gerenciam e promovem artistas.
                </div>
                <div class="box-links">
                    <ul>
                        <li><a href=""></a></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="box-parceiros">
            <div class="box-logo">
                <img src="/imgs/Parceiros/logo_aldeia.png" class="responsive-img" width="100%" />
                <div class="clearfix"></div>
            </div>
            <div class="box-img">
                <img src="/imgs/Parceiros/imagem_aldeia.jpg" class="responsive-img" width="100%" />
            </div>
            <div class="box-textos">
                <div class="title-parceiro">ALDEIA</div>
                <div class="textos-parceiros">
                   A Aldeia é um espaço multicultural que acredita na cultura para além da arte, com uma organização horizontal e modo de produção colaborativo. Sob a mesma oca, convivem projetos de arte, comunicação, entretenimento e serviços, além de propostas de ocupação efêmera do espaço.
                </div>
                <div class="box-links">
                    <ul>
                        <li><a href=""></a></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="box-parceiros">
            <div class="box-logo">
                <img src="/imgs/Parceiros/logo_benedictas.png" class="responsive-img" width="100%" />
                <div class="clearfix"></div>
            </div>
            <div class="box-img">
                <img src="/imgs/Parceiros/imagem_benedictas.jpg" class="responsive-img" width="100%" />
            </div>
            <div class="box-textos">
                <div class="title-parceiro">BENEDICTAS FOTOCOLETIVO </div>
                <div class="textos-parceiros">
                   Com o nome inspirado na expoente da fotografia brasileira Nair Benedicto, o Benedictas Fotocoletivo Feminista foi criado coletivamente a fim de fortalecer a rede de mulheres na fotografia e audiovisual, espaço ainda majoritariamente masculino. O coletivo busca transmitir narrativas daquelas e daqueles que ainda são minorias nos espaços de poder.
                </div>
                <div class="box-links">
                    <ul>
                        <li><a href=""></a></li>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>
        */ ?>
    </div>
</div>
@endif

</section>

@endsection

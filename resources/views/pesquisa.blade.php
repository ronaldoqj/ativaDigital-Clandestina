@extends('layouts.site')
@section('css')
    <link href="/css/pages/home.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/pages/casas.css" rel="stylesheet" />
    <style>
        7.row-pesquisa { margin-bottom: 0; }
        #locais {
            margin: 0;
            padding: 0;
            background: transparent;
        }

        .title-sections-pesquisa {
            margin: 30px 0 0px;
        }
        #conteudo {
            margin-top: 60px;
        }
        .corrige-conteudo { margin-bottom: 50px; }
        .nenhum-resultado {
            text-align: center;
            font-size: 1.4em;
            color: #666;
            margin: 60px 0 40px;
        }
    </style>
@endsection
@section('js')
@endsection
@section('content')
<div id="pesquisa-container" class="container">
        <div class="row row-pesquisa">
          <div class="col s12 title-sections title-sections-pesquisa"><a href="/pesquisa">PESQUISA</a></div>
        </div>
        <div class="row">
              <div class="pesquisa-campos">
                  <form action="" method="post">
                      {{ csrf_field() }}
                      <div class="col s12">
                          <input type="text" class="browser-default input-pesquisa" id="pesquisa" placeholder="Digite sua pesquisa" name="pesquisa" value="{{$return['pesquisa']}}" maxlength="240" />
                      </div>
                      <div class="col s12">
                          <input type="submit" class="browser-default buscar-modal bt-pesquisa" value="BUSCAR" />
                      </div>
                  </form>
              </div>
        </div>

        @if ( !count($return['eventos']) && !count($return['conteudos']) && !count($return['lugares']) )
            <div class="row">
                <div class="col s12 nenhum-resultado">Não foram encontrados registros para a pesquisa realizada.</div>
            </div>
        @endif
            <!-- <div class="result">Nenhum resultado encontrado.</div> -->
          @if ( count($return['eventos']) )
              <div class="row">
                  <section id="card">
                      <div class="row">
                          <div class="col s12 title-sections title-sections-pesquisa"><a href="/agenda">AGENDA</a></div>
                      </div>

                      <div class="row">
                          @foreach($return['eventos'] as $evento)
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
                                          @if ($evento->calendario != '')
                                              <div class="card-calendario">
                                                  <ul>
                                                      <li>{{$evento->calendario[0]['nomeDia']}}</li>
                                                      <li>{{$evento->calendario[0]['numeroDia']}}</li>
                                                      <li>{{$evento->calendario[0]['nomeMes']}}</li>
                                                  </ul>
                                                  @if ( count($evento->calendario) > 2 )
                                                  <ul>
                                                    <li><div class="divisao"></div></li>
                                                    <li class="divisorLi">{{$evento->calendario[1]}}</li>
                                                    <li><div class="divisao"></div></li>
                                                  </uL>
                                                  <ul>
                                                      <li>{{$evento->calendario[2]['nomeDia']}}</li>
                                                      <li>{{$evento->calendario[2]['numeroDia']}}</li>
                                                      <li>{{$evento->calendario[2]['nomeMes']}}</li>
                                                  </ul>
                                                  @endif
                                              </div>
                                          @endif
                                          <div class="card-texto valign-wrapper" style="background-color: {{$cor}}50;">
                                              @if ( isset($evento->categorias->toArray()[0]->namefilefull) )
                                              <div style="background-image: url('{{asset('/'.$evento->categorias->toArray()[0]->namefilefull)}}')"></div>
                                              @endif
                                              <ul>
                                                <li>{{str_limit($evento->name, 35, '...')}}</li>
                                              </ul>
                                          </div>
                                      </div>
                                  </div>
                                  </a>
                              </div>
                          @endforeach()
                      </div>

                  </section>
              </div>
          @endif

          @if ( count($return['conteudos']) )
             <div class="row">
                 <div class="col s12 title-sections title-sections-pesquisa conteudo-home"><a href="/conteudo">CONTEÚDO</a></div>
             </div>
             <div class="row">
                 <section id="conteudo">
                       <div class="row">
                           @foreach($return['conteudos'] as $noticia)
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
                               <div class="col s12 m6 xl4 corrige-conteudo">
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
                       </div>
                 </section>
             </div>
          @endif

          @if ( count($return['lugares']) )
              <div class="row">
                  <div class="col s12 title-sections title-sections-pesquisa"><a href="/lugares">LUGARES</a></div>
              </div>

              <div class="row">
                  <section id="locais">
                        <div class="row">
                        @foreach($return['lugares'] as $casa)
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
                  </section>
              </div>
          @endif
</div>
@endsection

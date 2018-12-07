<?php
    $categorias = $return['categorias'];
?>

@extends('layouts.site')

@section('css')
    <link href="/css/pages/contato.css" rel="stylesheet" />
@endsection

@section('js')
<script src="/js/pages/modal-news-letter.js"></script>
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
<div class="container-fluid topo-contato">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="texto-topo">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================= Conteúdo ================================ -->


<div class="container">
  <div class="row">
      <div class="breadcrumbs"><a href="/">HOME</a> / CONTATO</div>
      <div class="col s12 title-sections internas"><a href="/conteudo">CONTATO</a></div>
  </div>
</div>


<div class="container conteudo">
    <div class="row">
        <div class="col s12 m6 l6 xl6">
          <img class="responsive-img" src="{{url('/imgs/Contato/pena.png')}}">
        </div>

        <div class="col s12 m6 l6 xl6 colum-right">
            <div class="title-contato">
               
            </div>
            
            
             <div class="outras-formas-contato">
                <div class="title">VAMOS CONVERSAR? </div>
               
                </div>
                
                
            <div class="box-contato">
                
               
            
                
                <p><a href="mailto:oi@clandestina.com.br" target="_blank">oi@clandestina.com.br</a></p>
                <div class="row">
                    <div class="s12 m12 l12 xl12 social">
                        <a href="http://www.facebook.com/revistaclandestina" title="Facebook"><i class="fontello-icon icon-facebook">&#xe80d;</i></a>
                        <a href="http://www.instagram.com/revistaclandestina" title="Instagram"><i class="fontello-icon icon-instagram">&#xe80e;</i></a>
                    </div>
                </div>

                <p class="p-dados-contato">Porto Alegre - RS - Brasil</p>
            </div>
            <div class="outras-formas-contato">
                <div class="title">QUER ENVIAR SUGESTÕES DE PAUTA? </div>
                <a href="mailto:pauta@clandestina.com.br?Subject=Sugestões%20de%20pauta" target="_blank">pauta@clandestina.com.br</a>
            </div>
            <div class="outras-formas-contato">
                <div class="title">QUER FAZER PARTE DA CLANDESTINA? </div>
                <a href="mailto:rede@clandestina.com.br?Subject=Anúncio" target="_blank">rede@clandestina.com.br</a>
            </div>
        </div>

    </div>

</div>

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

@endsection

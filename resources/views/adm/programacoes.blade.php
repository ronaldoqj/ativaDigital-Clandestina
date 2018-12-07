<?php
    $programacoes = $return['programacoes'];
    $categorias = $return['categorias'];
    $casas = $return['casas'];
?>
@extends('layouts.adm')
@section('css')
    {{-- PickMeUp --}}
    <link rel="stylesheet" href="/plugins-frameworks/PickMeUp/css/pickmeup.css" type="text/css" />

    <link rel="stylesheet" href="/plugins-frameworks/bootstrap-select-1.13.0/dist/css/bootstrap-select.css">
    <style>
        label { margin-bottom: 0rem; }
        .card-header { cursor: pointer; }
        .card .border-secondary { margin: 5px 0; }
        .text-secondary { padding: 8px; }
        .btns-listagem { padding-top: 3px; height: 40px; }
        .btns-listagem .btn { padding: 3px 8px 0px; }
        .col-form-label { word-wrap:normal; }
        .imagesList:hover {
            box-shadow: inset 0px 0px 0px 4px #999;
            opacity: 0.8;
            transition: 0.3s ease-out;
            cursor: pointer;
        }
        .imagesList {
            width: 80px;
            height: 40px;
            float: left;
            margin-right: 8px;
            background-position: center !important;
            -webkit-background-size: cover !important;
            -moz-background-size: cover !important;
            -o-background-size: cover !important;
            background-size: cover !important;
            cursor: pointer;

            opacity: 1;
            box-shadow: inset 0px 0px 1px 1px #999;
            transition: 0.3s;
        }
        .explicacao {
            font-size: 0.8em;
            line-height: 1.1em;
            color: #888;
            margin-top: 3px;
        }
        .italico { font-style: italic; text-decoration: underline; }
        .idNegrito { color: black; font-weight: bold; font-style: normal; text-decoration: underline; }
        .multiple-dates { margin-top: 10px; text-align: center; }
    </style>
@endsection
@section('jsHead')
    <script type="text/javascript" src="/plugins-frameworks/ckeditor/ckeditor.js"></script>
@endsection
@section('js')
    {{-- PickMeUp --}}
    <script type="text/javascript" src="/plugins-frameworks/PickMeUp/js/jquery.pickmeup.twitter-bootstrap.js"></script>
    <script type="text/javascript" src="/plugins-frameworks/PickMeUp/js/pickmeup.js"></script>

    <script src="/js/pages/adm/programacoes.js"></script>
    <script src="/js/pages/adm/ajaxBannersTop.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
    <!-- <script type="text/javascript" src="/plugins-frameworks/jquery.mask/v1.14.15/jquery.mask.min.js"></script> -->
    <script>
      $(document).ready(function()
      {
          var datas = [];
          pickmeup('.multiple-dates', {
        		flat : true,
            default_date: false,
            date: datas,
            format: 'd/m/Y',
            default_date:false,
        		mode : 'multiple'
        	});

          var el = document.getElementById('multiple-dates');
          el.addEventListener('pickmeup-change', function (e) {
              $('#inputData').val(e.detail.formatted_date);
              // console.log(e.detail.formatted_date); // New date according to current format
              // console.log(e.detail.date);           // New date as Date object
          })
      });
    </script>
@stop
@section('content')

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <h5 class="text-center m-b-20"><strong>Erro ao concluir a requisição!</strong></h5>

  <ul>
      @foreach ($errors->all() as $error)
          <li>{!! $error !!}</li>
      @endforeach
  </ul>

  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 m-b-20">
            <p>
                <button class="btn btn-outline-warning btn-block" type="button" data-toggle="collapse" data-target="#register" aria-expanded="false" aria-controls="register">
                    Cadastrar Nova Programacao
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card border-warning">

                          <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                              {{ csrf_field() }}
                              <input type="hidden" name="action" value="register">
                              <input type="hidden" name="categorias" value="">
                              <input type="hidden" name="locais" value="">
                              <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-5">

                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputTelefone">Evento:*</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputNome" maxlength="240" placeholder="Nome" name="name" required>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputSub_title">Sub-titulo:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputSub_title" maxlength="240" placeholder="Sub-titulo" name="sub_title">
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputTelefone">Categoria:</label>
                                                      <select id="selectCategoria" class="selectpicker is-valid" data-actions-box="true" data-width="100%" multiple title="Selecione as Categorias">
                                                          @foreach( $categorias as $categoria )
                                                          <option value="{{$categoria->id}}" data-content="<img src='/{{$categoria->namefilefull}}' height='25' alt='{{$categoria->name}}'> {{str_limit($categoria->name, 30, '...')}}">{{str_limit($categoria->name, 30, '...')}}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>


                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputData">Data:</label>

                                                      <div class="card border-secondary">
                                                              <div class="card-body">
                                                                  <input type="text" class="form-control form-control-sm" id="inputData" placeholder="Data" name="data" readonly>
                                                                  <div id="multiple-dates" class="multiple-dates">
                                                              </div>
                                                          </div>
                                                      </div>

                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputHorario">Horário:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputHorario" placeholder="Horário. EX: 23:59:59" name="horario">
                                                  </div>
                                              </div>

                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputTelefone">Local:</label>
                                                      <select id="selectLocal" class="selectpicker is-valid" data-actions-box="true" data-width="100%" multiple title="Selecione o Local">
                                                          @foreach( $casas as $casa )
                                                          <?php
                                                              $img = 'images/default.png';
                                                              $img = $casa->imagem_principal_namefilefullthumb ? $casa->imagem_principal_namefilefullthumb : $img;
                                                              $img = $casa->banner_principal_namefilefullthumb ? $casa->banner_principal_namefilefullthumb : $img;
                                                              $imgGrande = $img;
                                                              $imgGrande = $casa->imagem_principal_namefilefull ? $casa->imagem_principal_namefilefull : $img;
                                                              $imgGrande = $casa->banner_principal_namefilefull ? $casa->banner_principal_namefilefull : $img;
                                                          ?>
                                                          <option value="{{$casa->id}}" data-content="<img src='/{{$img}}' height='25' alt='{{$casa->name}}'> {{str_limit($casa->name, 30, '...')}}">{{str_limit($casa->name, 30, '...')}}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>

                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputTextoEvento">Texto do Evento:</label>
                                                      <textarea id="textoEvento" name="textoEvento"></textarea>
                                                      <script type="text/javascript">
                                                          CKEDITOR.replace( 'textoEvento' );
                                                      </script>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputServico">Serviço:</label>
                                                      <textarea id="servico" name="servico"></textarea>
                                                      <script type="text/javascript">
                                                          CKEDITOR.replace( 'servico' );
                                                      </script>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="ingressos">Ingressos:</label>
                                                      <textarea id="ingressos" name="ingressos"></textarea>
                                                      <script type="text/javascript">
                                                          CKEDITOR.replace( 'ingressos' );
                                                      </script>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="linkIngressos">Link Ingressos:</label>
                                                      <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Link Ingressos" name="linkIngressos">
                                                  </div>
                                              </div>
                                        </div>
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-6">
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputBannerPrincipal">Banner Principal:</label>

                                                      <div class="card border-secondary">
                                                          <div class="card-body">
                                                            <label for="inputTitleBanner">Título:</label>
                                                            <input type="text" class="form-control form-control-sm mb-3" id="inputTitleBanner" maxlength="240" placeholder="Título do banner" name="title_banner" />

                                                            <label for="inputBannerPrincipal">Selecione uma Imagem:</label>
                                                            <div class="custom-file mb-3">
                                                                <input type="file" id="inputBannerPrincipal" class="custom-file-input" name="fileBannerPrincipal[]">
                                                                <label class="custom-file-label" for="customFile">Banner Principal</label>
                                                            </div>
                                                            <label for="inputLegendaBannerPrincipal">Legenda:</label>
                                                            <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Legenda da banner principal" name="legendaBanner">
                                                          </div>
                                                      </div>

                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputImagemPrincipal">Imagem Principal:</label>

                                                      <div class="card border-secondary">
                                                          <div class="card-body">
                                                            <div class="custom-file mb-3">
                                                                <input type="file" id="inputImagemPrincipal" class="custom-file-input" name="fileImagemPrincipal[]">
                                                                <label class="custom-file-label" for="customFile">Imagem Principal</label>
                                                            </div>
                                                            <label for="inputLegendaImagemPrincipal">Legenda:</label>
                                                            <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Legenda da imagem principal" name="legendaImagem">
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                    <label for="inputGaleria">Galeria de Fotos:</label>

                                                    <div class="card border-secondary">
                                                        <div class="card-body">
                                                            <label for="inputGaleria">Nome Padrão:</label>
                                                            <input type="text" class="form-control form-control-sm mb-3" maxlength="140" placeholder="Nome padrão para todas imagens" name="namedefault">
                                                            <label for="inputGaleria">Selecione as Imagens:</label>
                                                            <div class="custom-file">
                                                                <input type="file" id="inputGaleria" class="custom-file-input" multiple name="filesGaleria[]">
                                                                <label class="custom-file-label" for="customFile">Imagens Para a Galeria</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                              </div>

                                        </div>
                                    </div>

                              </div>

                              <div class="card-footer text-muted">
                                    <button type="submit" id="bt-cadastrar-editar" class="btn btn-outline-success btn-block">Cadastrar Programacao</button>
                              </div>
                          </form>

                    </div>
            </div>
        </div>
    </div>

    <div></div>

    <div class="row">
        <div class="col-md-12">

              <!-- Conteiner da listagem -->
              <div class="card bg-light">
                <div class="card-header">Listagem das matérias</div>
                <div class="card-body">
                      <!-- ==================================================================  -->
                      <!-- ======================== Itens listados =========================== -->
                      <!-- ==================================================================  -->

                      @forelse ($programacoes as $register)
                          <?php
                              $img = 'images/default.png';
                              $img = $register->imagem_principal_namefilefullthumb ? $register->imagem_principal_namefilefullthumb : $img;
                              $img = $register->banner_principal_namefilefullthumb ? $register->banner_principal_namefilefullthumb : $img;
                              $imgGrande = $img;
                              $imgGrande = $register->imagem_principal_namefilefull ? $register->imagem_principal_namefilefull : $img;
                              $imgGrande = $register->banner_principal_namefilefull ? $register->banner_principal_namefilefull : $img;

                              $checkBoxActive = '';
                              $checkBoxCheck = '';
                              if ($register->banner == 'S') {
                                  $checkBoxActive = 'active';
                                  $checkBoxCheck = 'checked';
                              }
                              $checkBoxHomeActive = '';
                              $checkBoxHomeCheck = '';
                              if ($register->home == 'S') {
                                  $checkBoxHomeActive = 'active';
                                  $checkBoxHomeCheck = 'checked';
                              }
                          ?>
                          <form action="{{url("/adm/programacoes-edit/{$register->id}")}}" method="get">
                              <div class="card border-secondary">
                                <div class="card-body text-secondary">


                                      <div class="row">
                                          <div class="col col-12 col-sm-6">

                                              <div class="input-group input-group-sm mb-1">
                                                  <div class="input-group-prepend">
                                                      <div class="input-group-text">
                                                        <input type="checkbox" class="checkbox-register-home" rel-id="{{$register->id}}" rel-table="programacoes" rel-Column="home" aria-label="Checkbox for following text input" {{$checkBoxHomeCheck}} /><span id="span-register-home_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxHomeActive}}">Home</span>
                                                      </div>
                                                  </div>
                                                  <input type="number" id="order_home-{{$register->id}}" class="form-control size-font order-banners" rel-id="{{$register->id}}" rel-table="programacoes" rel-Column="order_home" aria-label="Text input with checkbox" placeholder="Ordem na home" value="{{$register->order_home}}" />
                                              </div>

                                          </div>
                                          <div class="col col-12 col-sm-6">

                                            <div class="input-group input-group-sm mb-1">
                                              <input type="number" id="order-{{$register->id}}" class="form-control text-right size-font order-banners" rel-id="{{$register->id}}" rel-table="programacoes" rel-Column="order" aria-label="Text input with checkbox" placeholder="Ordem do banner" value="{{$register->order}}" />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                      <input type="checkbox" class="checkbox-register" rel-id="{{$register->id}}" rel-table="programacoes" rel-Column="banner" aria-label="Checkbox for following text input" {{$checkBoxCheck}} /><span id="span-register_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxActive}}">Banner</span>
                                                    </div>
                                                </div>

                                            </div>

                                          </div>
                                      </div>


                                      <div class="imagesList" rel="/{{$imgGrande}}" style="background-image: url(/{{$img}});"></div>
                                      <div style="float:right;" class="btns-listagem">
                                          <div class="input-group-append">
                                            <!-- <div class="input-group-text">
                                                <input type="checkbox" class="checkbox-register-home" rel-id="{{$register->id}}" rel-table="programacoes" rel-Column="home" aria-label="Checkbox for following text input" {{$checkBoxHomeCheck}} /><span id="span-register-home_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxHomeActive}}">Home</span>
                                            </div>
                                            <div class="input-group-text">
                                                <input type="checkbox" class="checkbox-register" rel-id="{{$register->id}}" rel-table="programacoes" rel-Column="banner" aria-label="Checkbox for following text input" {{$checkBoxCheck}} /><span id="span-register_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxActive}}">Banner</span>
                                            </div> -->
                                            <button class="btn btn-outline-secondary edit" type="submit" title="Edita"><i class="material-icons i-corrige">mode_edit</i></button>
                                            <button class="btn btn-outline-secondary delete" type="button" rel="{{$register->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                          </div>
                                      </div>
                                      <div style="float:left; margin-right:8px; padding-top:10px;">{{$register->name}}</div>




                                </div>
                              </div>
                          </form>
                      @empty
                          <p>Nenhuma programação cadastrada no momento.</p>
                      @endforelse
                      <!-- ==================================================================  -->
                      <!-- ======================== Itens listados =========================== -->
                      <!-- ==================================================================  -->
                </div><!-- Fim card-body -->
              </div><!-- Fim card bg-light -->

        </div> <!-- Fim m12 -->
    </div> <!-- Fim row -->


</div>


<!-- =====================================================================================================================================  -->
<!-- Modal Imagem                                                                                                                           -->
<!-- =====================================================================================================================================  -->
<div id="modalImage" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="edit" class="modal-dialog modal-lg">
    <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Imagem da Programação</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
              <div style="margin-bottom: 10px;">
                <img src="" alt="" id="imageThumb" class="img-fluid img-thumbnail img-modal mx-auto d-block">
              </div>
              <div style="clear:both;"></div>
          </div>
      </div>
  </div>
</div>


<!-- Form Delete -->
<form id="form-delete" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="idProgramacao" value="">
</form>
@endsection

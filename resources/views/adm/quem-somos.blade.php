<?php
    $quemSomos = $return['quemSomos'];
?>
@extends('layouts.adm')
@section('css')
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
    </style>
@endsection
@section('jsHead')
    <script type="text/javascript" src="/plugins-frameworks/ckeditor/ckeditor.js"></script>
@endsection
@section('js')
    <script src="/js/pages/adm/quem-somos.js"></script>
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
                    Cadastrar Novo Colaborador
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card border-warning">

                          <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                              {{ csrf_field() }}
                              <input type="hidden" name="action" value="register" />
                              <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <div class="custom-control custom-checkbox float-right">
                                              <input type="checkbox" class="custom-control-input" id="CheckCurador" name="curador" {{--checked--}} />
                                              <label class="custom-control-label" for="CheckCurador">Colaborador Curador</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputNome">Nome:*</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputNome" maxlength="240" placeholder="Nome" name="name" required />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputProfession">Profissão:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputProfession" maxlength="240" placeholder="Profissão" name="profession" required />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="text">Texto</label>
                                                      <textarea id="text" name="text"></textarea>
                                                      <script type="text/javascript">
                                                          CKEDITOR.replace( 'text' );
                                                      </script>
                                                  </div>
                                              </div>
                                        </div>
                                        <!-- <div class="col-lg-1"></div> -->
                                        <div class="col-lg-6">
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputImageWidth">Imagem Horizontal (Mobile):</label>
                                                      <div class="custom-file">
                                                          <input type="file" id="inputImageWidth" class="custom-file-input" name="fileImageWidth[]" />
                                                          <label class="custom-file-label" for="customFile">Imagem Horizontal</label>
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputImageHeight">Imagem Vertical (PCs e telas grandes):</label>
                                                      <div class="custom-file">
                                                          <input type="file" id="inputImageHeight" class="custom-file-input" name="fileImageHeight[]" />
                                                          <label class="custom-file-label" for="customFile">Imagem Vertical</label>
                                                      </div>
                                                  </div>
                                              </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-muted">
                                          <button type="submit" id="bt-cadastrar-editar" class="btn btn-outline-success btn-block">Cadastrar Colaborador</button>
                                    </div>
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
                <div class="card-header">Listagem das Colaboradores</div>
                <div class="card-body">
                      <!-- ==================================================================  -->
                      <!-- ======================== Itens listados =========================== -->
                      <!-- ==================================================================  -->

                      @forelse ($quemSomos as $register)
                          <?php
                              $img = 'images/default.png';
                              $img = $register->image_width_namefilefullthumb ? $register->image_width_namefilefullthumb : $img;
                              $img = $register->image_height_namefilefullthumb ? $register->image_height_namefilefullthumb : $img;
                              $imgGrande = $img;
                              $imgGrande = $register->image_width_namefilefull ? $register->image_width_namefilefull : $img;
                              $imgGrande = $register->image_height_namefilefull ? $register->image_height_namefilefull : $img;

                              $checkBoxActive = '';
                              $checkBoxCheck = '';
                              if ($register->ativo == 'S') {
                                  $checkBoxActive = 'active';
                                  $checkBoxCheck = 'checked';
                              }

                              if ($loop->first) {
                                  $ativo = 'disabled';
                              } else {
                                  $ativo = '';
                              }
                          ?>
                          <form action="{{url("/adm/quem-somos-edit/{$register->id}")}}" method="get">
                              <div class="card border-secondary">
                                <div class="card-body text-secondary">
                                  <div class="imagesList" rel="/{{$imgGrande}}" style="background-image: url(/{{$img}});"></div>
                                      <div style="float:right;" class="btns-listagem">
                                          <div class="input-group-append">
                                            <!-- <div class="input-group-text">
                                                <input type="checkbox" class="checkbox-register" rel-id="{{$register->id}}" rel-table="quem_somos" aria-label="Checkbox for following text input" {{$checkBoxCheck}} /><span id="span-register_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxActive}}">Ativo</span>
                                            </div> -->
                                            @if ($register->curador == 'S')
                                            <div class="input-group-text">
                                                <span id="span-register_{{$register->id}}" class="check-register checkBoxSN active">Curador</span>
                                            </div>
                                            @endif
                                            <button class="btn btn-outline-secondary order" type="button" title="Edita" rel="{{$register->id}}" {{$ativo}}><i class="material-icons">vertical_align_top</i></button>
                                            <button class="btn btn-outline-secondary edit" type="submit" title="Edita"><i class="material-icons i-corrige">mode_edit</i></button>
                                            <button class="btn btn-outline-secondary delete" type="button" rel="{{$register->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                          </div>
                                      </div>
                                      <div style="float:left; margin-right:8px; padding-top:10px;">{{$register->name}}</div>
                                </div>
                              </div>
                          </form>
                      @empty
                          <p>Nenhuma colaborador cadastrado no momento.</p>
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
            <h5 class="modal-title" id="exampleModalLabel">Imagem do Colaborador</h5>
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
      <input type="hidden" name="idQuemSomos" value="">
</form>

<form id="form-order" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="">
    <input type="hidden" name="action" value="order">
</form>
@endsection

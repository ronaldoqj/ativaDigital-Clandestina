<?php
    $quemSomos = $return['quemSomos'];
    $imageWidth = count($return['imageWidth']) ? $return['imageWidth'][0] : [];
    $imageHeight = count($return['imageHeight']) ? $return['imageHeight'][0] : [];
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
            border: solid 3px #999;
            opacity: 0.8;
            transition: 0.2s ease-out;
            cursor: pointer;
        }
        .imagesList {
            /* width: 80px;
            height: 40px;
            float: left;
            margin-right: 8px;
            background-position: center !important;
            -webkit-background-size: cover !important;
            -moz-background-size: cover !important;
            -o-background-size: cover !important;
            background-size: cover !important; */
            cursor: pointer;

            opacity: 1;
            border: solid 0px #999;
            transition: 0.2s;
        }
        .explicacao {
            font-size: 0.8em;
            line-height: 1.1em;
            color: #888;
            margin-top: 3px;
        }
        .italico { font-style: italic; text-decoration: underline; }
        .idNegrito { color: black; font-weight: bold; font-style: normal; text-decoration: underline; }
        .card .card-body .card-body { padding: 0.65rem; }

        /* Galeria */
        .thumbs {
            width: 102px;
            /* border: solid 1px #999; */
            /* border-radius: 3px; */
            float: left;
            margin: 8px;
            /* padding: 3px; */

        }
        .btnThumbs {
          font-size: 0px;
          padding: 3px 13px 6px;
        }
        .btnThumbsImages {
          font-size: 0px;
          padding: 0px 4px 5px;
        }
        .inputThumb {
            width: 250px;
        }
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
            <a class="btn btn-outline-dark btn-sm" href="/adm/quem-somos" role="button">Voltar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 m-b-20">
                <div class="card border-warning">

                      <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                          {{ csrf_field() }}
                          <input type="hidden" name="action" value="edit" />
                          <input type="hidden" name="id" value="{{$quemSomos->id}}" />
                          <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="custom-control custom-checkbox float-right">
                                          <input type="checkbox" class="custom-control-input" id="CheckCurador" name="curador" {{ $quemSomos->curador == 'S' ? 'checked' : '' }} />
                                          <label class="custom-control-label" for="CheckCurador">Colaborador Curador</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">

                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputNome">Nome:*</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputNome" maxlength="240" placeholder="Nome" name="name" value="{{$quemSomos->name}}" required />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputProfession">Profissão:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputProfession" maxlength="240" placeholder="Profissão" name="profession" value="{{$quemSomos->profession}}" required />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="text">Texto</label>
                                                  <textarea id="text" name="text">{!!$quemSomos->text!!}</textarea>
                                                  <script type="text/javascript">
                                                      CKEDITOR.replace( 'text' );
                                                  </script>
                                              </div>
                                          </div>
                                    </div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-6">
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputBannerPrincipal">Imagem Horizontal (Mobile):</label>

                                                  <div class="card border-secondary">
                                                      <div class="card-body">
                                                          <?php
                                                              $imageWidthId = '';
                                                              $img = 'images/default.png';
                                                              $imgGrande = $img;
                                                              $mostraBtExcluir = false;
                                                              if($imageWidth)
                                                              {
                                                                  $mostraBtExcluir = true;
                                                                  $imageWidthId = $imageWidth->id;
                                                                  $img = $imageWidth->image_width_namefilefullthumb ? $imageWidth->image_width_namefilefullthumb : $img;
                                                                  $imgGrande = $img;
                                                                  $imgGrande = $imageWidth->image_width_namefilefull ? $imageWidth->image_width_namefilefull : $img;
                                                              }
                                                          ?>
                                                          <img src="/{{$img}}" rel="/{{$imgGrande}}" class="rounded mx-auto d-block imagesList" height="80" alt="" />
                                                          <div class="col-md-12 text-center mb-3">
                                                              @if($mostraBtExcluir)
                                                                  <button type="button" id="bt-excluir-banner-principal" relId="{{$imageWidthId}}" relCampo="ImagemWidth" relAcao="delete-image" class="btn btn-outline-danger btn-sm btns-delete-imgs-principais">Excluir Imagem</button>
                                                              @endif
                                                          </div>

                                                          <label for="inputBannerPrincipal">Selecione uma Imagem:</label>
                                                          <div class="custom-file {{--mb-2--}}">
                                                              <input type="file" id="inputBannerPrincipal" class="custom-file-input" name="fileImageWidth[]" />
                                                              <label class="custom-file-label" for="customFile">Imagem Horizontal</label>
                                                          </div>
                                                          <!-- <label for="inputLegendaBannerPrincipal">Legenda:</label>
                                                          <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Legenda da banner principal" name="legendaBanner" value="{{$quemSomos->legenda_banner}}"> -->
                                                      </div>
                                                  </div>

                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputImagemPrincipal">Imagem Vertical (PCs e telas grandes):</label>

                                                  <div class="card border-secondary">
                                                      <div class="card-body">
                                                        <?php
                                                            $imageHeightId = '';
                                                            $img = 'images/default.png';
                                                            $imgGrande = $img;
                                                            $mostraBtExcluir = false;
                                                            if($imageHeight)
                                                            {
                                                                $mostraBtExcluir = true;
                                                                $imageHeightId = $imageHeight->id;
                                                                $img = $imageHeight->image_height_namefilefullthumb ? $imageHeight->image_height_namefilefullthumb : $img;
                                                                $imgGrande = $img;
                                                                $imgGrande = $imageHeight->image_height_namefilefull ? $imageHeight->image_height_namefilefull : $img;
                                                            }
                                                        ?>
                                                          <img src="/{{$img}}" rel="/{{$imgGrande}}" class="rounded mx-auto d-block imagesList" height="80" alt="" />
                                                          <div class="col-md-12 text-center mb-3">
                                                              @if($mostraBtExcluir)
                                                                  <button type="button" relId="{{$imageHeightId}}" relCampo="ImagemHeight" relAcao="delete-image" class="btn btn-outline-danger btn-sm btns-delete-imgs-principais">Excluir Imagem</button>
                                                              @endif
                                                          </div>
                                                          <div class="custom-file {{--mb-2--}}">
                                                              <input type="file" id="inputImagemPrincipal" class="custom-file-input" name="fileImageHeight[]" />
                                                              <label class="custom-file-label" for="customFile">Imagem Vertical</label>
                                                          </div>
                                                          <!-- <label for="inputLegendaImagemPrincipal">Legenda:</label>
                                                          <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Legenda da imagem principal" name="legendaImagem" value="{{$quemSomos->legenda_imagem}}"> -->
                                                      </div>
                                                  </div>

                                              </div>
                                          </div>

                                    </div>
                                </div>

                          </div>

                          <div class="card-footer text-muted">
                                <button type="submit" id="bt-cadastrar-editar" class="btn btn-outline-success btn-block">Atualizar Colaborador</button>
                          </div>
                      </form>

                </div>
        </div>
    </div>


</div>


<!-- =====================================================================================================================================  -->
<!-- Modal Imagem                                                                                                                           -->
<!-- =====================================================================================================================================  -->
<div id="modalImage" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="edit" class="modal-dialog modal-lg">
    <div class="modal-content">

          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Imagem da Casa</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <div class="modal-body">
              <div style="margin-bottom: 10px;">
                  <img src="" alt="" id="imageThumb" class="img-fluid img-thumbnail img-modal mx-auto d-block" />
              </div>
              <div style="clear:both;"></div>
          </div>
      </div>
  </div>
</div>

<!-- Form Delete -->
<form id="form-delete" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="" />
      <input type="hidden" name="id" value="" />
      <input type="hidden" name="campo" value="" />
</form>

<form id="form-images" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="order">
      <input type="hidden" name="id" value="" />
      <input type="hidden" name="idCasa" value="" />
      <input type="hidden" name="name" value="" />
</form>
@endsection

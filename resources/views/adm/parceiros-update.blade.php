<?php
    $parceiros = $return['parceiros'];
    $image_logo = count($return['image_logo']) ? $return['image_logo'][0] : [];
    $image_background = count($return['image_background']) ? $return['image_background'][0] : [];
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
    <script src="/js/pages/adm/parceiros.js"></script>
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
            <a class="btn btn-outline-dark btn-sm" href="/adm/parceiros" role="button">Voltar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 m-b-20">
                <div class="card border-warning">

                      <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                          {{ csrf_field() }}
                          <input type="hidden" name="action" value="edit" />
                          <input type="hidden" name="id" value="{{$parceiros->id}}" />
                          <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-5">

                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputNome">Nome:*</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputNome" maxlength="240" placeholder="Nome" name="name" value="{{$parceiros->name}}" required />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="text">Texto</label>
                                                  <textarea id="text" name="text">{!!$parceiros->text!!}</textarea>
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
                                                  <label for="inputImageLogo">Imagem Logo:</label>

                                                  <div class="card border-secondary">
                                                      <div class="card-body">
                                                          <?php
                                                              $image_logoId = '';
                                                              $img = 'images/default.png';
                                                              $imgGrande = $img;
                                                              $mostraBtExcluir = false;
                                                              if($image_logo)
                                                              {
                                                                  $mostraBtExcluir = true;
                                                                  $image_logoId = $image_logo->id;
                                                                  $img = $image_logo->image_logo_namefilefullthumb ? $image_logo->image_logo_namefilefullthumb : $img;
                                                                  $imgGrande = $img;
                                                                  $imgGrande = $image_logo->image_logo_namefilefull ? $image_logo->image_logo_namefilefull : $img;
                                                              }
                                                          ?>
                                                          <img src="/{{$img}}" rel="/{{$imgGrande}}" class="rounded mx-auto d-block imagesList" height="80" alt="" />
                                                          <div class="col-md-12 text-center mb-3">
                                                              @if($mostraBtExcluir)
                                                                  <button type="button" id="bt-excluir-banner-principal" relId="{{$image_logoId}}" relCampo="ImagemLogo" relAcao="delete-image" class="btn btn-outline-danger btn-sm btns-delete-imgs-principais">Excluir Imagem</button>
                                                              @endif
                                                          </div>

                                                          <label for="inputImageLogo">Selecione uma Imagem:</label>
                                                          <div class="custom-file {{--mb-2--}}">
                                                              <input type="file" id="inputImageLogo" class="custom-file-input" name="fileLogo[]" />
                                                              <label class="custom-file-label" for="customFile">Imagem Logo</label>
                                                          </div>
                                                          <!-- <label for="inputLegendaBannerPrincipal">Legenda:</label>
                                                          <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Legenda da banner principal" name="legendaBanner" value="{{$parceiros->legenda_banner}}"> -->
                                                      </div>
                                                  </div>

                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputImageBackground">Imagem Background:</label>

                                                  <div class="card border-secondary">
                                                      <div class="card-body">
                                                        <?php
                                                            $image_backgroundId = '';
                                                            $img = 'images/default.png';
                                                            $imgGrande = $img;
                                                            $mostraBtExcluir = false;
                                                            if($image_background)
                                                            {
                                                                $mostraBtExcluir = true;
                                                                $image_backgroundId = $image_background->id;
                                                                $img = $image_background->image_background_namefilefullthumb ? $image_background->image_background_namefilefullthumb : $img;
                                                                $imgGrande = $img;
                                                                $imgGrande = $image_background->image_background_namefilefull ? $image_background->image_background_namefilefull : $img;
                                                            }
                                                        ?>
                                                          <img src="/{{$img}}" rel="/{{$imgGrande}}" class="rounded mx-auto d-block imagesList" height="80" alt="" />
                                                          <div class="col-md-12 text-center mb-3">
                                                              @if($mostraBtExcluir)
                                                                  <button type="button" relId="{{$image_backgroundId}}" relCampo="ImagemBackground" relAcao="delete-image" class="btn btn-outline-danger btn-sm btns-delete-imgs-principais">Excluir Imagem</button>
                                                              @endif
                                                          </div>
                                                          <div class="custom-file {{--mb-2--}}">
                                                              <input type="file" id="inputImageBackground" class="custom-file-input" name="fileBackground[]" />
                                                              <label class="custom-file-label" for="customFile">Imagem Background</label>
                                                          </div>
                                                          <!-- <label for="inputLegendaImagemPrincipal">Legenda:</label>
                                                          <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Legenda da imagem principal" name="legendaImagem" value="{{$parceiros->legenda_imagem}}"> -->
                                                      </div>
                                                  </div>


                                                  <div class="form-row">
                                                      <div class="form-group col-md-12">
                                                          <label for="inputTelefone">Site:</label>
                                                          <input type="text" class="form-control form-control-sm" id="inputSite" maxlength="240" placeholder="Site" name="site" value="{{$parceiros->site}}" />
                                                      </div>
                                                  </div>
                                                  <div class="form-row">
                                                      <div class="form-group col-md-12">
                                                          <label for="inputResponsavel">Links Redes Sociais:</label>
                                                      </div>
                                                  </div>
                                                  <div class="form-row">
                                                      <div class="form-group col-md-2">
                                                          <img src="/images/adm/facebook.png" class="img-fluid" alt="Facebook" />
                                                      </div>
                                                      <div class="form-group col-md-10">
                                                          <input type="text" class="form-control form-control-sm" id="inputFacebook" maxlength="240" placeholder="Facebook" name="facebook" value="{{$parceiros->facebook}}" />
                                                      </div>
                                                  </div>
                                                  <div class="form-row">
                                                      <div class="form-group col-md-2">
                                                          <img src="/images/adm/twiiter.png" class="img-fluid" alt="Twiiter" />
                                                      </div>
                                                      <div class="form-group col-md-10">
                                                          <input type="text" class="form-control form-control-sm" id="inputTwitter" maxlength="240" placeholder="Twitter" name="twitter" value="{{$parceiros->twitter}}" />
                                                      </div>
                                                  </div>
                                                  <div class="form-row">
                                                      <div class="form-group col-md-2">
                                                          <img src="/images/adm/instagram.png" class="img-fluid" alt="Instagram" />
                                                      </div>
                                                      <div class="form-group col-md-10">
                                                          <input type="text" class="form-control form-control-sm" id="inputInstagram" maxlength="240" placeholder="Instagram" name="instagram" value="{{$parceiros->instagram}}" />
                                                      </div>
                                                  </div>
                                                  <div class="form-row">
                                                      <div class="form-group col-md-2">
                                                          <img src="/images/adm/youtube.png" class="img-fluid" alt="youtube" />
                                                      </div>
                                                      <div class="form-group col-md-10">
                                                          <input type="text" class="form-control form-control-sm" id="inputYoutube" maxlength="240" placeholder="Youtube" name="youtube" value="{{$parceiros->youtube}}" />
                                                      </div>
                                                  </div>



                                              </div>
                                          </div>

                                    </div>
                                </div>

                          </div>

                          <div class="card-footer text-muted">
                                <button type="submit" id="bt-cadastrar-editar" class="btn btn-outline-success btn-block">Atualizar Parceiro</button>
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
      <input type="hidden" name="idParceiro" value="" />
      <input type="hidden" name="name" value="" />
</form>
@endsection

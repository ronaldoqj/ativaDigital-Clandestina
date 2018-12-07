<?php
    $casas = $return['casas'];
    $categorias = $return['categorias'];
?>
@extends('layouts.adm')
@section('css')
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
    </style>
@endsection
@section('jsHead')
    <script type="text/javascript" src="/plugins-frameworks/ckeditor/ckeditor.js"></script>
@endsection
@section('js')
    <script src="/js/pages/adm/casas.js"></script>
    <script src="/js/pages/adm/ajaxBannersTop.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
    <script type="text/javascript" src="/plugins-frameworks/jquery.mask/v1.14.15/jquery.mask.min.js"></script>
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
                    Cadastrar Nova Casa
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card border-warning">

                          <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                              {{ csrf_field() }}
                              <input type="hidden" name="action" value="register" />
                              <input type="hidden" name="categorias" value="" />
                              <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-5">

                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputNome">Nome:*</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputNome" maxlength="240" placeholder="Nome" name="name" required />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputSubTitle">Sub-Title:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputSubTitle" maxlength="240" placeholder="Sub-Title" name="sub_title" />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputCategoria">Categoria:</label>
                                                      <select id="selectCategoria" class="selectpicker is-valid" data-actions-box="true" data-width="100%" multiple title="Selecione as Categorias">
                                                          @foreach( $categorias as $categoria )
                                                          <option value="{{$categoria->id}}" data-content="<img src='/{{$categoria->namefilefull}}' height='25' alt='{{$categoria->name}}'> {{str_limit($categoria->name, 30, '...')}}">{{str_limit($categoria->name, 30, '...')}}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputDiasHorarios">Dias e Horários: (coluna A)</label>
                                                      <textarea id="inputDiasHorarios" name="diasHorarios"></textarea>
                                                      <script type="text/javascript">
                                                          CKEDITOR.replace( 'inputDiasHorarios' );
                                                      </script>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputDiasHorarios2">Dias e Horários: (coluna B)</label>
                                                      <textarea id="inputDiasHorarios2" name="diasHorarios2"></textarea>
                                                      <script type="text/javascript">
                                                          CKEDITOR.replace( 'inputDiasHorarios2' );
                                                      </script>
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-6">
                                                      <label for="inputTelefone">Telefone:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputTelefone" maxlength="20" placeholder="Telefone" name="telefone" />
                                                  </div>
                                                  <div class="form-group col-md-6">
                                                      <label for="inputCelular">Celular</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputCelular"  maxlength="20" placeholder="Celular" name="celular" />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-6">
                                                      <label for="inputCep">Cep:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputCep" maxlength="9" placeholder="Cep" name="cep" />
                                                  </div>
                                                  <div class="form-group col-md-6">
                                                      <label for="inputEndereco">Endereço:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputEndereco" maxlength="240" placeholder="Endereço" name="endereco" />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputCidade">Cidade:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputCidade"  maxlength="240" placeholder="Cidade" name="cidade" />
                                                  </div>
                                              </div>

                                              <div class="form-row">
                                                  <div class="form-group col-md-4">
                                                      <label for="inputNumero">N°:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputNumero" maxlength="10" placeholder="Número" name="numero" />
                                                  </div>
                                                  <div class="form-group col-md-8">
                                                      <label for="inputUF">UF:</label>
                                                      <select class="form-control form-control-sm" id="inputUF" name="UF">
                                                          <option value="">Selecione o Estado</option>
                                                          <option value="AC">Acre</option>
                                                        	<option value="AL">Alagoas</option>
                                                        	<option value="AP">Amapá</option>
                                                        	<option value="AM">Amazonas</option>
                                                        	<option value="BA">Bahia</option>
                                                        	<option value="CE">Ceará</option>
                                                        	<option value="DF">Distrito Federal</option>
                                                        	<option value="ES">Espírito Santo</option>
                                                        	<option value="GO">Goiás</option>
                                                        	<option value="MA">Maranhão</option>
                                                        	<option value="MT">Mato Grosso</option>
                                                        	<option value="MS">Mato Grosso do Sul</option>
                                                        	<option value="MG">Minas Gerais</option>
                                                        	<option value="PA">Pará</option>
                                                        	<option value="PB">Paraíba</option>
                                                        	<option value="PR">Paraná</option>
                                                        	<option value="PE">Pernambuco</option>
                                                        	<option value="PI">Piauí</option>
                                                        	<option value="RJ">Rio de Janeiro</option>
                                                        	<option value="RN">Rio Grande do Norte</option>
                                                        	<option value="RS">Rio Grande do Sul</option>
                                                        	<option value="RO">Rondônia</option>
                                                        	<option value="RR">Roraima</option>
                                                        	<option value="SC">Santa Catarina</option>
                                                        	<option value="SP">São Paulo</option>
                                                        	<option value="SE">Sergipe</option>
                                                        	<option value="TO">Tocantins</option>
                                                      </select>
                                                  </div>
                                              </div>
                                        </div>
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-6">
                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputLocalizacao">Localização:</label>
                                                      <textarea class="form-control form-control-sm" id="inputLocalizacao" placeholder="Localização" name="localizacao"></textarea>
                                                  </div>
                                              </div>

                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputResponsavel">Responsável:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputResponsavel" maxlength="240" placeholder="Responsável" name="responsavel" />
                                                  </div>
                                              </div>

                                              <div class="form-row">
                                                  <div class="form-group col-md-6">
                                                      <label for="inputTelefoneResponsavel">Telefone:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputTelefoneResponsavel" maxlength="20" placeholder="Telefone" name="telefoneResponsavel" />
                                                  </div>
                                                  <div class="form-group col-md-6">
                                                      <label for="inputCelularResponsavel">Celular</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputCelularResponsavel" maxlength="20" placeholder="Celular" name="celularResponsavel" />
                                                  </div>
                                              </div>

                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputBannerPrincipal">Banner Principal:</label>

                                                      <div class="card border-secondary">
                                                          <div class="card-body">
                                                            <label for="inputTitleBanner">Título:</label>
                                                            <input type="text" class="form-control form-control-sm mb-3" id="inputTitleBanner" maxlength="240" placeholder="Título do banner" name="title_banner" />

                                                            <label for="inputBannerPrincipal">Selecione uma Imagem:</label>
                                                            <div class="custom-file mb-3">
                                                                <input type="file" id="inputBannerPrincipal" class="custom-file-input" name="fileBannerPrincipal[]" />
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
                                                                  <input type="file" id="inputImagemPrincipal" class="custom-file-input" name="fileImagemPrincipal[]" />
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
                                                            <input type="text" class="form-control form-control-sm mb-3" maxlength="140" placeholder="Nome padrão para todas imagens" name="namedefault" />
                                                            <label for="inputGaleria">Selecione as Imagens:</label>
                                                            <div class="custom-file">
                                                                <input type="file" id="inputGaleria" class="custom-file-input" multiple name="filesGaleria[]" />
                                                                <label class="custom-file-label" for="customFile">Imagens Para a Galeria</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                              </div>

                                              <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                      <label for="inputTelefone">Site:</label>
                                                      <input type="text" class="form-control form-control-sm" id="inputSite" maxlength="240" placeholder="Site" name="site" />
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
                                                      <input type="text" class="form-control form-control-sm" id="inputFacebook" maxlength="240" placeholder="Facebook" name="facebook" />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-2">
                                                      <img src="/images/adm/twiiter.png" class="img-fluid" alt="Twiiter" />
                                                  </div>
                                                  <div class="form-group col-md-10">
                                                      <input type="text" class="form-control form-control-sm" id="inputTwitter" maxlength="240" placeholder="Twitter" name="twitter" />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-2">
                                                      <img src="/images/adm/instagram.png" class="img-fluid" alt="Instagram" />
                                                  </div>
                                                  <div class="form-group col-md-10">
                                                      <input type="text" class="form-control form-control-sm" id="inputInstagram" maxlength="240" placeholder="Instagram" name="instagram" />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-2">
                                                      <img src="/images/adm/whatsapp.png" class="img-fluid" alt="Whatsapp" />
                                                  </div>
                                                  <div class="form-group col-md-10">
                                                      <input type="text" class="form-control form-control-sm" id="inputWhatsapp" maxlength="240" placeholder="Whatsapp" name="whatsapp" />
                                                  </div>
                                              </div>
                                              <div class="form-row">
                                                  <div class="form-group col-md-2">
                                                      <img src="/images/adm/youtube.png" class="img-fluid" alt="youtube" />
                                                  </div>
                                                  <div class="form-group col-md-10">
                                                      <input type="text" class="form-control form-control-sm" id="inputYoutube" maxlength="240" placeholder="Youtube" name="youtube" />
                                                  </div>
                                              </div>

                                        </div>
                                    </div>

                              </div>

                              <div class="card-footer text-muted">
                                    <button type="submit" id="bt-cadastrar-editar" class="btn btn-outline-success btn-block">Cadastrar Casa</button>
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

                      @forelse ($casas as $register)
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
                          <form action="{{url("/adm/casas-edit/{$register->id}")}}" method="get">
                              <div class="card border-secondary">
                                <div class="card-body text-secondary">


                                  <div class="row">
                                      <div class="col col-12 col-sm-6">

                                          <div class="input-group input-group-sm mb-1">
                                              <div class="input-group-prepend">
                                                  <div class="input-group-text">
                                                    <input type="checkbox" class="checkbox-register-home" rel-id="{{$register->id}}" rel-table="casas" rel-Column="home" aria-label="Checkbox for following text input" {{$checkBoxHomeCheck}} /><span id="span-register-home_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxHomeActive}}">Home</span>
                                                  </div>
                                              </div>
                                              <input type="number" id="order_home-{{$register->id}}" class="form-control size-font order-banners" rel-id="{{$register->id}}" rel-table="casas" rel-Column="order_home" aria-label="Text input with checkbox" placeholder="Ordem na home" value="{{$register->order_home}}" />
                                          </div>

                                      </div>
                                      <div class="col col-12 col-sm-6">

                                        <div class="input-group input-group-sm mb-1">
                                          <input type="number" id="order-{{$register->id}}" class="form-control text-right size-font order-banners" rel-id="{{$register->id}}" rel-table="casas" rel-Column="order" aria-label="Text input with checkbox" placeholder="Ordem do banner" value="{{$register->order}}" />
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                  <input type="checkbox" class="checkbox-register" rel-id="{{$register->id}}" rel-table="casas" rel-Column="banner" aria-label="Checkbox for following text input" {{$checkBoxCheck}} /><span id="span-register_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxActive}}">Banner</span>
                                                </div>
                                            </div>

                                        </div>

                                      </div>
                                  </div>


                                  <div class="imagesList" rel="/{{$imgGrande}}" style="background-image: url(/{{$img}});"></div>
                                      <div style="float:right;" class="btns-listagem">
                                          <div class="input-group-append">
                                            <!-- <div class="input-group-text">
                                                <input type="checkbox" class="checkbox-register-home" rel-id="{{$register->id}}" rel-table="casas" rel-Column="home" aria-label="Checkbox for following text input" {{$checkBoxHomeCheck}} /><span id="span-register-home_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxHomeActive}}">Home</span>
                                            </div>
                                            <div class="input-group-text">
                                                <input type="checkbox" class="checkbox-register" rel-id="{{$register->id}}" rel-table="casas" rel-Column="banner" aria-label="Checkbox for following text input" {{$checkBoxCheck}} /><span id="span-register_{{$register->id}}" class="check-register checkBoxSN {{$checkBoxActive}}">Banner</span>
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
                          <p>Nenhuma casa cadastrada no momento.</p>
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
            <h5 class="modal-title" id="exampleModalLabel">Imagem da Categoria</h5>
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
      <input type="hidden" name="idCasa" value="">
</form>
@endsection

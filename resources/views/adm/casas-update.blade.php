<?php
    $casa = $return['casa'];
    $categorias = $return['categorias'];
    $casaCategorias = $return['casaCategorias'];
    $bannerPrincipal = count($return['bannerPrincipal']) ? $return['bannerPrincipal'][0] : [];
    $imagemPrincipal = count($return['imagemPrincipal']) ? $return['imagemPrincipal'][0] : [];
    $galeria = count($return['galeria']) ? $return['galeria'] : [];
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
    <script src="/js/pages/adm/casas.js"></script>
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
            <a class="btn btn-outline-dark btn-sm" href="/adm/casas" role="button">Voltar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 m-b-20">
                <div class="card border-warning">

                      <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                          {{ csrf_field() }}
                          <input type="hidden" name="action" value="edit" />
                          <input type="hidden" name="id" value="{{$casa->id}}" />
                          <input type="hidden" name="categorias" value="" />
                          <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-5">

                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputNome">Nome:*</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputNome" maxlength="240" placeholder="Nome" name="name" value="{{$casa->name}}" required />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputSubTitle">Sub-Title:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputSubTitle" maxlength="240" placeholder="Sub-Title" name="sub_title" value="{{$casa->sub_title}}" />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputTelefone">Categoria:</label>
                                                  <select id="selectCategoria" class="selectpicker is-valid" data-actions-box="true" data-width="100%" multiple title="Selecione as Categorias">
                                                      @foreach( $categorias as $categoria )
                                                          <?php
                                                              $selected = '';
                                                              foreach ($casaCategorias as $casaCategoria) {
                                                                  if ($casaCategoria->id_categoria == $categoria->id) {
                                                                      $selected = 'selected';
                                                                  }
                                                              }
                                                          ?>
                                                          <option {{$selected}} value="{{$categoria->id}}" data-content="<img src='/{{$categoria->namefilefull}}' height='25' alt='{{$categoria->name}}'> {{str_limit($categoria->name, 30, '...')}}">{{str_limit($categoria->name, 30, '...')}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputDiasHorarios">Dias e Horários: (coluna A)</label>

                                                  <textarea id="inputDiasHorarios" name="diasHorarios">{!!$casa->diashorarios!!}</textarea>
                                                  <script type="text/javascript">
                                                      CKEDITOR.replace( 'inputDiasHorarios' );
                                                  </script>
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputDiasHorarios2">Dias e Horários: (coluna B)</label>

                                                  <textarea id="inputDiasHorarios2" name="diasHorarios2">{!!$casa->diashorarios2!!}</textarea>
                                                  <script type="text/javascript">
                                                      CKEDITOR.replace( 'inputDiasHorarios2' );
                                                  </script>
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-6">
                                                  <label for="inputTelefone">Telefone:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputTelefone" maxlength="20" placeholder="Telefone" name="telefone" value="{{$casa->telefone}}" />
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="inputCelular">Celular</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputCelular"  maxlength="20" placeholder="Celular" name="celular" value="{{$casa->celular}}" />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-6">
                                                  <label for="inputCep">Cep:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputCep" maxlength="9" placeholder="Cep" name="cep" value="{{$casa->cep}}" />
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="inputEndereco">Endereço:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputEndereco" maxlength="240" placeholder="Endereço" name="endereco" value="{{$casa->endereco}}" />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputCidade">Cidade:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputCidade"  maxlength="240" placeholder="Cidade" name="cidade" value="{{$casa->cidade}}" />
                                              </div>
                                          </div>

                                          <div class="form-row">
                                              <div class="form-group col-md-4">
                                                  <label for="inputNumero">N°:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputNumero" maxlength="10" placeholder="Número" name="numero" value="{{$casa->numero}}" />
                                              </div>
                                              <div class="form-group col-md-8">
                                                  <label for="inputUF">UF:</label>
                                                  <select class="form-control form-control-sm" id="inputUF" name="UF">
                                                      <option value="">Selecione o Estado</option>
                                                      <?php
                                                          $ArrayUFs = [
                                                                        ['sigla' => 'AC', 'nome' => 'Acre'],
                                                                      	['sigla' => 'AL', 'nome' => 'Alagoas'],
                                                                      	['sigla' => 'AP', 'nome' => 'Amapá'],
                                                                      	['sigla' => 'AM', 'nome' => 'Amazonas'],
                                                                      	['sigla' => 'BA', 'nome' => 'Bahia'],
                                                                      	['sigla' => 'CE', 'nome' => 'Ceará'],
                                                                      	['sigla' => 'DF', 'nome' => 'Distrito Federal'],
                                                                      	['sigla' => 'ES', 'nome' => 'Espírito Santo'],
                                                                      	['sigla' => 'GO', 'nome' => 'Goiás'],
                                                                      	['sigla' => 'MA', 'nome' => 'Maranhão'],
                                                                      	['sigla' => 'MT', 'nome' => 'Mato Grosso'],
                                                                      	['sigla' => 'MS', 'nome' => 'Mato Grosso do Sul'],
                                                                      	['sigla' => 'MG', 'nome' => 'Minas Gerais'],
                                                                      	['sigla' => 'PA', 'nome' => 'Pará'],
                                                                      	['sigla' => 'PB', 'nome' => 'Paraíba'],
                                                                      	['sigla' => 'PR', 'nome' => 'Paraná'],
                                                                      	['sigla' => 'PE', 'nome' => 'Pernambuco'],
                                                                      	['sigla' => 'PI', 'nome' => 'Piauí'],
                                                                      	['sigla' => 'RJ', 'nome' => 'Rio de Janeiro'],
                                                                      	['sigla' => 'RN', 'nome' => 'Rio Grande do Norte'],
                                                                      	['sigla' => 'RS', 'nome' => 'Rio Grande do Sul'],
                                                                      	['sigla' => 'RO', 'nome' => 'Rondônia'],
                                                                      	['sigla' => 'RR', 'nome' => 'Roraima'],
                                                                      	['sigla' => 'SC', 'nome' => 'Santa Catarina'],
                                                                      	['sigla' => 'SP', 'nome' => 'São Paulo'],
                                                                      	['sigla' => 'SE', 'nome' => 'Sergipe'],
                                                                      	['sigla' => 'TO', 'nome' => 'Tocantins']
                                                                      ];
                                                      ?>
                                                      @foreach( $ArrayUFs as $uf )
                                                          <?php
                                                          $selected = '';
                                                              if ($uf['sigla'] == $casa->uf) {
                                                                  $selected = 'selected';
                                                              }
                                                          ?>
                                                          <option {{$selected}} value="{{$uf['sigla']}}">{{$uf['nome']}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                    </div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-6">
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputLocalizacao">Localização:</label>
                                                  <textarea class="form-control form-control-sm" id="inputLocalizacao" placeholder="Localização" name="localizacao">{!!$casa->localizacao!!}</textarea>
                                              </div>
                                          </div>

                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputResponsavel">Responsável:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputResponsavel" maxlength="240" placeholder="Responsável" name="responsavel" value="{{$casa->responsavel}}" />
                                              </div>
                                          </div>

                                          <div class="form-row">
                                              <div class="form-group col-md-6">
                                                  <label for="inputTelefoneResponsavel">Telefone:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputTelefoneResponsavel" maxlength="20" placeholder="Telefone" name="telefoneResponsavel" value="{{$casa->telefone_responsavel}}" />
                                              </div>
                                              <div class="form-group col-md-6">
                                                  <label for="inputCelularResponsavel">Celular</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputCelularResponsavel" maxlength="20" placeholder="Celular" name="celularResponsavel" value="{{$casa->celular_responsavel}}" />
                                              </div>
                                          </div>

                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputBannerPrincipal">Banner Principal:</label>

                                                  <div class="card border-secondary">
                                                      <div class="card-body">
                                                          <?php
                                                              $bannerPrincipalId = '';
                                                              $img = 'images/default.png';
                                                              $imgGrande = $img;
                                                              $mostraBtExcluir = false;
                                                              if($bannerPrincipal)
                                                              {
                                                                  $mostraBtExcluir = true;
                                                                  $bannerPrincipalId = $bannerPrincipal->id;
                                                                  $img = $bannerPrincipal->banner_principal_namefilefullthumb ? $bannerPrincipal->banner_principal_namefilefullthumb : $img;
                                                                  $imgGrande = $img;
                                                                  $imgGrande = $bannerPrincipal->banner_principal_namefilefull ? $bannerPrincipal->banner_principal_namefilefull : $img;
                                                              }
                                                          ?>
                                                          <img src="/{{$img}}" rel="/{{$imgGrande}}" class="rounded mx-auto d-block imagesList" height="80" alt="" />
                                                          <div class="col-md-12 text-center mb-3">
                                                              @if($mostraBtExcluir)
                                                                  <button type="button" id="bt-excluir-banner-principal" relId="{{$bannerPrincipalId}}" relCampo="BannerPrincipal" relAcao="delete-image" class="btn btn-outline-danger btn-sm btns-delete-imgs-principais">Excluir Imagem</button>
                                                              @endif
                                                          </div>

                                                          <label for="inputTitleBanner">Título:</label>
                                                          <input type="text" class="form-control form-control-sm mb-2" id="inputTitleBanner" maxlength="240" placeholder="Título do banner" name="title_banner" value="{{$casa->title_banner}}" />

                                                          <label for="inputBannerPrincipal">Selecione uma Imagem:</label>
                                                          <div class="custom-file mb-2">
                                                              <input type="file" id="inputBannerPrincipal" class="custom-file-input" name="fileBannerPrincipal[]" />
                                                              <label class="custom-file-label" for="customFile">Banner Principal</label>
                                                          </div>
                                                          <label for="inputLegendaBannerPrincipal">Legenda:</label>
                                                          <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Legenda da banner principal" name="legendaBanner" value="{{$casa->legenda_banner}}">
                                                      </div>
                                                  </div>

                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputImagemPrincipal">Imagem Principal:</label>

                                                  <div class="card border-secondary">
                                                      <div class="card-body">
                                                        <?php
                                                            $imagemPrincipalId = '';
                                                            $img = 'images/default.png';
                                                            $imgGrande = $img;
                                                            $mostraBtExcluir = false;
                                                            if($imagemPrincipal)
                                                            {
                                                                $mostraBtExcluir = true;
                                                                $imagemPrincipalId = $imagemPrincipal->id;
                                                                $img = $imagemPrincipal->imagem_principal_namefilefullthumb ? $imagemPrincipal->imagem_principal_namefilefullthumb : $img;
                                                                $imgGrande = $img;
                                                                $imgGrande = $imagemPrincipal->imagem_principal_namefilefull ? $imagemPrincipal->imagem_principal_namefilefull : $img;
                                                            }
                                                        ?>
                                                          <img src="/{{$img}}" rel="/{{$imgGrande}}" class="rounded mx-auto d-block imagesList" height="80" alt="" />
                                                          <div class="col-md-12 text-center mb-3">
                                                              @if($mostraBtExcluir)
                                                                  <button type="button" relId="{{$imagemPrincipalId}}" relCampo="ImagemPrincipal" relAcao="delete-image" class="btn btn-outline-danger btn-sm btns-delete-imgs-principais">Excluir Imagem</button>
                                                              @endif
                                                          </div>
                                                          <div class="custom-file mb-2">
                                                              <input type="file" id="inputImagemPrincipal" class="custom-file-input" name="fileImagemPrincipal[]" />
                                                              <label class="custom-file-label" for="customFile">Imagem Principal</label>
                                                          </div>
                                                          <label for="inputLegendaImagemPrincipal">Legenda:</label>
                                                          <input type="text" class="form-control form-control-sm" maxlength="240" placeholder="Legenda da imagem principal" name="legendaImagem" value="{{$casa->legenda_imagem}}">
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
                                                              <input type="file" id="inputGaleria" class="custom-file-input" multiple name="filesGaleria[]">
                                                              <label class="custom-file-label" for="customFile">Imagens Para a Galeria</label>
                                                          </div>

                                                          @if (count($galeria))
                                                                  <div class="card border-secondary">
                                                                      <div class="card-header bg-transparent">
                                                                          <button type="button" rel="{{$casa->id}}" class="btn btn-outline-danger btn-sm btn-block btn-delete-galeria">Excluir Galeria</button>
                                                                      </div>
                                                                      <div class="card-body text-secondary">
                                                                        <!-- <div class="card-columns"> -->
                                                                        <div class="box-thumbs">
                                                                        @foreach ($galeria as $item)
                                                                                @php
                                                                                    //$contI++;
                                                                                    //if($contI > 1) { $showFirtsListI = ''; }
                                                                                @endphp
                                                                                @if ($loop->first)
                                                                                    @php
                                                                                        $ativoI = 'disabled';
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $ativoI = '';
                                                                                    @endphp
                                                                                @endif

                                                                                <div class="thumbs">
                                                                                    <img src="/{{$item->namefilefullthumb}}" alt="{{$item->namefile}}" title="" alt="{{$item->namefile}}" class="rounded img-fluid" />
                                                                                    <div>
                                                                                        <button class="btn btn-outline-secondary order-image btnThumbsImages" type="button" title="Ordenar imagem" rel="{{$item->id}}" rel2="{{$casa->id}}" {{$ativoI}}><i class="material-icons">reply</i></button>
                                                                                        <button class="btn btn-outline-secondary edit-image btnThumbsImages" type="button" title="Editar nome da imagem" rel="{{$item->id}}"><i class="material-icons i-corrige">mode_edit</i></button>
                                                                                        <button class="btn btn-outline-secondary delete-image btnThumbsImages" type="button" title="Excluir Imagem" rel="{{$item->id}}" rel2="{{$casa->id}}"><i class="material-icons i-corrige">delete_forever</i></button>
                                                                                    </div>
                                                                                    <div>
                                                                                        <input type="text" class="form-control form-control-sm inputNomeImagem" aria-label="Nome da imagem" value="{{$item->name}}" />
                                                                                    </div>
                                                                                </div>

                                                                        @endforeach
                                                                        </div>

                                                                      </div>
                                                                  </div>
                                                          @endif
                                                          <!-- <img src="/images/default.png" class="rounded mx-auto d-block mb-3" height="80" alt=""> -->
                                                      </div>
                                                  </div>

                                              </div>
                                          </div>

                                          <div class="form-row">
                                              <div class="form-group col-md-12">
                                                  <label for="inputTelefone">Site:</label>
                                                  <input type="text" class="form-control form-control-sm" id="inputSite" maxlength="240" placeholder="Site" name="site" value="{{$casa->site}}" />
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
                                                  <input type="text" class="form-control form-control-sm" id="inputFacebook" maxlength="240" placeholder="Facebook" name="facebook" value="{{$casa->facebook}}" />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-2">
                                                  <img src="/images/adm/twiiter.png" class="img-fluid" alt="Twiiter" />
                                              </div>
                                              <div class="form-group col-md-10">
                                                  <input type="text" class="form-control form-control-sm" id="inputTwitter" maxlength="240" placeholder="Twitter" name="twitter" value="{{$casa->twitter}}" />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-2">
                                                  <img src="/images/adm/instagram.png" class="img-fluid" alt="Instagram" />
                                              </div>
                                              <div class="form-group col-md-10">
                                                  <input type="text" class="form-control form-control-sm" id="inputInstagram" maxlength="240" placeholder="Instagram" name="instagram" value="{{$casa->instagram}}" />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-2">
                                                  <img src="/images/adm/whatsapp.png" class="img-fluid" alt="Whatsapp" />
                                              </div>
                                              <div class="form-group col-md-10">
                                                  <input type="text" class="form-control form-control-sm" id="inputWhatsapp" maxlength="240" placeholder="Whatsapp" name="whatsapp" value="{{$casa->whatsapp}}" />
                                              </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-2">
                                                  <img src="/images/adm/youtube.png" class="img-fluid" alt="youtube" />
                                              </div>
                                              <div class="form-group col-md-10">
                                                  <input type="text" class="form-control form-control-sm" id="inputYoutube" maxlength="240" placeholder="Youtube" name="youtube" value="{{$casa->youtube}}" />
                                              </div>
                                          </div>

                                    </div>
                                </div>

                          </div>

                          <div class="card-footer text-muted">
                                <button type="submit" id="bt-cadastrar-editar" class="btn btn-outline-success btn-block">Atualizar Casa</button>
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

<form id="form-galery" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="" />
      <input type="hidden" name="id" value="" />
</form>
<form id="form-images" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="order">
      <input type="hidden" name="id" value="" />
      <input type="hidden" name="idCasa" value="" />
      <input type="hidden" name="name" value="" />
</form>
@endsection

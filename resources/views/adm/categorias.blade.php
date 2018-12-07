<?php
    $categorias = $return['categorias'];
?>
@extends('layouts.adm')
@section('js')
    <script src="/js/pages/adm/categorias.js"></script>
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
                    Cadastrar Nova Categoria
                </button>
            </p>
            <div id="register" class="collapse">
                    <div class="card border-warning">
                        <form action="" method="post" enctype="multipart/form-data" class="was-validated">
                            {{ csrf_field() }}
                            <input type="hidden" name="action" value="register">
                            <div class="card-body">
                                  <div class="form-group row">
                                    <label for="inputNome" class="col-md-12 col-form-label">Nome da Categoria:*</label>
                                    <div class="col-md-12">
                                      <input type="text" name="name" class="form-control form-control-sm is-invalid" placeholder="Nome da Categoria. [max. 140 caracteres]" value="" required>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="inputNome" class="col-md-12 col-form-label">Cor para a categoria:</label>
                                    <div class="col-md-12">
                                      <input type="color" class="form-control form-control-sm is-invalid" name="color" value="" required>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="inputNome" class="col-md-12 col-form-label">Descrição da Categoria:</label>
                                    <div class="col-md-12">
                                      <textarea name="description" class="form-control form-control-sm" placeholder="Descrição da Categoria" rows="3"></textarea>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="inputNome" class="col-md-12 col-form-label">Selecionar Imagens:*</label>
                                    <div class="col-md-12">
                                      <div class="custom-file">
                                          <input type="file" class="custom-file-input" name="files[]" id="customFile" required>
                                          <label class="custom-file-label" for="customFile">Selecionar Imagem*</label>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label for="inputNome" class="col-md-12 col-form-label">Nome da imagem:</label>
                                    <div class="col-md-12">
                                      <input type="text" name="nameImage" class="form-control form-control-sm" placeholder="Nome da imagem. [max. 140 caracteres]" value="">
                                    </div>
                                  </div>
                            </div>
                            <div class="card-footer text-muted">
                                  <button type="submit" class="btn btn-outline-success btn-block">Cadastrar Categoria</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>

    <div></div>

    <form id="form-categorias" action="" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="">
        <input type="hidden" name="nomeEdit" value="">
        <input type="hidden" name="action" value="">

        <div class="card border-warning">
            <div class="card-header">Listagem das Categorias</div>
            <div class="card-body">

              @forelse ($categorias as $categoria)
                  <div class="input-group input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text CATEGORIAS-corrigeThumbs" id="inputGroup-sizing-lg"><div class="CATEGORIAS-thumbs" rel="/{{$categoria->namefilefull}}" style="background-image: url(/{{$categoria->namefilefull}}); border-color: {{$categoria->color}}"></div><!--<img src="/{{$categoria->namefilefull}}" class="img-fluid" />--></span>
                      </div>

                      <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" rel="{{ $categoria->id }}" value="{{ $categoria->name }}" aria-describedby="basic-addon2">

                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary edit" type="button" title="Edita" rel="{{json_encode($categoria, true)}}"><i class="material-icons i-corrige">mode_edit</i></button>
                        <button class="btn btn-outline-secondary delete" rel="{{$categoria->id}}" type="button"><i class="material-icons i-corrige">delete_forever</i></button>
                      </div>
                  </div>
              @empty
                  <h4 class="text-center"><span class="label label-default">Nenhuma categoria cadastrada.</span></h4>
              @endforelse

            </div>
        </div>
    </form>
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

<!-- =====================================================================================================================================  -->
<!-- Modal Edit                                                                                                                             -->
<!-- =====================================================================================================================================  -->
<div id="modalEdit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="edit" class="modal-dialog modal-lg">
    <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="" method="post" enctype="multipart/form-data" class="was-validated">
              {{ csrf_field() }}
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="id" value="">
              <div class="card-body">

                    <div style="margin-bottom: 10px;">
                      <img src="" alt="" class="img-fluid img-thumbnail img-modal mx-auto d-block">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group row">
                      <label for="inputNome" class="col-md-12 col-form-label">Nome da Categoria:*</label>
                      <div class="col-md-12">
                        <input type="text" name="name" class="form-control form-control-sm is-invalid" placeholder="Nome da Categoria. [max. 140 caracteres]" value="" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputNome" class="col-md-12 col-form-label">Cor para a categoria:</label>
                      <div class="col-md-12">
                        <input type="color" class="form-control form-control-sm is-invalid" name="color" value="" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputNome" class="col-md-12 col-form-label">Descrição da Categoria:</label>
                      <div class="col-md-12">
                        <textarea name="description" class="form-control form-control-sm" placeholder="Descrição da Categoria" rows="3"></textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputNome" class="col-md-12 col-form-label">Selecionar Imagens:*</label>
                      <div class="col-md-12">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="files[]" id="customFile">
                            <label class="custom-file-label" for="customFile">Selecionar Imagem*</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputNome" class="col-md-12 col-form-label">Nome da imagem:</label>
                      <div class="col-md-12">
                        <input type="text" name="nameImage" class="form-control form-control-sm" placeholder="Nome da imagem. [max. 140 caracteres]" value="">
                      </div>
                    </div>
              </div>
              <div class="card-footer text-muted">
                    <button type="submit" class="btn btn-outline-success btn-block">Atualizar</button>
              </div>
          </form>
      </div>
  </div>
</div>

<!-- Form Delete -->
<form id="form-delete" action="" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="id" value="">
</form>
@endsection

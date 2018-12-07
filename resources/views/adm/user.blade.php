@extends('layouts.adm')
@section('js')
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
        <div class="col-md-12">
              <div>
                  <div class="card">
                      <div class="card-header">
                          Usuário - Login e Senha
                      </div>
                      <form action="" method="post">
                      <div class="card-body">

                                    {{ csrf_field() }}
                                    <input type="hidden" name="action" value="edit" />
                                    <input type="hidden" name="id" value="{{ Auth::user()->id }}" />
                                    <div class="form-group row">
                                        <label for="inputTitle" class="col-sm-12 col-form-label">Usuário:*</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control form-control-sm" id="inputTitle" placeholder="Nome. [max. 190 caracteres]" name="name" value="{{ Auth::user()->name }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputTitle" class="col-sm-12 col-form-label">E-Mail/Login:*</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control form-control-sm" id="inputTitle" placeholder="E-Mail/Login. [max. 190 caracteres]" name="email" value="{{ Auth::user()->email }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputTitle" class="col-sm-12 col-form-label">Função:</label>
                                        <div class="col-sm-12">
                                            <input type="email" class="form-control form-control-sm" id="inputTitle" placeholder="Função. [max. 240 caracteres]" name="funcao" value="{{ Auth::user()->funcao }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputTitle" class="col-sm-12 col-form-label">Nova Senha:*</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control form-control-sm" id="inputTitle" placeholder="Nome. [max. 190 caracteres]" name="password" value="">
                                        </div>
                                    </div>
                    </div>

                    <div class="card-footer text-muted">
                      <button type="Atualizar" class="btn btn-outline-success btn-block">Atualizar</button>
                    </div>
                  </form>
                </div>

            </div>
    </div>
  </div>
</div>

@endsection

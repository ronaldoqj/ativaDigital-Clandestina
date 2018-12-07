@extends('layouts.adm')
@section('css')
  <link rel="stylesheet" href="/plugins-frameworks/bootstrap-select-1.13.0/dist/css/bootstrap-select.css">
  <style>
    .card { margin: 10px; }
    .card-body a button { margin-bottom: 3px; }

    .card-header { cursor: pointer; }
    .text-secondary { padding: 8px; }
    .btns-listagem { padding-top: 3px; height: 40px; }
    .btns-listagem .btn { padding: 3px 8px 0px; }
    .col-form-label { word-wrap:normal; }
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
    }
  </style>
@endsection
@section('js')
    <script src="/js/pages/adm/home.js"></script>
    <script src="/plugins-frameworks/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
@endsection
@section('content')


<div class="container-fluid">
    <div class="row">


@if($errors->any())
<div class="col-md-12">
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h5 class="text-center m-b-20"><strong>Erro ao concluir a requisição!</strong></h5>

    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>
@endif


<form id="form-edit" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="">
    <input type="hidden" name="section" value="">
    <input type="hidden" name="action" value="edit">
</form>
<form id="form-delete" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="">
    <input type="hidden" name="section" value="">
    <input type="hidden" name="action" value="delete">
</form>





    </div>
</div>
@endsection

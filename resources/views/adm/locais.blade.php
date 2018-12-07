@extends('layouts.adm')

@section('css')
    <link rel="stylesheet" href="/plugins/bootstrap-select-1.13.0/dist/css/bootstrap-select.css">
@endsection
@section('jsHead')
    <script type="text/javascript" src="/plugins/ckeditor/ckeditor.js"></script>
    
@endsection
@section('js')
<script src="/plugins/bootstrap-select-1.13.0/dist/js/bootstrap-select.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <!--div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <input class="form-control form-control-sm" type="text" placeholder="Nome do Lugar">
                </div>
            </div>
        </div-->
        
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Cadastro de Local</h2></div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="action" value="register" />
                        <input class="form-control form-control-sm" type="text" name="nameLocal" placeholder="Nome do Local"   required>
                        <input class="form-control form-control-sm" type="text" name="adress"    placeholder="Endereço"        required>
                        <input class="form-control form-control-sm" type="text" name="price"     placeholder="Valor Ex. 12,00" required>
                        
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Imagem Principal</label>
                            <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1" required>
                        </div>
                        
                        <!--input class="form-control form-control-sm" type="text" placeholder="Dias de funcionamento">
                        <input class="form-control form-control-sm" type="text" placeholder="Dias que não funciona"-->
                        
                        <!--select class="form-control form-control-sm">
                            <option>Small select</option>
                        </select-->
                        <select id="fuction-day" name="function-day" class="form-control form-control-sm selectpicker" data-width="100%" multiple data-done-button="true" title="Dias de Funcionamento" required>
                            <option value="5">Domingo</option>
                            <option value="1">Segunda-Feira</option>
                            <option value="2">Terça-Feira</option>
                            <option value="3">Quarta-Feira</option>
                            <option value="4">Quinta-Feira</option>
                            <option value="5">Sexta-Feira</option>
                            <option value="5">Sábado</option>
                        </select>
                        
                        <select id="ranking" name="ranking" class="form-control form-control-sm selectpicker" data-width="100%" multiple data-done-button="true" title="Selecione a Classificação">
                            <option value="1">$</option>
                            <option value="2">$$</option>
                            <option value="3">$$$</option>
                            <option value="4">$$$$</option>
                            <option value="5">$$$$$</option>
                        </select>

                        <div class="adm-title-input">Descrição:</div>

                        <textarea id="editor1" name="editor1"></textarea>
                        <script type="text/javascript">
                            CKEDITOR.replace( 'editor1' );
                        </script>
                        <div class="m-t-30"></div>
                        <button type="submit" class="btn btn-success btn-sm btn-block">Block level button</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

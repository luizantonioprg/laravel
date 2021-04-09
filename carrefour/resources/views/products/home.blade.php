@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="col-sm-8 mt-2">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                        {{ session()->get('success') }}  
                        </div>
                    @endif
            </div>
                <div class="card-header">AÇÕES DE PRODUTOS</div>
                <div class="card-body">                                 
                    <a href="/products/create">REGISTRAR NOVO</a>
                    <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <td>ID</td>
                                <td>CODIGO</td>
                                <td>TITULO</td>
                                <td>CATEGORIA</td>
                                </tr>
                            </thead>
                            <tbody>
                             
                            </tbody>
                        </table>    
                    <div>
                  </div>                            
                </div>
            </div>
        </div>
    </div>
    
@endsection
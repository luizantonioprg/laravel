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
                <div class="card-header">AÇÕES DE CATEGORIAS</div>
                <div class="card-body">          
                @if(Auth::user()->privilege=='admin')                       
                    <a href="/categories/create">REGISTRAR NOVA</a>
                @endif
                    <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <td>ID</td>
                                <td>CODIGO</td>
                                <td>TITULO</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $c)
                                <tr>
                                    <td>{{$c->id}}</td>
                                    <td>{{$c->codigo}}</td>
                                    <td>{{$c->titulo}}</td>
                                    <td>
                                    @if(Auth::user()->privilege=='admin')
                                        <a href="{{ route('categories.edit',$c->id)}}" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                                <form action="{{ route('categories.destroy', $c->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                        </td>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>    
                    <div>
                  </div>                            
                </div>
            </div>
        </div>
    </div>
    
@endsection
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
                <div class="card-header">AÇÕES DE SUBCATEGORIA</div>
                <div class="card-body">         
                @if(Auth::user()->privilege=='admin')                        
                    <a href="/subcategories/create">REGISTRAR NOVA</a>
                @endif
                
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
                                @foreach($subCategories as $c)
                                <tr>
                                    <td>{{$c->id}}</td>
                                    <td>{{$c->codigo}}</td>
                                    <td>{{$c->titulo}}</td>
                                    <td>{{$c->category->titulo}}</td>
                                    <td>
                                    @if(Auth::user()->privilege=='admin')
                                        <a href="{{ route('subcategories.edit',$c->id)}}" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                                <form action="{{ route('subcategories.destroy', $c->id)}}" method="post">
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
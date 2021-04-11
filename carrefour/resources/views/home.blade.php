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
                <div class="card-header">AÇÕES DE USUÁRIO</div>
                <div class="card-body">
                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->
                    
                    <!-- @if(Auth::user()->privilege=='admin')
                    <h1>SOU ADMIN</h1>
                    @else
                    <h1>SOU USER</h1>
                    @endif -->
                  
                    <a href="/register">REGISTRAR NOVO</a>
                    <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Privilegio</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($User as $u)
                                <tr>
                                    <td>{{$u->id}}</td>
                                    <td>{{$u->name}}</td>
                                    <td>{{$u->email}}</td>
                                    <td>{{$u->privilege}}</td>
                                    <td>
                                    @if(Auth::user()->privilege=='admin')
                                        <a href="{{ route('users.edit',$u->id)}}" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                                <form action="{{ route('users.destroy', $u->id)}}" method="post">
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
    <!-- <div class="container mt-5">
        <div class="row justify-content-left">
            <button class="btn btn-primary mx-2">
                <a class="text-white mr-2" href="/categories">CATEGORIAS</a>
            </button>
            <button class="btn btn-primary mx-2">
                <a class="text-white mr-2" href="/subcategories">SUBCATEGORIAS</a>
            </button>
            <button class="btn btn-primary">
                <a class="text-white mr-2" href="/products">PRODUTOS</a>
            </button>
        </div>
    </div> -->
</div>



@endsection



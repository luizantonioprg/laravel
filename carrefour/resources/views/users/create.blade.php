@extends('layouts.app')
@section('content')





<form class="container" method="post" action="{{ route('home.store') }}">
            
            @csrf
            <h3>CRIAR USUÁRIO<h3><br>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <div class="form-group">
                <label for="codigo">Nome:</label>
                <input type="text" class="form-control" name="nome" />
            </div>
            <div class="form-group">
                <label for="titulo">Email:</label>
                <input type="text" class="form-control" name="email"/>
            </div>
            <div class="form-group">
                <label for="titulo">Senha:</label>
                <input type="text" class="form-control" name="senha"/>
            </div>
            <div class="form-group">
                <label for="titulo">Privilegio:</label>
                <input type="text" class="form-control" name="email"/>
            </div>
            <button type="submit" class="btn btn-primary">CRIAR</button>
        </form>
@endsection


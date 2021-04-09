@extends('layouts.app')
@section('content')





<form class="container" method="post" action="{{ route('categories.update', $category->id) }}">
            @method('PATCH') 
            @csrf
            <h3>EDITAR CATEGORIA<h3><br>

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
                <label for="codigo">Código:</label>
                <input type="text" class="form-control" name="codigo" value="{{ $category->codigo }}" />
            </div>
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" name="titulo" value="{{ $category->titulo }} "/>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
@endsection


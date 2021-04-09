@extends('layouts.app')
@section('content')





<form class="container" method="post" action="{{ route('subcategories.update', $subcategory->id) }}">
            @method('PATCH') 
            @csrf
            <h3>EDITAR SUBCATEGORIA<h3><br>

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
                <input type="text" class="form-control" name="codigo" value="{{ $subcategory->codigo }}" />
            </div>
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" name="titulo" value="{{ $subcategory->titulo }}" />
            </div>
            <div class="form-group">
            <label for="codigo">Categoria:</label><br>
              <select name="id_categoria" class="form-select" aria-label="Default select example">
                <option selected >SELECIONAR CATEGORIA</option>
                    @foreach($categories as $s)
                    <option value="{{$s->id}}">{{$s->titulo}}</option>
                    @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
@endsection


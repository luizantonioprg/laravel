@extends('layouts.app')
@section('content')





<form class="container" method="post" action="{{ route('users.update', $User->id) }}">
            @method('PATCH') 
            @csrf
            <h3>EDITAR USUARIO<h3><br>

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
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="{{ $User->name }}" />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" value="{{ $User->email }} "/>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
@endsection


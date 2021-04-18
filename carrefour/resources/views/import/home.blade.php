@extends('layouts.app')
@section('content')



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
                <div class="card-header">IMPORTAR CSV</div>
                <div class="card-body">
                       <!-- Message -->
                      @if(Session::has('message'))
                          <p >{{ Session::get('message') }}</p>
                      @endif

                      <!-- Form -->
                      <form method='post' action="/products/importar/inserir" enctype='multipart/form-data' >
                      @method('POST') 
                      @csrf
                      <div class="form-group">
                            <label for="codigo">Categoria:</label><br>
                            <select onchange="searchSubcategories();" name="id_categoria" id="id_categoria" class="form-select" aria-label="Default select example">
        
                               <option selected > SELECIONE A CATEGORIA</option>
                                @foreach($categories as $s)
                                <option value="{{$s->id}}">{{$s->titulo}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Subcategoria:</label><br>
                            <select name="id_subcategoria" id="id_subcategoria" class="form-select" aria-label="Default select example">
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="tags">Tags: </label>
                            <input type="text" id="tags" name="tags">
                        </div>    -->
                        <input type='file' name='file' >
                        <input type='submit' name='importSubmit' value='Import'><br>
                        <button class="btn btn-success mt-2">
                            <a download class="text-white" href="/download/modelo.csv">MODELO</a>
                        </button>
                      </form>
                   
          
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

<script>
function searchSubcategories(){
   $div = document.getElementById("id_subcategoria");
   $id = document.getElementById("id_categoria").value;
   const url = fetch("http://carrefour.test/products/retrieveSubcategories/"+$id);

   url.then(r => r.json()).then(body => {
      $arr = body;
      while ($div.length > 0) {
            $div.remove(0);
      }
     
      for(i=0;i<$arr.length;i++){
         
         var opt = document.createElement('option');
         opt.value = $arr[i][0];
         opt.innerHTML = $arr[i][1];
         $div.appendChild(opt);
        
      }
      
   });
}

</script>

@endsection



@extends('layouts.app')
@section('content')

<form class="container" method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
   @csrf
   <h3>
   CRIAR PRODUTO
   <h3>
   <br>
   @if ($errors->has('imagem')) 
   <div class="alert alert-danger">
      <span>A imagem recortada é muito grande.</span> 
   </div>
   @else
   @if ($errors->any())
   <div class="alert alert-danger">
      <ul>
         @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
   <br />
   @endif
   @endif
   <div class="form-group">
      <label for="codigo">Código:</label>
      <input type="text" class="form-control" name="codigo" />
   </div>
   <div class="form-group">
      <label for="titulo">Título:</label>
      <input type="text" class="form-control" name="titulo"/>
   </div>
   <div class="form-group">
      <label for="codigo">Categoria:</label><br>
      <select onchange="searchSubcategories();" name="id_categoria" id="id_categoria" class="form-select" aria-label="Default select example">
         <option selected >SELECIONAR CATEGORIA</option>
         @foreach($categories as $s)
         <option value="{{$s->id}}">{{$s->titulo}}</option>
         @endforeach
      </select>
   </div>
   <div class="form-group">
      <label for="codigo">Subcategoria:</label><br>
      <select name="id_subcategoria" id="id_subcategoria" class="form-select" aria-label="Default select example">
         <!-- <option selected >SELECIONAR SUBCATEGORIA</option>
         <option value="2">teste</option> -->
      </select>
   </div>
   <div class="form-group">
      <label for="image">Imagem:  </label><br>
      <input id="file" name="primeiraImagem" type="file" /><br>
      <div id="jcrop" ></div>
      <label>Recorte da Imagem:  </label><br>
      <canvas id="canvas"style="border:dashed 5px #bebebe;margin-top:2vh;" ></canvas>
      <input id="png" name="imagem" type="hidden"/>
   </div>
   <div class="form-group">
      <label for="image">Descrição: </label>
      <textarea class="form-control" id="summary-ckeditor" name="descricao"></textarea>
   </div>
   <div class="form-group">
      <label for="valor">Valor: R$ </label>
      <input class="money" id="input" name="valor" type="text">
   </div>
   <div class="form-group">
      <label for="tags">Tags: </label>
      <input type="text" name="tags" id="tags">
   </div>
   <div class="form-group">
      <label for="status">Status:</label><br>
      <select name="status" class="form-select" aria-label="Default select example">
         <option selected >SELECIONAR STATUS</option>
         <option value="ativo">ativo</option>
         <option value="inativo">inativo</option>
      </select>
   </div>
   <div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="6LfxpKQaAAAAABClNvRLPpjTZj-5l8iulNWqvYqx"></div>
   <button type="submit" class="btn btn-primary">CRIAR</button>
   </div>
</form>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{ asset('js/tags-input.js') }}"></script>
<script>
   var instance = new TagsInput({
       selector: 'tags',
       max : 3
   });
   
   
</script>
<script src="{{ asset('js/mascara.js') }}"></script>
<script src="{{ asset('js/jcrop.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
   CKEDITOR.replace( 'summary-ckeditor' );
</script>
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
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
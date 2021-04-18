@extends('layouts.app')
@section('content')
<div class="col-sm-8 mt-2">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                        {{ session()->get('success') }}  
                        </div>
                    @endif
            </div>
<div class="container my-4">    

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">CODIGO</th>
              <th scope="col">TITULO</th>
              <th scope="col">CATEGORIA</th>
              <th scope="col">SUBCATEGORIA</th>
              <th scope="col">STATUS</th>
            </tr>
          </thead>
          <tbody>
          @foreach($produtos as $p)
            <tr class="accordion-toggle collapsed" id="accordion1" data-toggle="collapse" data-parent="#accordion1" href="#{{$p->titulo}}">
              <td class="expand-button">+</td>
              <td>{{$p->codigo}}</td>
              <td>{{$p->titulo}}</td>
              <td>{{$p->category->titulo}}</td>
              <td>{{$p->subcategory->titulo}}</td>
              <td>{{$p->status}}</td>

            </tr>
            
            <tr class="hide-table-padding">
                <td></td>
                <td colspan="3">
                <div id="{{$p->titulo}}" class="collapse in p-3">
                  <div class="row">
                    <div class="col-2">Imagem</div>
                    <div class="col-6">
                     <img src="{{$p->imagem}}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-2">Valor</div>
                    <div class="col-6">R${{number_format($p->valor, 2, ',', '.')}}</div>
                  </div>
                  <div class="row">
                    <div class="col-2">Tags</div>
                    <div class="col-6">{{$p->tag}}</div>
                  </div>
                  <div class="row">
                    <div class="col-2">Descricao</div>
                    <div class="col-6">{!!$p->descricao!!}</div>
                  </div>
                  <div class="row">
                        @if(Auth::user()->privilege=='admin')
                           <a href="{{ route('products.edit',$p->id)}}" class="btn btn-primary">Edit</a>
                              <form action="{{ route('products.destroy', $p->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                 <button class="btn btn-danger" type="submit">Delete</button>
                              </form>
                                       
                        @endif
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
          @if(Auth::user()->privilege=='admin')
            <a href="/products/create">REGISTRAR NOVO</a><br>
          @endif
          {!! $produtos->links() !!}
          <button class="btn btn-primary">
            <a href="/pdf" class="text-white">PDF</a>
          </button>
          <button class="btn btn-primary ml-2" onclick="exportCsv();">
            CSV
          </button>
        </table>
      </div>
      <div class="col" id="choice">
            <label>FILTRO</label>
            <select onchange="handleChoice();" class="form-select" id="param1" aria-label="Default select example">
               <option selected>ESCOLHER</option>
               <option value="status">STATUS</option>
               <option value="id_categoria">CATEGORIA</option>
               <option value="id_subcategoria">SUBCATEGORIA</option>
            
             
            </select>
            <select class="form-select" id="param2" aria-label="Default select example">
               <!-- <option selected>ESCOLHER</option>
               <option value="ativo">ATIVO</option>
               <option value="inativo">INATIVO</option> -->
            </select>
            <button onclick="redirectFilter();">OK</button>
      </div>
      @if(Auth::user()->privilege=='admin')
        <button class="btn btn-primary">
          <a href="/products/destaques" class="text-white">DESTAQUES</a>
        </button>
        <button class="btn btn-primary">
          <a href="/products/importar" class="text-white">IMPORTAR CSV</a>
        </button>
      @endif
   </div>
<script>
function redirectFilter(){
   $url = window.location.href.split("?")[0];
   $param1 = document.getElementById("param1").value;
   $param2 = document.getElementById("param2").value;

   if($param1 !== 'ESCOLHER'){
     if($param1 !== '' && $param2 !== ''){
        window.location.href=$url+"/filter/"+$param1+"/"+$param2;
     }else{
       return;
     }
   }else{
     return;
   }
}
function handleChoice(){
  $choice = document.getElementById("param1").value;
  $div = document.getElementById("param2");

      if($choice == "status"){
            while ($div.length > 0) {
                  $div.remove(0);
            }
            var opt1 = document.createElement('option');
            opt1.value = "ativo";
            opt1.innerHTML = "ATIVOS";
            $div.appendChild(opt1);
            var opt2 = document.createElement('option');
            opt2.value = "inativo";
            opt2.innerHTML = "INATIVOS";
            $div.appendChild(opt2);
          
      }else if($choice == "id_categoria"){
        const url = fetch("http://carrefour.test/products/handleCriterion/"+$choice);
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
      }else if($choice == "id_subcategoria"){
        const url = fetch("http://carrefour.test/products/handleCriterion/"+$choice);
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
      }else{
        
              return;
                  
                
      }
  
  }
 function exportCsv(){
  const url = fetch("http://carrefour.test/staticCSV");
  url.then(r => r.json()).then(body => {
            const rows = body;
            let csvContent = "data:text/csv;charset=utf-8,";
            

              rows.forEach(function(rowArray) {
                  let row = rowArray.join(",");
                  csvContent += row + "\r\n";
              });
              var encodedUri = encodeURI(csvContent);
              var link = document.createElement("a");
              link.setAttribute("href", encodedUri);
              link.setAttribute("download", "produtos.csv");
              document.body.appendChild(link); // Required for FF

link.click(); // This will download the data file named "my_data.csv".


  });
}

</script>

@endsection


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
            <tr class="accordion-toggle collapsed" id="accordion1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">
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
                <div id="collapseOne" class="collapse in p-3">
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
                    <div class="col-6">{{strip_tags($p->descricao)}}</div>
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
          {{ $produtos->links() }}
          <a href="/products/create">REGISTRAR NOVO</a><br>
         
          <button class="btn btn-primary">
            <a href="/pdf/dinamic/{{$params[0]}}/{{$params[1]}}" class="text-white">PDF</a>
          </button>
          <button class="btn btn-primary ml-2" onclick="exportCsv('{{$params[0]}}','{{$params[1]}}');">
            CSV
          </button>
        </table>
        <button class="btn btn-primary ml-2">
            <a href="/products" class="text-white">VOLTAR</a>
          </button>
      </div>
   </div>
  
 <script>

  function exportCsv($param1,$param2){
  //console.log($param2);
    
  const url = fetch("http://carrefour.test/dinamicCSV/"+$param1+"/"+$param2);
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


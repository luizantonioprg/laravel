@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               <div class="col-sm-12 mt-2">
                  <div class="card-header ">CLASSIFICAR DESTAQUES</div>
                     <div class="card-body">
                       <label>DESTACAR</label>
                       <select onchange="maisDeUm()" name="destaques" id="destaques">
                          <option value="1">APENAS O PRIMEIRO</option>
                          <option value="2">OS 2 PRIMEIROS</option>
                          <option value="3">OS 3 PRIMEIROS</option>
                          <option value="4">OS 4 PRIMEIROS</option>
                          <option value="5">OS 5 PRIMEIROS</option>
                          <option value="6">OS 6 PRIMEIROS</option>
                          <option value="7">OS 7 PRIMEIROS</option>
                          <option value="8">OS 8 PRIMEIROS</option>
                          <option value="9">OS 9 PRIMEIROS</option>
                          <option value="10">OS 10 PRIMEIROS</option>
                        </select>
                        <span id="naSeguinteOrdem" >NA SEGUINTE ORDEM:</span>
            
                          <ul id="sortable" style="height:200px;overflow-y:scroll">
                            @foreach($produtos as $p)
                              <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$p->titulo}}
                              @if($p->id_destaque != NULL)
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>
                              </li>
                              @endif
                            @endforeach
                            
                          </ul>
                          <h4 class="lead" id="resultado"></h4>
                          <button onclick="registrarDestaques()" class="btn btn-primary">REGISTRAR</button>
                      </div>
                      
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>




  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
  <script>
    function maisDeUm(){
      $escolha = document.getElementById("destaques").value;
      if($escolha == 1){
        document.getElementById("naSeguinteOrdem").style.display = "none";
      }else{
        document.getElementById("naSeguinteOrdem").style.display = "inline";
      }
      
    }
    function registrarDestaques() {
    $lista = document.querySelectorAll(".ui-state-default");
    $quantidade = document.getElementById("destaques").value;
    $arr = [];
    if($lista.length < parseInt($quantidade)){
      alert('A quantidade selecionada é maior do que o número de produtos registrados');
      return;
    }else{
          for(i=0;i<$quantidade;i++){
            $arr.push($lista[i].outerText);
          }
          $arrToStr = $arr.toString();
          const url = fetch(
              "http://carrefour.test/products/destaques/inserir/" + $arrToStr
          );
          url.then(r => r.text()).then(body => {
              $resultado = body;
              document.getElementById("resultado").innerHTML = $resultado;
          });  
    } 
}
  </script>
@endsection

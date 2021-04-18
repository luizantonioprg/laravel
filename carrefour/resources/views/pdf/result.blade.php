<!DOCTYPE HTML>
<html>
  <head></head>
  <body>
    <table>
      <thead>
        <tr>
          <th>CODIGO</th>
          <th>CATEGORIA</th>
          <th>SUBCATEGORIA</th>
          <th>VALOR</th>
          <th>STATUS</th>
          <th>TAGS</th>
        </tr>
      </thead>
      <tbody>
          @FOREACH($products as $p)
            <tr>
              <td>{{$p->codigo}}</td>
              <td>{{$p->category->titulo}}</td>
              <td>{{$p->subcategory->titulo}}</td>
              <td>R${{number_format($p->valor, 2, ',', '.')}}</td>
              <td>{{$p->status}}</td>
              <td>{{$p->tag}}</td>
            </tr>
          @ENDFOREACH

      </tbody>
    </table>
  
  
  
  
  
  
  
  
  
  </body>



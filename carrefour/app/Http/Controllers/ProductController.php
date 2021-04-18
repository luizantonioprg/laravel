<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Category;
use App\SubCategory;
use App\Product;
use App\Destaques;
use Illuminate\Support\Facades\DB;
use Redirect;
use App\Exports\ProductsExport;
use App\Exports\ProductsExportStatic;
use Maatwebsite\Excel\Facades\Excel;
class ProductController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function __construct()
{
$this->middleware('auth');
}
public function index(Request $request)
{
// $produtos = Product::orderBy('codigo','asc')->paginate(1);
$produtos = Product::paginate(2);
//$produtos = Product::where('status', 'ativo')->paginate(1);
$categorias = Category::all();
$subcategorias = SubCategory::all();
return view('products/home',compact('produtos','categorias','subcategorias'));   
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
//
$categories = Category::all(); 
$subcategories = SubCategory::all(); 
return view('products/create', compact('categories','subcategories')); 
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
//
// if($request->hasFile('imagem')){
//     $fileNameWithExt = $request->file('imagem')->getClientOriginalName();
//     $fileNameWithExt = str_replace(" ", "_", $fileNameWithExt);
//     $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
//     $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
//     $filename = urlencode($filename);
//     $extension = $request->file('imagem')->getClientOriginalExtension();
//     //$fileNameToStore = $filename.'_'.time().'.'.$extension;
//     $fileNameToStore = $filename.'.'.$extension;
//     $path = $request->file('imagem')->storeAs('public/',$fileNameToStore);
//     //return $fileNameToStore;
// }
$chave_secreta='6LfxpKQaAAAAABnkmpSLKWP2umnto1-6OU4l0bDn';
$captcha_data=$request->get('g-recaptcha-response');
$resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$chave_secreta&response=$captcha_data");
$toObj = json_decode($resposta);
// echo $resposta;
if($toObj->success=="true"){
//echo 'acertou';
$request->validate([
'codigo'=>'required|integer|unique:categories,codigo',
'titulo'=>'required|string|unique:products,titulo',
'id_categoria'=>'required|integer',
'id_subcategoria'=>'required|integer',
'primeiraImagem'=>'image|mimes:jpeg,png,jpg,gif,svg',
'imagem'=>'max:50000',
'descricao'=>'required|string',
'valor'=>'required',
'tags'=>'required|string',
'status'=>['required', 'regex:(ativo|inativo)'],
]);
$val = str_replace(",",".",$request->get('valor'));
$val = preg_replace('/\.(?=.*\.)/', '', $val);
$arr =  explode(',', $request->get('tags'));
if(sizeof($arr)< 3){
return Redirect::back()->withErrors(['Insira 3 tags para o produto']);
}
$produto = new Product([
'codigo' => $request->get('codigo'),
'titulo' => $request->get('titulo'),
'id_categoria' => $request->get('id_categoria'),
'id_subcategoria' => $request->get('id_subcategoria'),
'imagem' => $request->get('imagem'),
'descricao' => $request->get('descricao'),
'valor' => floatval($val),
'tag' => $request->get('tags'),
'status' => $request->get('status'),
]);
// email data
$email_data = array(
'name' => 'dwdawa',
'email' => 'kbrdesafio@gmail.com',
);
// send email with the template
Mail::send([], $email_data, function ($message) use ($email_data) {
$message->to($email_data['email'], $email_data['name'])
->subject('Welcome to MyNotePaper')
->from('kbrdesafio@gmail.com', 'MyNotePaper');
});
$produto->save();
return redirect('/products')->with('success', 'Product saved!');
}else{
return 'O captcha expirou,rapaz.';
}
}
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
//
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
//
$productId = Product::find($id);
$categories = Category::all();
$tagsArr = explode(',', $productId->tag);;
return view('products/edit',compact('productId','categories','tagsArr'));  
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
//
$request->validate([
'codigo'=>'required|integer|unique:categories,codigo',
'titulo'=>'required|string',
'id_categoria'=>'required|integer',
'id_subcategoria'=>'required|integer',
'primeiraImagem'=>'image|mimes:jpeg,png,jpg,gif,svg',
'imagem'=>'max:50000',
'descricao'=>'required|string',
'valor'=>'required',
'tags'=>'required|string',
'status'=>['required', 'regex:(ativo|inativo)'],
]);
$val = str_replace(",",".",$request->get('valor'));
$val = preg_replace('/\.(?=.*\.)/', '', $val);
$arr =  explode(',', $request->get('tags'));
if(sizeof($arr)< 3){
return Redirect::back()->withErrors(['Insira 3 tags para o produto']);
}
$produto = Product::find($id);
$produto->codigo =  $request->get('codigo');
$produto->titulo = $request->get('titulo');
$produto->id_categoria =  $request->get('id_categoria');
$produto->id_subcategoria = $request->get('id_subcategoria');
// $produto->primeiraImagem =  $request->get('primeiraImagem');
$produto->imagem = $request->get('imagem');
$produto->descricao = $request->get('descricao');
// $produto->descricao =  $request->get('descricao');
$produto->valor = floatval($val);
$produto->tag =  $request->get('tags');
$produto->status = $request->get('status');
$produto->save();
return redirect('/products')->with('success', 'Product updated!');
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
//
$produto = Product::find($id);
$produto->delete();
return redirect('/products')->with('success', 'Product deleted!');
}
// public function filtrar($crit){
//     if($crit == 'pizzas'){
//         $categorias = Category::all();
//         $subcategorias = SubCategory::all();
//         //$produtos = Product::where('status', 'inativo')->get();
//         return view('products/novaView',compact('produtos','categorias','subcategorias'));
//     }else{
//         return 'no';       
//     }
// }
public function filter($param1,$param2){
$params = array($param1,$param2);
//$produtos = Product::where($param1, $param2)->get();
$produtos = Product::where($param1, $param2)->paginate(2);
return view('products/filtered',compact('produtos','params'));
}
public function retrieveSubcategories($id_categoria){
$subcategorias = SubCategory::where('id_categoria', $id_categoria)->get();
$a = array();
foreach($subcategorias as $o){
{
$a[] =  array($o->id,$o->titulo);
}
}
return $a;
}
public function handleCriterion($criterion){
$a = array();
if($criterion=="id_categoria"){
$categorias = Category::all();
foreach($categorias as $c){
$a[] =  array($c->id,$c->titulo);
}
return $a;
}else if($criterion=="id_subcategoria"){
$subcategorias = SubCategory::all();
foreach($subcategorias as $sc){
$a[] =  array($sc->id,$sc->titulo);
}
return $a;
}
}
public function staticCSV(){
$produtos = Product::all();
$a=array(["CODIGO","TITULO","CATEGORIA","SUBCATEGORIA","DESCRICAO","IMAGEM","VALOR","TAGS","STATUS"]);
foreach($produtos as $p){
$a[]=array($p->codigo,$p->titulo,$p->category->titulo,$p->subcategory->titulo,$p->descricao,$p->imagem,$p->valor,$p->tag,$p->status);
}
return $a;      
}
public function dinamicCSV($param1,$param2){
$produtos = Product::where($param1, $param2)->get();
$a=array(["CODIGO","TITULO","CATEGORIA","SUBCATEGORIA","DESCRICAO","IMAGEM","VALOR","TAGS","STATUS"]);
foreach($produtos as $p){
$a[]=array($p->codigo,$p->titulo,$p->category->titulo,$p->subcategory->titulo,$p->descricao,$p->imagem,$p->valor,$p->tag,$p->status);
}
return $a;   
}
public function indexDestaques(){
$produtos = Product::where('status', 'ativo')->orderByRaw('-id_destaque DESC')->get();
return view('products/destaques/home',compact('produtos')); 
}
    public function inserirDestaques($str){
        $strToArr = explode(',',$str);
        Product::query()->update(['id_destaque' => NULL]);


        foreach ($strToArr as $key => $n){
            Product::where('titulo',$n)->update(['id_destaque'=>$key+1]);
    }
  
    return 'Registrado. Atualize a página.';
}
public function indexImportar(){
$categories = Category::all();
return view('import/home',compact('categories'));
}
    public function inserirCSV(Request $request){
        $id_categoria = $request->get('id_categoria');
        $id_subcategoria = $request->get('id_subcategoria');

        if(isset($_POST['importSubmit'])){
            $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

            if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
                if(is_uploaded_file($_FILES['file']['tmp_name'])){
                    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                    fgetcsv($csvFile);

                    while(($line = fgetcsv($csvFile)) !== FALSE){
                        if(Product::where('codigo', $line[0])->first()){
                            return redirect('/products/importar')->with('success', 'Produto ja existe!');
                        }else{
                        $produto = new Product([
                                'codigo' => $line[0],
                                'titulo' => $line[1],
                                'id_categoria' => $request->get('id_categoria'),
                                'id_subcategoria' => $request->get('id_subcategoria'),
                                'imagem' => $line[2],
                                'descricao' => $line[3],
                                'valor' => number_format(floatval($line[4]), 2),
                                'tag' => $line[5],
                                'status' =>$line[6] ,
                            ]);
                                $produto->save();
                       
                        
                        }
                    }
                         return redirect('/products/importar')->with('success', 'Importado com sucesso');
                }
            }

        }
    }
}

 
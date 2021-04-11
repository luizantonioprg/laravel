<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Category;
use App\SubCategory;
use App\Product;


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
    public function index()
    {
        //
        return view('products/home');  
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
            if($toObj->success){
                //echo 'acertou';
                $request->validate([
                    'codigo'=>'required',
                    'titulo'=>'required',
                    'id_categoria'=>'required',
                    'id_subcategoria'=>'required',
                    'imagem'=>'required',
                    'descricao'=>'required',
                    'valor'=>'required',
                    'tags'=>'required',
                    'status'=>'required',
                

                ]);
                $produto = new Product([
                    'codigo' => $request->get('codigo'),
                    'titulo' => $request->get('titulo'),
                    'id_categoria' => $request->get('id_categoria'),
                    'id_subcategoria' => $request->get('id_subcategoria'),
                    'imagem' => $request->get('imagem'),
                    'descricao' => strip_tags($request->get('descricao')),
                    'valor' => (double)$request->get('valor'),
                    'tag' => $request->get('tags'),
                    'status' => $request->get('status'),
                ]);

                
    // // email data
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
            
                return 'ok';
            }else{
                return 'errou o captcha rapaz';
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
    }
}

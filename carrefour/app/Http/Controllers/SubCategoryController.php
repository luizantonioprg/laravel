<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use App\Category;
class SubCategoryController extends Controller
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
        $subCategories = SubCategory::all();        
        return view('subcategories/home',compact('subCategories'));  
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //subCategories
        $categories = Category::all();  
        return view('subcategories/create', compact('categories'));  
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
        $request->validate([
            'codigo'=>'required|integer|unique:sub_categories,codigo',
            'titulo'=>'required|alpha',
            'id_categoria'=>'integer'
        ]);

        $subcategory = new SubCategory([
            'codigo' => $request->get('codigo'),
            'titulo' => $request->get('titulo'),
            'id_categoria' => $request->get('id_categoria'),
        ]);
        $subcategory->save();
        return redirect('/subcategories')->with('success', 'SubCategory saved!');

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
        $subcategory = SubCategory::find($id);
        $categories = Category::all(); 
        return view('subcategories.edit', compact('subcategory','categories'));  
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
            'codigo'=>'required|integer',
            'titulo'=>'required|alpha',
            'id_categoria'=>'integer'
        ]);
        $subcategory = SubCategory::find($id);
        $subcategory->codigo =  $request->get('codigo');
        $subcategory->titulo = $request->get('titulo');
        $subcategory->id_categoria = $request->get('id_categoria');
        $subcategory->save();
        return redirect('/subcategories')->with('success', 'Subcategorie updated!');
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
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        return redirect('/subcategories')->with('success', 'SubCategory deleted!');
    }
}

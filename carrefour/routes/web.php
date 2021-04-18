<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


// Route::get('/import', 'ImportController@index'); // localhost:8000/
// Route::post('/import/uploadFile', 'ImportController@uploadFile');
Route::get('/products/importar', 'ProductController@indexImportar');
Route::post('/products/importar/inserir', 'ProductController@inserirCSV');
Route::get('/products/destaques', 'ProductController@indexDestaques');
Route::get('/products/destaques/inserir/{arr}', 'ProductController@inserirDestaques')->name('products.inserirDestaques');
Route::get('/dinamicCSV/{param1}/{param2}', 'ProductController@dinamicCSV');
Route::get('/products/filter/{categoria?}/{subcategoria?}', 'ProductController@filter');
Route::get('/products/handleCriterion/{criterion}', 'ProductController@handleCriterion');
Route::get('/products/retrieveSubcategories/{id_categoria}', 'ProductController@retrieveSubcategories');
Route::get('/pdf','PDF\ExportPDF@generate');
Route::get('/pdf/dinamic/{categoria}/{subcategoria}','PDF\ExportPDF@generateDinamic');
Route::resource('/users', 'HomeController');
Route::resource('/categories', 'CategoryController');
Route::resource('/subcategories', 'SubCategoryController');
Route::resource('/products', 'ProductController');

//Route::get('/users/$id', 'HomeController@edit')->name('users.edit');

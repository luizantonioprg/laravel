<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $User = User::all();
        return view('home', compact('User'));

    }
    public function edit($id)
    {
        
        $UserId = User::find($id);
        return view('users/edit', ['User'=>$UserId]);     
           
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'nome'=>['required', 'regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/'],
            'email'=>'required|email'
        ]);
        $user = User::find($id);
        $user->name =  $request->get('nome');
        $user->email = $request->get('email');
        $user->save();
        return redirect('/users')->with('success', 'Contact updated!');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/home')->with('success', 'Contact deleted!');
    }
    public function create(){
        return view('users/create');
    }
}

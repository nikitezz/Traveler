<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = new User();
        $user = User::all();
        return view('User.create', compact([
            'user',
        ]));
    }
    public function store(Request $request){
        $request->validate([
           'name'=>'required',
           'email'=>'required|email|unique:users',
           'phone'=>'required|numeric',
           'password'=>'required|min:8'
        ]);
        $user = User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'password'=>Hash::make($request->input('password')),
        ]);
        Auth::login($user);
        return redirect(route('home'));
    }
    public function loginForm(){
        return view('User.login');
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8'
        ]);
        if (auth()->attempt([
            'email'=>$request->input('email'),
            'password'=>$request->input('password')
        ])){
            return redirect(route('home'));
        }
        return redirect()->back();
    }
    public function logout(){
        Auth::logout();
        return redirect(route('home'));
    }
    public function profile(){
        $users = new User();
        $user = User::all();
        return view('User.index',compact([
            'user'
        ]));
    }
    public function edit($id){
        $user = User::findOrFail($id);
        return view('users.edit',compact('user'));
    }
    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect('home')->with('success','True');
    }
}

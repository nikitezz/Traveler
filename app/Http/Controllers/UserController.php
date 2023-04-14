<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('User.create');
    }
    public function store(Request $request){
        $request->validate([
           'name'=>'required',
           'email'=>'required|email',
           'password'=>'required|min:8'
        ]);
        $user = User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
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
        return view('User.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('auth.Login');
    }
    public function register(){
        return view('auth.Register');
    }

    public function registerPost(Request $req){
        $req->validate([
            "name" => "required|max:30|min:3|string|",
            "email" => "required|unique:users|email",
            "password" => "required|max:30|min:3|confirmed|string",
            "profile_picture" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);
        $imagePath = null ;
        if($req->hasFile('profile_picture')){
            $imagePath = $req->file('profile_picture')->store('profiles','public') ;
        }

        $user = new User();

        $user->name = $req->name ;
        $user->email = $req->email ;
        $user->password = bcrypt($req->password);
        $user->image_path = $imagePath ;
        $user->save();


        return redirect()->route('login')->with('success', 'Account created successfully!');
    }

    public function loginPost(Request $req){

        $info = $req->only('email',"password") ;

        if(Auth::attempt($info)){
            $req->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => "Email Or Password Does Not Match !"
        ])->withInput();

    }

    public function logout(Request $req){

        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('login')->with('success',"yopu have Logged out successfully");
    }

}

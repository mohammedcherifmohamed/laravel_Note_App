<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function loadNotes(){
        return view('home');
    }
    public function AddNot(){
        return "view('home')";
    }
}

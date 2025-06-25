<?php

namespace App\Http\Controllers;
use App\Models\Notes;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function loadNotes(){
        $notes = Notes::where('user_id',Auth::id())->get();
        return view('home',compact('notes'));
    }

    public function AddNot(Request $req){
        
        $req->validate([
            "title" => "required|min:3|max:255" ,
            "description" => "required|min:5|max:255",
            "note_color" => "required",
        ]);

        $note = new Notes();
        $note->title = $req->title;
        $note->description = $req->description ;
        $note->color = $req->note_color;
        $note->user_id = Auth::id();
        $result = $note->save();
        if($result){
            return redirect()->back()->with('success', 'Note saved successfully!');
        }else{
            return redirect()->back()->with('error', 'Failed To save Note!');
        }
    }

    public function editPost(Request $req){

        dd($req->id);
        return  ;

    }
    public function edit(Request $req){

        dd($req->note_id);
        return  ;

    }
}

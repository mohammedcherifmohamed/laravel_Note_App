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

    public function editPost(Request $req , $id){
    
        $note = Notes::where('id',$req->note_id)
                     ->where('user_id',Auth::id())
                     ->first();

        // dd($note );

        $req->validate([
            "title" => "required|min:3|max:255" ,
            "description" => "required|min:3|max:255" ,
        ]);

        $res = $note->update([
            'title' => $req->title , 
            'description' => $req->description , 
            'color' => $req->note_color , 
        ]);



        if($res)
             return redirect()->route('home')->with('success', 'Note updated successfully!');
        else
         return redirect()->back();


        return  ;

    }

    public function edit(Request $req){
        $noteId = $req->note_id ;

        $note = Notes::findOrFail($noteId);
        return  view("EditNote",compact("note")) ;

    }


    public function delete(Request $req ){
        $note = Notes::where('id',$req->note_id)
                ->where('user_id',Auth::id())
                ->first();
         if (!$note) {
        return redirect()->back()->with('error', 'Note not found or unauthorized.');
     }

    $note->delete();

    return redirect()->back()->with('success', 'Note deleted successfully.');

    }
}

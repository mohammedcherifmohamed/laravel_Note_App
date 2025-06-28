<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController ;
use App\Http\Controllers\NotesController;

Route::get('/',[AuthController::class,'login'])->name("login") ;

Route::get('/home',[NotesController::class,'loadNotes'])->name("home") ;

Route::get('/register',[AuthController::class,'register'])->name("register") ;

Route::post('/registerPost',[AuthController::class,'registerPost'])->name("registerPost") ;

Route::post('/loginPost',[AuthController::class,'loginPost'])->name("loginPost") ;

Route::post('/logout',[AuthController::class,'logout'])->name("logout") ;

Route::post('/AddNot',[NotesController::class,'AddNot'])->name("AddNot") ;

Route::patch('/editPost/{id}',[NotesController::class,'editPost'])->name("editPost") ;

Route::get('/edit',[NotesController::class,'edit'])->name("edit") ;

Route::post('/edit/{id}',[NotesController::class,'editPost'])->name("editPost") ;

Route::post('/delete',[NotesController::class,'delete'])->name("delete") ;



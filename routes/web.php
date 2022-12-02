<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
Route::middleware('IsGuest')->group(function() {
Route::get('/', [TodoController::class, 'login']);
Route::get('/register', [TodoController::class, 'register']);
Route::post('/register/input', [TodoController::class, 'registerAccount']);
Route::get('/login', [TodoController::class, 'login']);
Route::post('/register/input', [TodoController::class, 'registerAccount'])->name('register.input');
Route::post('/login/auth', [TodoController::class, 'auth'])->name('login.auth');
});
//logout
Route::get('/logout', [TodoController::class, 'logout'])->name('logout');
//todo
Route::middleware('IsLogin')->group(function() {
Route::prefix('/todo')->name('todo.')->group(function (){
    Route::get('/', [TodoController::class, 'index'])->name('index');
    Route::get('/complated', [TodoController::class, 'complated'])->name('complated');
    Route::get('/create', [TodoController::class, 'create'])->name('create');
    Route::post('/store', [TodoController::class, 'store'])->name('store');
    // router path yang menggunakan { } berarti dia berperan sebagai parameter route
    // parameter ini bentukanya data dinamis (daya yang dikirim ke router untuk diambil di parameter function controller terkait) 
    Route::get('/edit/{id}', [TodoController::class, 'edit'])->name('edit');
    // method route untuk ubah data di DB itu patch/put
    Route::patch('/update/{id}', [TodoController::class,'update'])->name('update');
    // method route untuk hapus data di db itu delete
    Route::delete('/delete/{id}', [TodoController::class,'destroy'])->name('delete');
    Route::patch('/complated/{id}', [TodoController::class,'updateComplated'])->name('update-complated');
});
});
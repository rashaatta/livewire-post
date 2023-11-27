<?php

use App\Livewire\CreatePost;
use App\Livewire\EditPost;
use App\Livewire\Posts;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/posts','App\Http\Controllers\PostsController');

Route::get('livewire/posts' ,   Posts::class);
Route::get('/livewire/posts/create' ,    CreatePost::class);
Route::get('/livewire/posts/{id}' ,     \App\Livewire\ShowPost::class);
Route::get('/livewire/posts/{id}/edit' ,     EditPost::class);

//step 2
Route::get('/dynamic/posts' ,     \App\Livewire\Dynamic\Posts::class);

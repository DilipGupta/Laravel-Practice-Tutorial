<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::view('/','welcome')->name('home');
Route::get('/','HomeController@home')->name('home');

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::view('/contact','/contact')->name('contact');
Route::get('/contact','HomeController@contact')->name('contact');

// Route::get('/contact', function () {
//     return view('contact');
// });

// Route::get('/blog-post/{id}/{welcome?}', 'HomeController@blogpost')->name('blog-post');

// Route::get('/blog-post/{id}/{welcome?}', function ($id, $welcome){
//   $pages= [
//       1=>[
//           'title'=>'Hello From Page 1'
//       ],
//       2=>[
//           'title'=>'Hello From Page 2'
//       ]
//     ];
//     return view('blog-post',[
//         'data'=>$pages[$id]
//     ]);

// });

Route::resource('/posts','PostController');

Route::get('/home', 'HomeController@home')->name('home');

Route::get('/secret','HomeController@secret')->name('secret')->middleware('can:home.secret');

Auth::routes();


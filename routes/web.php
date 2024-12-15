<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontendController;

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

// Route::get('/', function () {
//     return view('frontend.home.index');
// });

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/faqs', 'faqs')->name('faqs');
    Route::get('/services', 'services')->name('services');
    Route::get('/service-details', 'serviceDetails')->name('serviceDetails');
    Route::get('/departments', 'department')->name('department');
    Route::get('/departments-details', 'departmentDetails')->name('departmentDetails');
    Route::get('/doctors', 'doctors')->name('doctors');
    Route::get('/doctors-details', 'doctorsDetails')->name('doctorsDetails');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog-details', 'blogDetails')->name('blogDetails');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use App\Http\Controllers\Backend\AppointmentController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\Backend\PatientController;
use App\Http\Controllers\HomeController;
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

Route::controller(HomeController::class)->group(function () {
    Route::get('/admin', 'admin')->name('admin');
});

Route::controller(AppointmentController ::class)->group(function () {
    Route::get('/appointment', 'index')->name('appointment');
    Route::get('/appointment/create', 'create')->name('appointment.create');
    Route::post('/appointment', 'store')->name('appointment.store');
    Route::get('/appointment/{id}/edit', 'edit')->name('appointment.edit');
    Route::put('/appointment/{id}', 'update')->name('appointment.update');
    Route::delete('/appointment/{id}', 'destroy')->name('appointment.destroy');
});

Route::controller(DoctorController ::class)->group(function () {
    Route::get('/doctors', 'index')->name('doctors');
    Route::get('/doctors/create', 'create')->name('doctors.create');
    Route::post('/doctors', 'store')->name('doctors.store');
    Route::get('/doctors/{id}/edit', 'edit')->name('doctors.edit');
    Route::put('/doctors/{id}', 'update')->name('doctors.update');
    Route::delete('/doctors/{id}', 'destroy')->name('doctors.destroy');
});

Route::controller(PatientController ::class)->group(function () {
    Route::get('/patients', 'index')->name('patients');
    Route::get('/patients/create', 'create')->name('patients.create');
    Route::post('/patients', 'store')->name('patients.store');
    Route::get('/patients/{id}/edit', 'edit')->name('patients.edit');
    Route::put('/patients/{id}', 'update')->name('patients.update');
    Route::delete('/patients/{id}', 'destroy')->name('patients.destroy');
});

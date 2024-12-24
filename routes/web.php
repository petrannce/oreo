<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Backend\AppointmentController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\Backend\PatientController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\FaqController;


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
    Route::get('/subscribers', 'subscribers')->name('subscribers');
    Route::delete('/subscribers/{id}', 'subscribersDestroy')->name('subscribers.destroy');
});

//FAQs
Route::controller(FaqController::class)->group(function () {
    Route::get('/faqs', 'index')->name('faqs');
    Route::get('/faqs/create', 'create')->name('faqs.create');
    Route::post('/faqs', 'store')->name('faqs.store');
    Route::get('/faqs/{id}/edit', 'edit')->name('faqs.edit');
    Route::put('/faqs/{id}', 'update')->name('faqs.update');
    Route::delete('/faqs/{id}', 'destroy')->name('faqs.destroy');
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

Route::controller(DepartmentController ::class)->prefix('admin')->group(function () {
    Route::get('/departments', 'index')->name('departments');
    Route::get('/departments/create', 'create')->name('departments.create');
    Route::post('/departments', 'store')->name('departments.store');
    Route::get('/departments/{id}/edit', 'edit')->name('departments.edit');
    Route::put('/departments/{id}', 'update')->name('departments.update');
    Route::delete('/departments/{id}', 'destroy')->name('departments.destroy');
});

Route::controller(BlogController ::class)->group(function () {
    Route::get('/blogs', 'index')->name('blogs');
    Route::get('/blogs/create', 'create')->name('blogs.create');
    Route::post('/blogs', 'store')->name('blogs.store');
    Route::get('/blogs/{id}/edit', 'edit')->name('blogs.edit');
    Route::put('/blogs/{id}', 'update')->name('blogs.update');
    Route::delete('/blogs/{id}', 'destroy')->name('blogs.destroy');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users');
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{id}/edit', 'edit')->name('users.edit');
    Route::put('/users/{id}', 'update')->name('users.update');
    Route::delete('/users/{id}', 'destroy')->name('users.destroy');
});



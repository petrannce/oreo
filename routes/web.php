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
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\ResourceController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\ReceptionistController;

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
    Route::get('/about-us', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactStore')->name('contact.store');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/faqs', 'faqs')->name('faq');
    Route::get('/services', 'services')->name('services');
    Route::get('service-details/{id}', 'serviceDetails')->name('serviceDetails');
    Route::get('/departments', 'department')->name('department');
    Route::get('/departments-details/{id}', 'departmentDetails')->name('departmentDetails');
    Route::get('/doctors', 'doctors')->name('doctors');
    Route::get('/doctors-details', 'doctorsDetails')->name('doctorsDetails');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog-details/{id}', 'blogDetails')->name('blogDetails');
    Route::get('/subscribers', 'subscriber')->name('subscriber');
    Route::post('/subscribers', 'subscriberStore')->name('subscriber.store');
    Route::post('/appointment', 'appointment')->name('appointment.store');
});

Auth::routes();

Route::controller(HomeController::class)->group(function () {
    Route::get('/dashboard/admin', 'admin')->name('admin');
    Route::get('/dashboard/doctors', 'doctors')->name('dashboard.doctors');
    Route::get('/dashboard/receptionists', 'receptionists')->name('dashboard.receptionists');
    Route::get('/dashboard/patients', 'patients')->name('dashboard.patients');
    Route::get('/subscribers', 'subscribers')->name('subscribers');
    Route::delete('/subscribers/{id}', 'subscribersDestroy')->name('subscribers.destroy');
});

//FAQs
Route::controller(FaqController::class)->prefix('admin')->group(function () {
    Route::get('/faqs', 'index')->name('faqs');
    Route::get('/faqs/create', 'create')->name('faqs.create');
    Route::post('/faqs', 'store')->name('faqs.store');
    Route::get('/faqs/{id}/edit', 'edit')->name('faqs.edit');
    Route::put('/faqs/{id}', 'update')->name('faqs.update');
    Route::delete('/faqs/{id}', 'destroy')->name('faqs.destroy');
});

//gallery
Route::controller(GalleryController::class)->prefix('admin')->group(function () {
    Route::get('/gallery', 'index')->name('galleries.index');
    Route::get('/gallery/create', 'create')->name('gallery.create');
    Route::post('/gallery', 'store')->name('galleries.store');
    Route::get('/gallery/{id}/edit', 'edit')->name('galleries.edit');
    Route::put('/gallery/{id}', 'update')->name('galleries.update');
    Route::delete('/gallery/{id}', 'destroy')->name('galleries.destroy');
});

Route::controller(AppointmentController::class)->prefix('admin')->group(function () {
    Route::get('/appointment', 'index')->name('appointments.index');
    Route::get('/appointment/create', 'create')->name('appointments.create');
    Route::post('/appointment', 'store')->name('appointments.store');
    Route::get('/appointment/{id}/edit', 'edit')->name('appointments.edit');
    Route::put('/appointment/{id}', 'update')->name('appointments.update');
    Route::delete('/appointment/{id}', 'destroy')->name('appointments.destroy');
});

//services
Route::controller(ServiceController::class)->prefix('admin')->group(function () {
    Route::get('/services', 'index')->name('services.index');
    Route::get('/services/create', 'create')->name('services.create');
    Route::post('/services', 'store')->name('services.store');
    Route::get('/services/{id}/edit', 'edit')->name('services.edit');
    Route::put('/services/{id}', 'update')->name('services.update');
    Route::delete('/services/{id}', 'destroy')->name('services.destroy');
});

//Doctors
Route::controller(DoctorController::class)->prefix('admin')->group(function () {
    Route::get('/doctors', 'index')->name('doctors.index');
    Route::get('/doctors/create', 'create')->name('doctors.create');
    Route::post('/doctors', 'store')->name('doctors.store');
    Route::get('/doctors/{id}/edit', 'edit')->name('doctors.edit');
    Route::put('/doctors/{id}', 'update')->name('doctors.update');
    Route::delete('/doctors/{id}', 'destroy')->name('doctors.destroy');
    Route::get('/doctors/{id}/profile', 'profile')->name('doctors.profile');
    Route::put('/doctors/{id}/profile', 'updateProfile')->name('updateProfile');
});

Route::controller(PatientController::class)->group(function () {
    Route::get('/patients', 'index')->name('patients');
    Route::get('/patients/create', 'create')->name('patient.create');
    Route::post('/patients', 'store')->name('patients.store');
    Route::get('/patients/{id}/edit', 'edit')->name('patients.edit');
    Route::put('/patients/{id}', 'update')->name('patients.update');
    Route::delete('/patients/{id}', 'destroy')->name('patients.destroy');
});

//Receptionists
Route::controller(ReceptionistController::class)->prefix('admin')->group(function () {
    Route::get('/receptionists', 'index')->name('receptionists');
    Route::get('/receptionists/create', 'create')->name('receptionist.create');
    Route::post('/receptionists', 'store')->name('receptionists.store');
    Route::get('/receptionists/{id}/edit', 'edit')->name('receptionists.edit');
    Route::put('/receptionists/{id}', 'update')->name('receptionists.update');
    Route::delete('/receptionists/{id}', 'destroy')->name('receptionists.destroy');
});

Route::controller(DepartmentController::class)->prefix('admin')->group(function () {
    Route::get('/departments', 'index')->name('departments');
    Route::get('/departments/create', 'create')->name('departments.create');
    Route::post('/departments', 'store')->name('departments.store');
    Route::get('/departments/{id}/edit', 'edit')->name('departments.edit');
    Route::put('/departments/{id}', 'update')->name('departments.update');
    Route::delete('/departments/{id}', 'destroy')->name('departments.destroy');
});

//Tags
Route::controller(TagController::class)->group(function () {
    Route::get('/tags', 'index')->name('tags');
    Route::get('/tags/create', 'create')->name('tags.create');
    Route::post('/tags', 'store')->name('tags.store');
    Route::get('/tags/{id}/edit', 'edit')->name('tags.edit');
    Route::put('/tags/{id}', 'update')->name('tags.update');
    Route::delete('/tags/{id}', 'destroy')->name('tags.destroy');
});

Route::controller(BlogController::class)->group(function () {
    Route::get('/blogs', 'index')->name('blogs');
    Route::get('/blogs/create', 'create')->name('blogs.create');
    Route::post('/blogs', 'store')->name('blogs.store');
    Route::get('/blogs/{id}/edit', 'edit')->name('blogs.edit');
    Route::put('/blogs/{id}', 'update')->name('blogs.update');
    Route::delete('/blogs/{id}', 'destroy')->name('blogs.destroy');
});

Route::controller(ResourceController::class)->group(function () {
    Route::get('/resources', 'index')->name('resources');
    Route::get('/resources/create', 'create')->name('resources.create');
    Route::post('/resources', 'store')->name('resources.store');
    Route::get('/resources/{id}/edit', 'edit')->name('resources.edit');
    Route::put('/resources/{id}', 'update')->name('resources.update');
    Route::delete('/resources/{id}', 'destroy')->name('resources.destroy');

});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users');
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{id}/edit', 'edit')->name('users.edit');
    Route::put('/users/{id}', 'update')->name('users.update');
    Route::delete('/users/{id}', 'destroy')->name('users.destroy');
});




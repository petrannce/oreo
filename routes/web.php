<?php

use App\Http\Controllers\backend\BillingController;
use App\Http\Controllers\backend\LabTechnicianController;
use App\Http\Controllers\backend\LabTestController;
use App\Http\Controllers\Backend\NurseController;
use App\Http\Controllers\backend\PharmacyOrderController;
use App\Http\Controllers\backend\PharmacyOrderItemController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\backend\TriageController;
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
use App\Http\Controllers\Backend\MedicalController;

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

//Dashboard
Route::middleware(['auth', 'role.records'])->controller(HomeController::class)->group(function () {
    Route::get('/dashboard/admin', 'admin')->name('admin');
    Route::get('/dashboard/doctors', 'doctors')->name('dashboard.doctors');
    Route::get('/dashboard/receptionists', 'receptionists')->name('dashboard.receptionists');
    Route::get('/dashboard/patients', 'patients')->name('dashboard.patients');
    Route::get('/dashboard/nurses', 'nurses')->name('dashboard.nurses');
    Route::get('/dashboard/pharmacist', 'pharmacists')->name('dashboard.pharmacist');
    Route::get('/dashboard/lab_technicians', 'lab_technicians')->name('dashboard.lab_technicians');
    Route::get('/subscribers', 'subscribers')->name('subscribers');
    Route::delete('/subscribers/{id}', 'subscribersDestroy')->name('subscribers.destroy');
});

// Report
Route::get('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');


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

//appointments
Route::middleware(['auth', 'role.records'])->controller(AppointmentController::class)->prefix('admin')->group(function () {
    Route::get('/appointment', 'index')->name('appointments');
    Route::get('/appointment/create', 'create')->name('appointments.create');
    Route::post('/appointment', 'store')->name('appointments.store');
    Route::get('/appointment/{id}/edit', 'edit')->name('appointments.edit');
    Route::put('/appointment/{id}', 'update')->name('appointments.update');
    Route::get('/appointment/{id}', 'show')->name('appointments.show');
    Route::delete('/appointment/{id}', 'destroy')->name('appointments.destroy');
    Route::get('/appointment/update-status/{id}/{status}', 'updateStatus')->name('appointment.updateStatus');
    Route::get('/appointments/update-stage/{id}/{stage}', 'updateStage')->name('appointment.updateStage');
    Route::get('/appointment-report', 'report')->name('appointments.report');
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
Route::middleware(['auth', 'role.records'])->controller(DoctorController::class)->prefix('admin')->group(function () {
    Route::get('/doctors', 'index')->name('doctors.index');
    Route::get('/doctors/create', 'create')->name('doctors.create');
    Route::post('/doctors', 'store')->name('doctors.store');
    Route::get('/doctors/{id}/edit', 'edit')->name('doctors.edit');
    Route::put('/doctors/{id}', 'update')->name('doctors.update');
    Route::delete('/doctors/{id}', 'destroy')->name('doctors.destroy');
    Route::get('/doctors/{id}/profile', 'profile')->name('doctors.profile');
    Route::put('/doctors/{id}/profile', 'updateProfile')->name('updateProfile');
});

//nurses
Route::middleware(['auth', 'role.records'])->controller(NurseController::class)->prefix('admin')->group(function () {
    Route::get('/nurses', 'index')->name('nurses');
    Route::get('/nurses/create', 'create')->name('nurses.create');
    Route::post('/nurses', 'store')->name('nurses.store');
    Route::get('/nurses/{id}/edit', 'edit')->name('nurses.edit');
    Route::put('/nurses/{id}', 'update')->name('nurses.update');
    Route::delete('/nurses/{id}', 'destroy')->name('nurses.destroy');
});

// Lab technicians
Route::middleware(['auth', 'role.records'])->controller(LabTechnicianController::class)->prefix('admin')->group(function () {
    Route::get('/lab-technicians', 'index')->name('lab_technicians');
    Route::get('/lab-technicians/create', 'create')->name('lab_technicians.create');
    Route::post('/lab-technicians', 'store')->name('lab_technicians.store');
    Route::get('/lab-technicians/{id}/edit', 'edit')->name('lab_technicians.edit');
    Route::put('/lab-technicians/{id}', 'update')->name('lab_technicians.update');
    Route::delete('/lab-technicians/{id}', 'destroy')->name('lab_technicians.destroy');
});

// Lab Tests
Route::middleware(['auth', 'role.records'])->controller(LabTestController::class)->prefix('admin')->group(function () {
    Route::get('/lab-tests', 'index')->name('lab_tests');
    Route::get('/lab-tests/create', 'create')->name('lab_tests.create');
    Route::post('/lab-tests', 'store')->name('lab_tests.store');
    Route::get('/lab-tests/{id}/edit', 'edit')->name('lab_tests.edit');
    Route::put('/lab-tests/{id}', 'update')->name('lab_tests.update');
    Route::get('/lab-tests/{id}', 'show')->name('lab_tests.show');
    Route::delete('/lab-tests/{id}', 'destroy')->name('lab_tests.destroy');
});

//medical records
Route::middleware(['auth', 'role.records'])->controller(MedicalController::class)->prefix('admin')->group(function () {
    Route::get('/medical-records', 'index')->name('medicals');
    Route::get('/medical-records/create', 'create')->name('medicals.create');
    Route::post('/medical-records', 'store')->name('medicals.store');
    Route::get('/medical-records/{id}/edit', 'edit')->name('medicals.edit');
    Route::put('/medical-records/{id}', 'update')->name('medicals.update');
    Route::get('/medical-records/{id}', 'show')->name('medicals.show');
    Route::delete('/medical-records/{id}', 'destroy')->name('medicals.destroy');
});

// Triages
Route::middleware(['auth', 'role.records'])->controller(TriageController::class)->prefix('admin')->group(function () {
    Route::get('/triages', 'index')->name('triages');
    Route::get('/triages/create', 'create')->name('triages.create');
    Route::post('/triages', 'store')->name('triages.store');
    Route::get('/triages/{id}/edit', 'edit')->name('triages.edit');
    Route::put('/triages/{id}', 'update')->name('triages.update');
    Route::get('/triages/{id}', 'show')->name('triages.show');
    Route::delete('/triages/{id}', 'destroy')->name('triages.destroy');
    Route::get('/triages-report', 'report')->name('triages.report');
});

//Patients
Route::middleware(['auth', 'role.records'])->controller(PatientController::class)->prefix('admin')->group(function () {
    Route::get('/patients', 'index')->name('patients');
    Route::get('/patients/create', 'create')->name('patient.create');
    Route::post('/patients', 'store')->name('patients.store');
    Route::get('/patients/{id}/edit', 'edit')->name('patients.edit');
    Route::put('/patients/{id}', 'update')->name('patients.update');
    Route::get('/patients/{id}', 'show')->name('patients.show');
    Route::delete('/patients/{id}', 'destroy')->name('patients.destroy');
    Route::get('/patients/search', 'search')->name('patients.search');
});

//Receptionists
Route::middleware(['auth', 'role.records'])->controller(ReceptionistController::class)->prefix('admin')->group(function () {
    Route::get('/receptionists', 'index')->name('receptionists');
    Route::get('/receptionists/create', 'create')->name('receptionists.create');
    Route::post('/receptionists', 'store')->name('receptionists.store');
    Route::get('/receptionists/{id}/edit', 'edit')->name('receptionists.edit');
    Route::put('/receptionists/{id}', 'update')->name('receptionists.update');
    Route::delete('/receptionists/{id}', 'destroy')->name('receptionists.destroy');
});

//Departments
Route::controller(DepartmentController::class)->prefix('admin')->group(function () {
    Route::get('/departments', 'index')->name('departments');
    Route::get('/departments/create', 'create')->name('departments.create');
    Route::post('/departments', 'store')->name('departments.store');
    Route::get('/departments/{id}/edit', 'edit')->name('departments.edit');
    Route::put('/departments/{id}', 'update')->name('departments.update');
    Route::delete('/departments/{id}', 'destroy')->name('departments.destroy');
});

//Tags
Route::controller(TagController::class)->prefix('admin')->group(function () {
    Route::get('/tags', 'index')->name('tags');
    Route::get('/tags/create', 'create')->name('tags.create');
    Route::post('/tags', 'store')->name('tags.store');
    Route::get('/tags/{id}/edit', 'edit')->name('tags.edit');
    Route::put('/tags/{id}', 'update')->name('tags.update');
    Route::delete('/tags/{id}', 'destroy')->name('tags.destroy');
});

//Blogs
Route::controller(BlogController::class)->prefix('admin')->group(function () {
    Route::get('/blogs', 'index')->name('blogs');
    Route::get('/blogs/create', 'create')->name('blogs.create');
    Route::post('/blogs', 'store')->name('blogs.store');
    Route::get('/blogs/{id}/edit', 'edit')->name('blogs.edit');
    Route::put('/blogs/{id}', 'update')->name('blogs.update');
    Route::delete('/blogs/{id}', 'destroy')->name('blogs.destroy');
});

//Resources
Route::controller(ResourceController::class)->prefix('admin')->group(function () {
    Route::get('/resources', 'index')->name('resources');
    Route::get('/resources/create', 'create')->name('resources.create');
    Route::post('/resources', 'store')->name('resources.store');
    Route::get('/resources/{id}/edit', 'edit')->name('resources.edit');
    Route::put('/resources/{id}', 'update')->name('resources.update');
    Route::delete('/resources/{id}', 'destroy')->name('resources.destroy');

});

// Pharmacy Orders
Route::middleware(['auth', 'role.records'])->controller(PharmacyOrderController::class)->prefix('admin')->group(function () {
    Route::get('/pharmacy_orders', 'index')->name('pharmacy_orders');
    Route::get('/pharmacy_orders/create', 'create')->name('pharmacy_orders.create');
    Route::post('/pharmacy_orders', 'store')->name('pharmacy_orders.store');
    Route::get('/pharmacy_orders/{id}/edit', 'edit')->name('pharmacy_orders.edit');
    Route::put('/pharmacy_orders/{id}', 'update')->name('pharmacy_orders.update');
    Route::delete('/pharmacy_orders/{id}', 'destroy')->name('pharmacy_orders.destroy');
});

// Pharmacy Order Items
Route::controller(PharmacyOrderItemController::class)->prefix('admin')->group(function () {
    Route::get('/pharmacy_orders_items', 'index')->name('pharmacy_orders_items');
    Route::get('/pharmacy_orders_items/create', 'create')->name('pharmacy_orders_items.create');
    Route::post('/pharmacy_orders_items', 'store')->name('pharmacy_orders_items.store');
    Route::get('/pharmacy_orders_items/{id}/edit', 'edit')->name('pharmacy_orders_items.edit');
    Route::put('/pharmacy_orders_items/{id}', 'update')->name('pharmacy_orders_items.update');
    Route::delete('/pharmacy_orders_items/{id}', 'destroy')->name('pharmacyy_orders_items.destroy');
});

//billings
Route::controller(BillingController::class)->prefix('admin')->group(function () {
    Route::get('/billings', 'index')->name('billings');
    Route::get('/billings/create', 'create')->name('billings.create');
    Route::post('/billings', 'store')->name('billings.store');
    Route::get('/billings/{id}/edit', 'edit')->name('billings.edit');
    Route::put('/billings/{id}', 'update')->name('billings.update');
    Route::get('/billings/{id}', 'show')->name('billings.show');
    Route::delete('/billings/{id}', 'destroy')->name('billings.destroy');
});

//Users
Route::controller(UserController::class)->prefix('admin')->group(function () {
    Route::get('/users', 'index')->name('users');
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{id}/edit', 'edit')->name('users.edit');
    Route::put('/users/{id}', 'update')->name('users.update');
    Route::get('/users/{id}', 'show')->name('users.show');
    Route::delete('/users/{id}', 'destroy')->name('users.destroy');
    Route::get('/user/update-role/{id}/{role}', 'updateRole')->name('user.updateRole');
    Route::get('/user/update-status/{id}/{status}', 'updateStatus')->name('user.updateStatus');
    Route::get('/check-username', 'checkUsername')->name('check.username');
    Route::get('/check-email', 'checkEmail')->name('check.email');
});




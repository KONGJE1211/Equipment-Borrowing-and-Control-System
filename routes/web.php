<?php

use App\Http\Controllers\Admin\AuditReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


// Guest Pages
Route::get('/', function () { return view('guest.guest'); })->name('guest');

// Guest Subpages
Route::get('/guest/guest', function () { return view('guest.guest'); })->name('guest.guest');
Route::get('/guest/borrowing-process', function () { return view('guest.BorrowingProcess'); })->name('guest.borrowing_process');
Route::get('/guest/system-features', function () { return view('guest.SystemFeatures'); })->name('guest.system_features');
Route::get('/guest/contact-us', function () { return view('guest.ContactUs'); })->name('guest.contact_us');


// User authentication
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// User Pages (after login)
Route::middleware(['auth.user'])->group(function () {
Route::get('/home', [UserController::class, 'home'])->name('home');

Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment');
Route::get('/equipment/{id}', [EquipmentController::class,'show'])->name('equipment.show');

Route::get('/booking', [BookingController::class, 'create'])->name('booking');
Route::post('/booking', [BookingController::class, 'store']);
Route::get('/booking/list', [BookingController::class,'index'])->name('booking.index');
Route::get('/history', [BookingController::class, 'history'])->name('history');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');


Route::get('/report-lost', [UserController::class, 'showLostReportForm'])->name('user.reportLostForm');
Route::post('/report-lost', [UserController::class, 'submitLostReport'])->name('user.submitLostReport');

Route::get('/my-reports', [UserController::class, 'myReports'])->name('user.myReports');

});

// Admin authentication
Route::get('/admin/login', [AdminController::class,'loginPage'])->name('admin.login');
Route::post('/admin/login', [AdminController::class,'login'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminController::class,'logout'])->name('admin.logout');

// Admin Pages (after login)
Route::middleware(['adminAuth'])->group(function () {
Route::get('/admin/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');

Route::get('/admin/equipment', [AdminController::class,'manageEquipment'])->name('admin.manageEquipment');
Route::post('/admin/equipment/add', [AdminController::class,'addEquipment'])->name('admin.addEquipment');
Route::get('/admin/equipment/edit/{id}', [AdminController::class, 'editEquipment'])->name('admin.editEquipment');
Route::post('/admin/equipment/update/{id}', [AdminController::class,'updateEquipment'])->name('admin.updateEquipment');
Route::post('/admin/equipment/delete/{id}', [AdminController::class,'deleteEquipment'])->name('admin.deleteEquipment');

Route::get('/admin/users', [AdminController::class,'manageUser'])->name('admin.manageUser');
Route::post('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.createUser');
Route::post('/admin/users/delete/{id}', [AdminController::class,'deleteUser'])->name('admin.deleteUser');

Route::get('/admin/bookings', [AdminController::class,'bookingList'])->name('admin.bookingList');
Route::post('/admin/bookings/approve/{id}', [AdminController::class,'approveBooking'])->name('admin.approveBooking');
Route::post('/admin/bookings/reject/{id}', [AdminController::class,'rejectBooking'])->name('admin.rejectBooking');
Route::post('/admin/bookings/returned/{id}', [AdminController::class,'markReturned'])->name('admin.markReturned');

Route::get('/admin/lost-reports', [AdminController::class, 'viewLostReports'])->name('admin.lostReports');
Route::post('/admin/lost-reports/reply/{id}', [AdminController::class, 'replyLostReport'])->name('admin.replyLostReport');

// Audit Report Page
Route::get('/admin/audit-report', [AuditReportController::class, 'index'])->name('admin.audit.report');

// Generate PDF (Monthly / Annual)
Route::post('/admin/audit-report/preview', [AuditReportController::class, 'preview'])->name('admin.audit.preview');
Route::post('/admin/audit-report/export', [AuditReportController::class, 'export'])->name('admin.audit.export');


});


/*Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/

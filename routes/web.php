<?php

// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Backend\AmenitiesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// User Frontend All Routes
Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

require __DIR__.'/auth.php';

// Admin Group Middleware
Route::middleware(['auth', 'roles:admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
});
// End Admin Group Middleware

 Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// Admin Group Middleware
 Route::middleware(['auth', 'roles:admin'])->group(function() {

    //Property Type All Routes
    Route::controller(PropertyTypeController::class)->group(function() {
        Route::get('/all/types', 'AllTypes')->name('all.types');
        Route::get('/add/type', 'AddType')->name('add.type');
        Route::post('/store/type', 'StoreType')->name('store.type');
        Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
        Route::post('/update/type', 'UpdateType')->name('update.type');
        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');
    });

    //Amenities All Routes
    Route::controller(AmenitiesController::class)->group(function() {
        Route::get('/all/amenities', 'AllAmenities')->name('all.amenities');
        Route::get('/add/amenity', 'AddAmenity')->name('add.amenity');
        Route::post('/store/amenity', 'StoreAmenity')->name('store.amenity');
        Route::get('/edit/amenity/{id}', 'EditAmenity')->name('edit.amenity');
        Route::post('/update/amenity', 'UpdateAmenity')->name('update.amenity');
        Route::get('/delete/amenity/{id}', 'DeleteAmenity')->name('delete.amenity');
    });

    //Property All Routes
    Route::controller(PropertyController::class)->group(function() {
        Route::get('/all/properties', 'AllProperties')->name('all.properties');
        Route::get('/add/property', 'AddProperty')->name('add.property');
        // Route::post('/store/amenity', 'StoreAmenity')->name('store.amenity');
        // Route::get('/edit/amenity/{id}', 'EditAmenity')->name('edit.amenity');
        // Route::post('/update/amenity', 'UpdateAmenity')->name('update.amenity');
        // Route::get('/delete/amenity/{id}', 'DeleteAmenity')->name('delete.amenity');
    });

    
 });





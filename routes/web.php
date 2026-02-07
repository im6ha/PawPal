<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\SitterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SavedPostController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\LostPetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/adopt', [AdoptionController::class, 'index'])->name('adopt');
Route::get('/find-sitters', fn() => view('main-pages.find-sitters'))->name('find-sitters');
Route::get('/market', fn() => view('main-pages.market'))->name('market');
Route::get('/pet-care-guide', fn() => view('main-pages.pet-care-guide'))->name('pet-care-guide');

Route::prefix('guide')->group(function () {
    Route::get('/bird', fn() => view('pet_care_guides.bird'))->name('bird');
    Route::get('/cat', fn() => view('pet_care_guides.cat'))->name('cat');
    Route::get('/dog', fn() => view('pet_care_guides.dog'))->name('dog');
    Route::get('/fish', fn() => view('pet_care_guides.fish'))->name('fish');
    Route::get('/hamster', fn() => view('pet_care_guides.hamster'))->name('hamster');
    Route::get('/rabbit', fn() => view('pet_care_guides.rabbit'))->name('rabbit');
});

Route::middleware('guest')->group(function () {
    Route::get('/signup-page', fn() => view('other-pages.signup-page'))->name('signup-page');
    Route::post('/signup-process', [AuthController::class, 'register'])->name('signup.store');
    Route::get('/login-page', fn() => view('other-pages.login-page'))->name('login-page');
    Route::post('/login-page', [AuthController::class, 'login'])->name('login');

});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', fn() => view('other-pages.profile'))->name('profile');
    Route::get('/user-dashboard', fn() => view('other-pages.user-dashboard'))->name('user-dashboard');
    Route::post('/signup-page/upload-pic', [AuthController::class, 'uploadProfilePic'])->name('signup.upload-pic');
    Route::post('/profile-update', [AuthController::class, 'updateProfile'])->name('profile.update'); 
    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
    Route::delete('/profile/delete', [AuthController::class, 'deleteAccount']);
    Route::post('/offer-adoption', [AdoptionController::class, 'store'])->name('store-adoption');
    Route::get('/adoption-form', fn() => view('other-pages.adoption-form'))->name('adoption-form');
    Route::get('/sitter-form', fn() => view('other-pages.sitter-form'))->name('sitter-form');
    Route::post('/apply-sitter', [SitterController::class, 'store'])->name('store-pet-sitter');



    
    Route::get('/lost-pets', [LostPetController::class, 'index'])->name('lost-pets');
    Route::get('/report-lost', [LostPetController::class, 'create'])->name('report-lost');
    Route::post('/report-lost', [LostPetController::class, 'store'])->name('report-lost.store');
    Route::get('/api/lost-pets', [LostPetController::class, 'apiIndex']);





    Route::get('/market/add-product', fn() => view('other-pages.add-product'))->name('market.add-product');
    Route::get('/admin-dashboard', fn() => view('other-pages.admin-dashboard'))->name('admin-dashboard');
    Route::post('/api/products', [ProductController::class, 'store'])->middleware('auth');
    Route::post('/api/saved-posts/toggle', [SavedPostController::class, 'toggle'])->middleware('auth');
    Route::post('/api/service-requests', [ServiceRequestController::class, 'store']);
    Route::patch('/api/service-requests/{id}/status', [ServiceRequestController::class, 'updateStatus']);
    });

Route::get('/sitters-data', [SitterController::class, 'getSitters']);
Route::get('/api/products', [ProductController::class, 'index']);



Route::prefix('admin')->group(function () {
    Route::get('/posts/{type}/{status}', [AdminController::class, 'getPosts']);
    Route::post('/posts/{type}/{id}/action', [AdminController::class, 'updatePostStatus']);

    Route::get('/reports/{type}', [AdminController::class, 'getReports']);
    Route::post('/reports/{id}/action', [AdminController::class, 'handleReportAction']);

    Route::get('/users', [AdminController::class, 'getUsers']);
    Route::post('/users/{id}/status', [AdminController::class, 'updateUserStatus']);
});

Route::get('/admin/stats', [AdminController::class, 'getStats']);



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/saved/{type}', [UserDashboardController::class, 'getSavedItems']);
    Route::post('/dashboard/unsave', [UserDashboardController::class, 'unsaveItem']);
    Route::get('/dashboard/requests-sent/{type}', [UserDashboardController::class, 'getSentRequests']);
    Route::post('/dashboard/requests/cancel', [UserDashboardController::class, 'cancelRequest']);
    Route::get('/dashboard/my-posts/{type}', [UserDashboardController::class, 'getMyPosts']);
    Route::get('/dashboard/post-requests/{type}/{id}', [UserDashboardController::class, 'getPostIncomingRequests']);
    Route::post('/dashboard/requests/handle', [UserDashboardController::class, 'handleRequestAction']);
    Route::post('/dashboard/post/delete', [UserDashboardController::class, 'deletePost']);
    Route::get('/dashboard/stats', [UserDashboardController::class, 'getStats']);
});



Route::post('/api/reports', [ReportController::class, 'store'])->middleware('auth');
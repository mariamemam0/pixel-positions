<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Jobs\TestEmailJob;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return view('test');
});
Route::get('/',[JobController::class,'index']);
Route::get('/jobs/create',[JobController::class,'create'])->middleware('auth');
Route::post('/jobs',[JobController::class,'store'])->middleware('auth');


Route::get('/search',SearchController::class);
Route::get('/tags/{tag:name}',TagController::class);


Route::middleware('guest')->group(function(){
Route::get('/register',[RegisterUserController::class,'create']);
Route::post('/register',[RegisterUserController::class,'store']);

Route::get('/login',[SessionController::class,'create']);
Route::post('/login',[SessionController::class,'store']);
});


Route::delete('/logout',[SessionController::class,'destroy'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Show all notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    // Mark a single notification as read
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    // Mark all notifications as read
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');
});

Route::get('/test-job', function () {
    TestEmailJob::dispatch();
    return 'Job dispatched!';
});
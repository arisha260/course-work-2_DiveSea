<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Home\AuthorsController;
use App\Http\Controllers\Home\AuthorWorksController;
use App\Http\Controllers\Home\CreateNftController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\Home\LoadMoreController;
use App\Http\Controllers\Home\SearchController;
use App\Http\Controllers\Home\ShowAuthorController;
use App\Http\Controllers\Home\ShowController;
use App\Http\Controllers\Home\StoreNftController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    // Маршруты для регистрации и входа
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Маршрут для выхода
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:sanctum');

// Маршруты для восстановления пароля
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
    Route::post('/reset-password', [NewPasswordController::class, 'store']);

// Маршруты для подтверждения email
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth:sanctum', 'signed'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:sanctum'])
        ->name('verification.send');

// Получение данных пользователя (требует авторизации)
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

});

Route::group(['namespace'=> 'App\Http\Controllers\Home', 'prefix' => 'home'], function(){
//    Route::get('/create', CreateNftController::class)->middleware('auth:sanctum');
    Route::post('/store', StoreNftController::class)->middleware('auth:sanctum');
    Route::get('/load-more', LoadMoreController::class);
    Route::get('/authors', AuthorsController::class);
    Route::get('/search', SearchController::class);
    Route::get('/', IndexController::class);
    Route::get('/{nft}', ShowController::class);
    Route::get('/author/{author}', ShowAuthorController::class);
    Route::get('/author/{id}/works', AuthorWorksController::class);
});

Route::group(['namespace'=> 'App\Http\Controllers\Admin', 'prefix' => 'admin'], function(){
    Route::get('/', \App\Http\Controllers\Admin\IndexController::class);
    Route::post('/create/{id}', \App\Http\Controllers\Admin\StoreNftController::class);
    Route::delete('/delete/{id}', \App\Http\Controllers\Admin\DeleteNftController::class);
});

Route::group(['namespace'=> 'App\Http\Controllers\Authorship', 'prefix' => 'authorship'], function(){
    Route::get('/', \App\Http\Controllers\Authorship\IndexController::class);
    Route::get('/check/{id}', \App\Http\Controllers\Authorship\CheckAuthorshipController::class);
    Route::post('/create', \App\Http\Controllers\Authorship\StoreAuthorshipController::class);
    Route::post('/approve/{id}', \App\Http\Controllers\Authorship\AuthorshipApprovalController::class);
    Route::delete('/delete/{id}', \App\Http\Controllers\Authorship\DeleteApproveAuthorshipController::class);
});

Route::group(['namespace'=> 'App\Http\Controllers\Buy', 'prefix' => 'buy'], function(){
    Route::get('/profile', \App\Http\Controllers\Buy\IndexController::class);
    Route::post('/nft/{id}', \App\Http\Controllers\Buy\BuyNftController::class);
});

Route::group(['namespace'=> 'App\Http\Controllers\BuyAuction', 'prefix' => 'auction'], function(){
    Route::get('/profile', \App\Http\Controllers\BuyAuction\IndexController::class);
    Route::get('/profile/auction-win', \App\Http\Controllers\BuyAuction\CompletedAuctionsController::class);
    Route::post('/nft/{id}', \App\Http\Controllers\BuyAuction\MakeAuctionBidController::class);
});

Route::middleware(['auth:sanctum'])->post('/home/test', function (Request $request) {
    Log::info('Route reached', [ 'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId()]);
    return response()->json(['message' => 'Route is working']);
});

Route::get('/check-auth', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user(),
        'session_id' => session()->getId(),
    ]);
});

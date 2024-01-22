<?php

use App\Http\Controllers\API\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\LogController;
use App\Http\Controllers\API\UserPermissionController;
use App\Http\Resources\API\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return new UserResource($request->user());
});

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::apiResource('/users', UserController::class)->names('api.users')->only([
        'index', 'show', 'update', 'destroy'
    ]);

    Route::apiResource('/logs', LogController::class)->names('api.logs')->only([
        'index'
    ]);

    Route::get('/user-permissions', [UserPermissionController::class, 'index'])->name('api.user-permissions.index');

    Route::post('/user-permissions/grant', [UserPermissionController::class, 'grant'])->name('api.user-permissions.grant');

    Route::delete('/user-permissions/forbid', [UserPermissionController::class, 'forbid'])->name('api.user-permissions.forbid');

// Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/azure-files/{azureFile}/download', [FileController::class, 'download'])->name('api.files.download');
    Route::apiResource('/azure-files', FileController::class)->names('api.files');

// });

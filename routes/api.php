<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\LabelController;
use App\Http\Controllers\API\SecretInformationController;
use App\Http\Controllers\API\UserController;
use App\Models\SecretInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/check-email', [UserController::class, 'checkEmail'])->name('checkEmail');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [UserController::class, 'fetch'])->name('user');
    Route::post('/user/change-key', [UserController::class, 'changeKey'])->name('changeKey');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::post('/secret-informations', [SecretInformationController::class, 'store'])->name('create-secret-information');
    Route::get('/secret-informations', [SecretInformationController::class, 'fetch'])->name('fetch
    -secret-information');
    Route::post('/secret-informations/{id}', [SecretInformationController::class, 'update'])->name('update-secret-information');
    Route::delete('/secret-informations/{id}', [SecretInformationController::class, 'destroy'])->name('delete-secret-information');

    Route::get('/categories', [CategoryController::class, 'fetch'])->name('fetch-categories');

    Route::get('/labels/{id_category}', [LabelController::class, 'fetch'])->name('fetch-label');

});

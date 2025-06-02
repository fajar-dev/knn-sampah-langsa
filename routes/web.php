<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AnalystController;

Route::prefix('/auth')->group(function () {
  Route::get('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
  Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('forgot');
  Route::post('/forgot-password', [AuthController::class, 'forgotSubmit'])->name('forgot.submit');
  Route::get('/forget/{token}/reset', [AuthController::class, 'reset'])->name('reset');
  Route::post('/forget/{token}/reset', [AuthController::class, 'resetSubmit'])->name('reset.submit');
})->middleware(['guest']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('/data')->group(function () {
  Route::get('/', [DataController::class, 'index'])->name('data');
  Route::post('/', [DataController::class, 'store'])->name('data.store');
  Route::get('/destroy', [DataController::class, 'destroyAll'])->name('data.destroy.all');
  Route::post('/import', [DataController::class, 'import'])->name('data.import');
  Route::post('/{id}/update', [DataController::class, 'update'])->name('data.update');
  Route::get('/{id}/destroy', [DataController::class, 'destroy'])->name('data.destroy');
})->middleware(['auth']);

Route::prefix('/analyst')->group(function () {
  Route::get('/', [AnalystController::class, 'index'])->name('analyst');
  Route::get('/apriori', [AnalystController::class, 'apriori'])->name('analyst.apriori');
})->middleware(['auth']);

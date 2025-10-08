<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreviewSertifikatController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/result/{id}', [HomeController::class, 'result'])->name('result');
Route::post('/sertifikat', [HomeController::class, 'sertifikat'])->name('sertifikat');
Route::get('/preview-sertifikat', [PreviewSertifikatController::class, 'previewSertifikat'])->name('preview.sertifikat');
Route::get('/preview-sertifikat/{id}', [PreviewSertifikatController::class, 'previewSertifikatDetail'])->name('preview.sertifikat.detail');

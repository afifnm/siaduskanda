<?php

use App\Http\Controllers\Api\PengaduanApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST API Routes - SIADU SMKN 2 Karanganyar
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    Route::get('/stats', [PengaduanApiController::class, 'stats']);
    Route::get('/pengaduan', [PengaduanApiController::class, 'index']);
    Route::post('/pengaduan', [PengaduanApiController::class, 'store']);
    Route::get('/pengaduan/{ticket_number}', [PengaduanApiController::class, 'show']);
    Route::post('/pengaduan/{ticket_number}/feedback', [PengaduanApiController::class, 'feedback']);
});

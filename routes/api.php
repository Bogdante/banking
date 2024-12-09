<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Bank\Controllers\BankController;
use App\Modules\Infrastructure\Controllers\BankInfrastructureController;

Route::get('/banks', [BankController::class, 'getBanks']);
Route::get('/bank/{bank}/offices', [BankInfrastructureController::class, 'getOfficesForBank']);
Route::get('/bank/{bank}/can-credit/offices', [BankInfrastructureController::class, 'getOfficesCanCreditForBank']);

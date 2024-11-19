<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('889901')->group(function () {
    // Route::get('/number-category-validation/{number}', [App\Http\Controllers\NumberValidationApiController::class, 'checkNumberCategory']);
    Route::get('/existing-number/{number}', [App\Http\Controllers\NumberValidationApiController::class, 'checkNumberExist']);
    Route::post('/verify-pin', [App\Http\Controllers\AuthApiController::class, 'validatePin']);
    // Route::post('/reset-pin', [App\Http\Controllers\AuthApiController::class, 'resetPin']);
    // Route::post('/change-pin', [App\Http\Controllers\AuthApiController::class, 'changePin']);
    Route::post('/reset-pin', [App\Http\Controllers\AuthApiController::class, 'changePin']);
    Route::post('/list-accounts', [App\Http\Controllers\AccountsApiController::class, 'listAccountsFirst3']);
    Route::post('/list-cust-accounts', [App\Http\Controllers\AccountsApiController::class, 'listAccountsFirst3Cust']);
    Route::post('/credit-account', [App\Http\Controllers\AccountsApiController::class, 'creditAccount']);
    Route::post('/account-balance', [App\Http\Controllers\AccountsApiController::class, 'checkAccountBalance']);
    Route::post('/get-contact-info', [App\Http\Controllers\AccountsApiController::class, 'getContactInfo']);
    Route::post('/field-deposit', [App\Http\Controllers\AccountsApiController::class, 'saveFieldDeposit']);
    Route::post('/register-customer', [App\Http\Controllers\AuthApiController::class, 'registerAccount']);
    Route::post('/create-field-account',    [App\Http\Controllers\AuthApiController::class, 'createFieldAccount']);
    Route::get('/name-inquiry/{number}', [App\Http\Controllers\NumberValidationApiController::class, 'nameInquiryAccountNumber']);
});
// curl -ivk http://127.0.0.1:8001/api/verify-pin
// --header 'Content-Type: application/json' \
// --data-raw '{
//     "password": "z20qLjetE5b0pPixVCsjUg==",
//     "sourceIPAddress": "127.0.0.1",
//     "userName": "ESB_USER"
// }'

// curl -ivk "http://127.0.0.1:8000/api/verify-pin" -H  "Content-Type: application/json"  -d '{
//     "number": 0546437976,
//     "password": 1234,
//    }'

// curl -ivk "http://127.0.0.1:8001/api/list-accounts" -H  "Content-Type: application/json"  -d '{
//     "id": 1001,
//    }'

// curl -ivk "http://127.0.0.1:8000/api/register-account" -H  "Content-Type: application/json"  -d '{"firstName": "Jason", "lastName": "Kwabena", "gender": "m", "mobileNumber": "0557881327", "altMobileNumber": "", "type": "CUSTOMER"}'
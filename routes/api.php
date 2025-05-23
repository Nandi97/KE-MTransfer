<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json([
        'token' => $user->createToken($request->device_name)->plainTextToken,
    ]);
});
Route::middleware('auth:sanctum')->group(function () {
    // Wallet
    Route::get('/wallet', [WalletController::class, 'balance']);
    Route::post('/wallet/fund', [WalletController::class, 'fund']);
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw']);

    // Transfer
    Route::post('/transfer', [TransferController::class, 'send']);
    Route::get('/transfer/history', [TransferController::class, 'history']);

    // User Search
    Route::get('/users/search', [UserController::class, 'search']);

    Route::get('/accounts', [AccountController::class, 'index']);
    Route::post('/accounts', [AccountController::class, 'store']);

    //OTP
    Route::post('/otp/send', [OTPController::class, 'send']);
    Route::post('/otp/verify', [OTPController::class, 'verify']);

    // Account Sync
    Route::post('/accounts/{id}/refresh', [AccountController::class, 'refresh']);
});

<?php

use App\Models\User;
use App\Support\ApiFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\PupilController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json([
    'message' => 'pong',
    'time'    => now()->toIso8601String(),
    'student' => config('lab.slug'),
]));

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return ApiFormat::error(
            'Неверный email или пароль',
            422
        );
    }

    $token = $user->createToken('bruno')->plainTextToken;

    return ApiFormat::success([
        'token' => $token,
    ]);
});

Route::name('api.')->group(function () {
    Route::apiResource(
        'pupils',
        PupilController::class
    );
});
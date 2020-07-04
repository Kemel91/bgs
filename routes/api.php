<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

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
Route::post('auth', function (Request $request) {
    $user = User::query()
        ->select('api_token', 'password')
        ->where('email',$request->get('email'))
        ->first();
    if (!is_null($user) && Hash::check($request->get('password'), $user->password)) {
        return response()->json(['token' => $user->api_token]);
    }
    return response()->json(['error' => 'Ошибка авторизации'], 422);
});

Route::namespace('Api')->middleware('auth:api')->group(function (){
    Route::apiResource('members','MemberController');
});

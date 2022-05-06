<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum','abilities:admin'])->get('/admin', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    $user = User::where('email',$request->input('email'))->first();

    if($user){
        if($user->password === $request->input('password')){
            $token = $user->createToken($request->device_name,['admin']);
 
            return ['token' => $token->plainTextToken];
        }
    }
});
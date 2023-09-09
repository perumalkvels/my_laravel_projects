<?php


use App\Http\Controllers\UserDataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OTPController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Group Method For Using Controller
Route::controller(UserDataController::class)->group(function(){
    Route::post('/createUser', 'createUser'); 
    Route::get('/getUsers', 'getUsers'); 
    Route::post('/delUsers', 'delUsers');
});


Route::prefix('user')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware(AuthMiddleware::class . ':login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(AuthMiddleware::class . ':logout');
    Route::post('/register', [AuthController::class, 'register'])->middleware(AuthMiddleware::class . ':register');
    Route::post('/resetPassword', [AuthController::class, 'resetPassword'])->middleware(AuthMiddleware::class . ':forgotPassword');
    Route::post('/send-otp', [OTPController::class, 'sendOTP']);
});





// Route::prefix('user/')->group(function () {
//     Route::controller(AuthController::class, [
//         '/login' => 'login',
//         '/logout' => 'logout',
//         '/register' => 'register',
//         '/forgotPassword' => 'forgotPassword',
//     ]);
// });

// Route::group(['middleware' => ['login'], 'prefix' => 'user'], function () {
    
//     Route::post('/login', 'AuthController@login');  
//     Route::get('/logout', 'AuthController@logout'); 
//     Route::post('/register', 'AuthController@register');
//     Route::post('/forgotPassword', 'AuthController@forgotPassword');

// });



// Route::post('/login', [AuthController::class,'login']);  

// Route::post('/createUser',[UserDataController::class,'createUser']);
// Route::get('/getUsers',[UserDataController::class,'getUser']);
// Route::post('/delUsers',[UserDataController::class,'delUsers']);

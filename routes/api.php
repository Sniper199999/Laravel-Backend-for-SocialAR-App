<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentsController;
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

// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/tests', [UserController::class, 'getMedia']);
Route::get('/pic', [MediaController::class, 'OpenPic']);
Route::get('/media', [MediaController::class, 'index']);
Route::post('/uploadimg', [MediaController::class, 'UploadImg']);
Route::get('/getusers', [UserController::class, 'nearbyUsers']);
Route::get('/getcomments', [CommentsController::class, 'getCommentsOnPic']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/user', [UserController::class, 'index']);
    Route::get('/user', [UserController::class, 'index']);
    
});




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/test', function(Request $request) {
    $param = $request->input('parameter');


    // Do something with param here

    return [ "result" => $param];
});



Route::get('/test', function(Request $request) {
    return [
        [
            "x" => 123,
            "y" => 53425
        ],
        [
            "x" => 123,
            "y" => 789
        ],
    ];
});

//Route::resource('user', UserController::class);
//Route::resource('media', MediaController::class);
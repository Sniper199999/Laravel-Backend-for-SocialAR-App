<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendsController;
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
Route::get('/flasktest', [MediaController::class, 'flask']);
Route::get('/getmedia', [MediaController::class, 'getMediaa']);
Route::get('/getmediaofuser', [MediaController::class, 'getmediaofuser']);
Route::get('/homepage', [MediaController::class, 'homepage']);
Route::get('/getuserinfo', [MediaController::class, 'getuserinfo']);


//insert main data
Route::get('/insertdata', [UserController::class, 'insertdata']);
Route::get('/insertfof', [FriendsController::class, 'insertfof']);
Route::get('/insertmediadata', [MediaController::class, 'insertmediadata']);



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

    function rand_float($st_num=0,$end_num=1,$mul=1000000)
        {
        if ($st_num>$end_num) return false;
        return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
        }
    
    $loc = array();
    //Vasai
    $cood_1 = array(); 
    $cood_1[] = rand_float(19.364108,19.391966);
    $cood_1[] = rand_float(72.810590, 72.836317);
    $loc[] = $cood_1;
    
    //Virar
    $cood_2 = array(); 
    $cood_2[] = rand_float(19.448449,19.462525);
    $cood_2[] = rand_float(72.799873, 72.819856);
    $loc[] = $cood_2;

    //Palghar
    $cood_3 = array(); 
    $cood_3[] = rand_float(19.691337,19.715975);
    $cood_3[] = rand_float(72.762142, 72.793665);
    $loc[] = $cood_3;

    $random_loc_index = array_rand($loc);
    $random_location = $loc[$random_loc_index];

    $faker = Faker\Factory::create();
    $sentence_length = mt_rand(254, 255);
    $varr = $faker->realText($sentence_length);
    $tt = $sentence_length . $varr;
    return $tt;
    
    // return [
    //     [
    //         "x" => 123,
    //         "y" => 53425
    //     ],
    //     [
    //         "x" => 123,
    //         "y" => 789
    //     ],
    // ];
});

//Route::resource('user', UserController::class);
//Route::resource('media', MediaController::class);
<?php

use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VideoController;

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

Route::middleware('api')->group(function(){


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

//categories routes
Route::get('/categories' , [CategoryController::class , 'index'])->middleware('role:admin');
Route::post('/categories' , [CategoryController::class , 'store'])->middleware('role:admin');
Route::get('/categories/{category}' , [CategoryController::class , 'show']);
Route::post('/categories/{category}' , [CategoryController::class , 'update'])->middleware('role:admin');
Route::post('/categories/{category}' , [CategoryController::class , 'destroy'])->middleware('role:admin');

//tags routes
Route::get('/tags' , [TagController::class , 'index'])->middleware('role:admin');
Route::post('/tags' , [TagController::class , 'store'])->middleware('role:admin');
Route::get('/tags/{tag}' , [TagController::class , 'show']);
Route::post('/tags/{tag}' , [TagController::class , 'update'])->middleware('role:admin');
Route::post('/tags/{tag}' , [TagController::class , 'destroy'])->middleware('role:admin');

//image routes
Route::get('/images' , [ImageController::class , 'index']);
Route::post('/tags' , [ImageController::class , 'store'])->middleware('role:admin');
Route::get('/tags/{tag}' , [ImageController::class , 'show']);
Route::post('/tags/{tag}' , [ImageController::class , 'update'])->middleware('role:admin');
Route::post('/tags/{tag}' , [ImageController::class , 'destroy'])->middleware('role:admin');

//users routes
Route::resource('users', UserController::class, ['except'=>['create','edit']]);


//grouping routes with the middleware author
Route::group(['prefix' => 'author'] , function(){

//post routes
Route::apiResource('/posts' ,PostController::class);

//video routes
Route::apiResource('/videos' , VideoController::class);


})->middleware(['author'] ,['only'=>(['update' , 'destroy'])]);


//comment routes
/* There is a middleware in the constructor in the Image Controller to allow only
    the owner of the comment to delete and update the comments */
Route::apiResource('/comments',CommentController::class);
});

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
});

// レシピ登録画面
Route::get('/create-recipe', function(){
    return view('/recipe/create');
});
// レシピ登録
Route::post('/store-recipe',  [App\Http\Controllers\recipeController::class, 'store']);

// 食材一覧
Route::get('/index-foods', [App\Http\Controllers\foodController::class, 'index']);
// 食材登録画面
Route::get('/create-food', function(){
    return view('/food/create');
});
// 食材編集画面
Route::get('/edit-food/{id}', [App\Http\Controllers\foodController::class, 'getFood']);

// 食材登録
Route::post('/store-food', [App\Http\Controllers\foodController::class, 'store']);
// 食材編集
Route::post('/update-food/{id}', [App\Http\Controllers\foodController::class, 'update']);
// 食材削除
Route::delete('/delete-food/{id}', [App\Http\Controllers\foodController::class, 'destroy']);




// レシピ一覧画面
// Route::get('/index-recipes', [App\Http\Controllers\recipeController::class, 'index']);
Route::get('/index-recipes', function(){
    return view('/recipe/index');
});

// レシピ編集画面
Route::get('/edit-recipes', [App\Http\Controllers\recipeController::class, 'edit']);
// レシピ編集
Route::get('/edit-recipes/edit', [App\Http\Controllers\recipeController::class, 'edit']);


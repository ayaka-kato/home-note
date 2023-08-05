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
// 食材検索
Route::get('/search-foods', [App\Http\Controllers\foodController::class, 'searchFoods']);
// 食材編集
Route::post('/update-food/{id}', [App\Http\Controllers\foodController::class, 'update']);
// 食材削除
Route::delete('/delete-food/{id}', [App\Http\Controllers\foodController::class, 'destroy']);



// レシピ登録画面
Route::get('/create-recipe',  [App\Http\Controllers\recipeController::class, 'getFoods']);
// レシピ登録
Route::post('/store-recipe',  [App\Http\Controllers\recipeController::class, 'store']);
// レシピ検索
Route::get('/search-recipes', [App\Http\Controllers\recipeController::class, 'searchRecipes']);


// レシピ一覧画面
Route::get('/index-recipes', [App\Http\Controllers\recipeController::class, 'index']);
// レシピ詳細画面
Route::get('/detail-recipe/{id}', [App\Http\Controllers\recipeController::class, 'getRecipe']);

// レシピ編集画面
Route::get('/edit-recipes/{id}', [App\Http\Controllers\recipeController::class, 'getRecipe']);
// レシピ編集
Route::get('/update-recipes', [App\Http\Controllers\recipeController::class, 'update']);
// レシピ削除
Route::delete('/delete-recipe/{id}', [App\Http\Controllers\recipeController::class, 'destroy']);


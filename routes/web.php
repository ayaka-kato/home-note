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

// -----------------------------------------------------------------------------------------------------
// レシピ関連
// -----------------------------------------------------------------------------------------------------
// 画面遷移  ----------------------------------------------
// レシピ一覧画面
Route::get('/index-recipes', [App\Http\Controllers\RecipeController::class, 'index']);
// レシピ登録画面
Route::get('/create-recipe',  [App\Http\Controllers\RecipeController::class, 'viewCreate']);
// レシピ詳細画面/編集画面
Route::get('/detail-recipe/{id}', [App\Http\Controllers\RecipeController::class, 'getRecipe']);


// 機能  ----------------------------------------------
// レシピ登録
Route::post('/store-recipe',  [App\Http\Controllers\RecipeController::class, 'store']);
// レシピ検索
Route::get('/search-recipes', [App\Http\Controllers\RecipeController::class, 'searchRecipes']);
// レシピ編集
Route::post('/update-recipe/{id}', [App\Http\Controllers\RecipeController::class, 'update']);
// レシピ削除
Route::delete('/delete-recipe/{id}', [App\Http\Controllers\RecipeController::class, 'destroy']);


// -----------------------------------------------------------------------------------------------------
// 食材在庫データ関連
// -----------------------------------------------------------------------------------------------------
// 食材在庫データ一覧
Route::get('/index-foodRecords', [App\Http\Controllers\FoodRecordController::class, 'index']);
// 食材在庫データ登録画面
Route::get('/create-foodRecord',  [App\Http\Controllers\FoodRecordController::class, 'viewCreate']);
// 食材在庫データ編集画面
Route::get('/edit-foodRecord/{id}',  [App\Http\Controllers\FoodRecordController::class, 'viewEdit']);
// 買い物リスト画面
Route::get('/create-restockList',  [App\Http\Controllers\FoodRecordController::class, 'viewRestockList']);

// 食材在庫データ登録
Route::post('/store-foodRecord', [App\Http\Controllers\FoodRecordController::class, 'store']);
// 食材編集
Route::post('/update-foodRecord/{date}', [App\Http\Controllers\FoodRecordController::class, 'update']);
// // 食材削除
// Route::delete('/delete-foodRecord/{id}', [App\Http\Controllers\FoodRecordController::class, 'destroy']);
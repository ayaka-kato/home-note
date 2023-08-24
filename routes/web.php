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

Route::middleware(['auth'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // 【レシピ関連】
    // -------------------------------------------------------------------------------------------------------------
    Route::prefix('recipes')->group(function () {
    
        Route::get('/index', [App\Http\Controllers\RecipeController::class, 'searchRecipes'])->name('indexRecipes');    //レシピ一覧へ
        Route::get('/create',  [App\Http\Controllers\RecipeController::class, 'viewCreate'])->name('createRecipe');     //レシピ登録へ
        Route::get('/detail/{id}', [App\Http\Controllers\RecipeController::class, 'getRecipe'])->name('getRecipe');     //レシピ詳細へ
        Route::post('/store',  [App\Http\Controllers\RecipeController::class, 'store'])->name('storeRecipe');           //レシピ新規登録

        // 作成者だけが操作できる。blade上で@canで制御
        Route::get('/edit/{id}', [App\Http\Controllers\RecipeController::class, 'editRecipe'])->name('editRecipe');     //レシピ編集へ
        Route::post('/update/{id}', [App\Http\Controllers\RecipeController::class, 'update'])->name('updateRecipe');    //レシピ編集
        Route::delete('/delete/{id}', [App\Http\Controllers\RecipeController::class, 'destroy'])->name('deleteRecipe'); //レシピ削除
    });

    // 【食材在庫データ関連】
    // -------------------------------------------------------------------------------------------------------------
    Route::prefix('food-records')->group(function () {
        Route::get('/create',  [App\Http\Controllers\FoodRecordController::class, 'viewCreate'])->name('createRecord'); //在庫入力へ
        Route::post('/store', [App\Http\Controllers\FoodRecordController::class, 'store'])->name('storeRecord'); //在庫の登録
        Route::get('/restockList',  [App\Http\Controllers\FoodRecordController::class, 'viewRestockList'])->name('restockList'); // 買い物リスト閲覧

        // 自分の在庫データのみ操作できる。
        // Route::group(['middleware'=> ['can:controlFoodRecord, foodRecord']], function() {
            Route::get('/index', [App\Http\Controllers\DateController::class, 'index'])->name('indexRecords'); //在庫一覧へ
            Route::get('/edit/{id}',  [App\Http\Controllers\FoodRecordController::class, 'viewEdit'])->name('editRecord'); //在庫編集へ
            Route::post('/update/{date}', [App\Http\Controllers\FoodRecordController::class, 'update'])->name('updateRecord'); //在庫の更新
            // Route::delete('/delete/{id}', [App\Http\Controllers\FoodRecordController::class, 'destroy'])->name('deleteRecord');
        // });
    });
});


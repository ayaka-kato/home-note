<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Process;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**--------------------------------------------------------
     * Request $request
     * 
     * レシピ登録画面表示
     * ------------------------------------------------------ */
    public function viewCreate()
    {
        return view('recipes.create');
    }

    /** ------------------------------------------------------
     * @param Request $request
     * レシピ登録・編集時のバリデーション
     * ------------------------------------------------------*/
    public function recipeValidate(Request $request)
    {
        // バリデーションするデータを$rulesに格納
        $rules = [
            'name' => 'required|string|max:100',
            'category' => 'string|max:10|nullable',
            'serving' => 'string|max:20|nullable',
            'link' => 'string|max:180|nullable',
        ];
        
        for ($i = 0; $i < 20; $i++) {
            $rules["ingredient-$i"] = "string|max:20|nullable";
            $rules["amount-$i"] = "string|max:20|nullable";
        }
        for ($j = 0; $j < 8; $j++) {
            $rules["process-$j"] = "string|max:20|nullable";
            $rules["detail-$j"] = "string|max:180|nullable";
        }
        // バリデーション
        $this->validate($request, $rules);
    }

    /** ------------------------------------------------------
     * 
     * 関連テーブルへの新規登録
     * ------------------------------------------------------*/
    public function relatedTableStore($request, $count, $firstColumn, $secondColumn, $table, $Table, $recipe){
        for($i = 0; $i < $count; $i++){
            $firstColumnKey = $firstColumn . '-' . $i;
            $secondColumnKey = $secondColumn . '-' . $i;

            if ($request->input($firstColumnKey) !== null || $request->input($secondColumnKey) !== null){
                $newData = new $Table([
                    $firstColumn => $request->input($firstColumnKey),
                    $secondColumn => $request->input($secondColumnKey),
                ]);
                $recipe->$table()->save($newData);
            }
        }
    }

    /** ------------------------------------------------------
     * Request $request
     * 
     * recipeValidate()
     * relatedTableStore()
     * レシピ新規登録
     * ------------------------------------------------------*/
    public function store(Request $request)
    {
        // バリデーション
        $this->recipeValidate($request);

        // 画像ファイルの処理
        $encodedBase64Str = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $encodedBase64Str = base64_encode(file_get_contents($file));

            // バイト数を調べる
            $byteSize = strlen(base64_decode($encodedBase64Str));

            if ($byteSize > 50000) { // 50 kilobytes = 50000 bytes。もし画像が50キロバイト以上だったら
                return redirect()->back()->withErrors(['image' => '画像サイズは50キロバイト以下で登録してください。'] );
            }
        }

        // ユーザー情報の取得
        $user = $request->user();

        // recipeテーブル登録
        $recipe = new Recipe([
            'name' => $request->name,
            'category' => $request->category,
            'serving' => $request->serving,
            'link' => $request->link,
            'image' => $encodedBase64Str,
        ]);
        $user->recipes()->save($recipe);

        // ingredientテーブル・processテーブルに登録
        $configs = [
            ['count' => 20, 'firstColumn' => 'ingredient', 'secondColumn' => 'amount', 'table' => 'ingredients', 'Table' => Ingredient::class],
            ['count' => 8, 'firstColumn' => 'process', 'secondColumn' => 'detail', 'table' => 'processes', 'Table' => Process::class],
        ];

        foreach ($configs as $config) {
            $this->relatedTableStore($request, $config['count'], $config['firstColumn'], $config['secondColumn'], $config['table'], $config['Table'], $recipe);
        }
        
        return redirect()->route('indexRecipes');
    }

    /** ------------------------------------------------------
     * Request $request
     * 
     * レシピ詳細画面
     * ------------------------------------------------------*/
    public function getRecipe(Request $request, $id)
    {
        $recipe = Recipe::find($id);
        $ingredients = $recipe->ingredients;
        $processes = $recipe->processes;

        return view('recipes.detail', compact('recipe','ingredients','processes'));        
    }

    /** ------------------------------------------------------
     * Request $request
     * 
     * レシピ編集画面
     * ------------------------------------------------------*/
    public function editRecipe(Request $request, $id)
    {
        $recipe = Recipe::find($id);
        $ingredients = $recipe->ingredients;
        $processes = $recipe->processes;

        return view('recipes.edit', compact('recipe','ingredients','processes'));       
    }

    /** ------------------------------------------------------
     * Request $request
     * 
     * レシピ検索
     * ------------------------------------------------------*/
    public function searchRecipes(Request $request)
    {
        // キーワード受け取り
        $keyword = $request->input('keyword');
        // クエリ作成
        $query = Recipe::query();
        
        // 関連する食材も一緒にロード(Foodモデルのリレーションをロードする)
        $query->with('ingredients');

        // もしキーワードがあったら
        if(!empty($keyword))
        {
            $query->where('name','like','%'.$keyword.'%');
            $query->orWhere('category','like','%'.$keyword.'%');

            // orWhereHas():RecipeモデルがリレーションしているIngredientモデルの中で条件を満たすレシピを探す
            $query->orWhereHas('ingredients',function($subQuery) use ($keyword){
                $subQuery->where('ingredient', 'like', '%' . $keyword . '%');
            });
        }

        // 全件取得
        $recipes = $query->orderBy('created_at','desc')->get();
        return view('recipes.index', compact('keyword','recipes'));
    }

    /** ------------------------------------------------------
     * 関連テーブルの更新・削除・登録
     * ------------------------------------------------------*/
    public function relatedTableUpdate($recipe, $count, $firstColumn, $secondColumn, $table, $Table, $request)
    {
        // 最初に各テーブルのデータを取得する。(for文の中で取得するとずれる)
        $tableArray = $recipe->$table()->get(); 

        for ($i = 0; $i < $count; $i++){
            $firstColumnKey = $firstColumn. '-' . $i; 
            $secondColumnKey = $secondColumn. '-' .$i; 

            // DBに登録がある場合(編集・削除)
            if(isset($tableArray[$i])){
                $arrayToUpdate = $tableArray[$i];

                // 編集：入力値がある
                if($request->input($firstColumnKey) !== null || $request->input($secondColumnKey) !== null){
                    $arrayToUpdate->update([
                        $firstColumn => $request->input($firstColumnKey),
                        $secondColumn => $request->input($secondColumnKey),
                    ]);

                // 削除：入力値がない
                }else {
                    $arrayToUpdate->delete();
                }

            // DBに登録がない場合（新規登録）
            }else {
                if ($request->input($firstColumnKey) !== null || $request->input($secondColumnKey) !== null) {
                    $addData = new $Table([
                        $firstColumn => $request->input($firstColumnKey),
                        $secondColumn => $request->input($secondColumnKey),
                    ]);
                    $recipe->$table()->save($addData);
                }
            }
        }
    }
    
    /** ------------------------------------------------------
     * Request $request
     * 
     * recipeValidate()
     * relatedTableUpdate()
     * レシピ編集
     * ------------------------------------------------------*/
    public function update(Request $request, $id)
    {
        // バリデーション
        $this->recipeValidate($request);

        // 画像ファイルの処理
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $encodedBase64Str = base64_encode(file_get_contents($file));

            // バイト数を調べる
            $byteSize = strlen(base64_decode($encodedBase64Str));

            if ($byteSize > 50000) { // 50 kilobytes = 50000 bytes。もし画像が50キロバイト以上だったら
                return redirect()->back()->withErrors(['image' => '画像サイズは50キロバイト以下で登録してください。'] );
            }
        }

        $user = $request->user();

        // recipesテーブルの更新
        $recipe = Recipe::where('id',$id)->first();
        $recipe->update([
            'name' => $request->name,
            'category' => $request->category,
            'serving' => $request->serving,
            'link' => $request->link,
        ]);

        // 画像ファイルの変更があれば更新する。
        if($request->hasFile('image')){
            $recipe->update([
                'image' =>  $encodedBase64Str
            ]);
        }

        // ingredientsテーブル・processテーブルの更新
        $this->relatedTableUpdate($recipe, 20, 'ingredient', 'amount', 'ingredients', Ingredient::class, $request);
        $this->relatedTableUpdate($recipe, 8, 'process', 'detail', 'processes', Process::class, $request);

        return redirect()->route('getRecipe', ['id' => $recipe->id ] );
    }

    /** ------------------------------------------------------
     * Request $request
     * 
     * レシピ削除
     * ------------------------------------------------------*/
    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();
        return redirect()->route('indexRecipes');
    }
}

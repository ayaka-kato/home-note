<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // TODO:あとでミドルウェアに書き換える
use App\Models\User;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Process;

class RecipeController extends Controller
{
    // TODO:後でミドルウェアに書き換える
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**--------------------------------------------------------
     * Request $request
     * 
     * レシピ一覧画面表示
    -------------------------------------------------------- */
    public function index()
    {
        // with()でrecipe_idに紐づくingredientsを取得
        $recipes = Recipe::with('ingredients')->orderBy('created_at', 'desc')->get();
        return view('recipe.index', compact('recipes'));
    }

    /**--------------------------------------------------------
     * Request $request
     * 
     * レシピ登録画面表示
    -------------------------------------------------------- */
    public function viewCreate()
    {
        return view('recipe.create');
    }


    /**
     * Request $request
     * 
     * レシピ新規登録
     */
    public function store(Request $request)
    {
        // バリデーションするデータを$rulesに格納
        $rules = [
            'name' => 'required|string|max:30',
            'category' => 'string|nullable',
            'serving' => 'string|max:255|nullable',
            'link' => 'string|max:255|nullable',
        ];
        
        for ($i = 0; $i < 20; $i++) {
            $rules["ingredient-$i"] = "string|max:255|nullable";
            $rules["amount-$i"] = "string|max:255|nullable";
        }
        for ($j = 0; $j < 8; $j++) {
            $rules["number-$j"] = "integer|nullable";
            $rules["process-$j"] = "string|max:255|nullable";
            $rules["detail-$j"] = "string|max:255|nullable";
        }

        // バリデーション
        $this->validate($request, $rules);

        // 画像ファイルの処理
        $encodedBase64Str = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $encodedBase64Str = base64_encode(file_get_contents($file));
        }

        $user = $request->user();

        $recipe = new Recipe([
            'name' => $request->name,
            'category' => $request->category,
            'serving' => $request->serving,
            'link' => $request->link,
            'image' => $encodedBase64Str,
        ]);

        $user->recipes()->save($recipe);

        // ingredientsテーブルへのデータの登録
        for ($i = 0; $i < 20; $i++) {
            $ingredientKey = "ingredient-$i";
            $amountKey = "amount-$i";

            if ($request->input($ingredientKey) !== null || $request->input($amountKey) !== null) {
                $ingredient = new Ingredient([
                    'ingredient' => $request->input($ingredientKey),
                    'amount' => $request->input($amountKey),
                ]);
                $recipe->ingredients()->save($ingredient);
            }
        }

        // processesテーブルへのデータの登録
        for ($j = 0; $j < 8; $j++) {
            $numberKey = "number-$j";
            $processKey = "process-$j";
            $detailKey = "detail-$j";

            if ($request->input($numberKey) !== null && ($request->input($processKey) !== null || $request->input($detailKey) !== null)) {
                $process = new Process([
                    'number' => $request->input($numberKey),
                    'process' => $request->input($processKey),
                    'detail' => $request->input($detailKey),
                ]);
                $recipe->processes()->save($process);
            }
        }
        return redirect('/index-recipes');
    }


    /**
     * Request $request
     * 
     * レシピ一件表示
     * ※呼び出し元によって表示先を変える。
     * ※一覧→詳細 / 詳細→編集
     */
    public function getRecipe(Request $request, $id)
    {
        $recipe = Recipe::find($id);
        $ingredients = $recipe->ingredients;
        $processes = $recipe->processes;

        // 遷移先が編集ページなら
        $toEditPage = request()->input('toEditPage');

        if($toEditPage){
            return view('recipe.edit', compact('recipe','ingredients','processes'));
        }else {
            return view('recipe.detail', compact('recipe','ingredients','processes'));
        }
    }

    /**
     * Request $request
     * 
     * レシピ検索
     */
    public function searchRecipes(Request $request)
    {
        // キーワード受け取り
        $keyword = $request->input('keyword');
        // クエリ作成
        $query = Recipe::query();
        
        // 関連する食材も一緒にロード(Foodモデルのリレーションをロードする)
        $query->with('foods');

        // もしキーワードがあったら
        if(!empty($keyword))
        {
            $query->where('name','like','%'.$keyword.'%');
            $query->orWhere('category','like','%'.$keyword.'%');

            // orWhereHas():RecipeモデルがリレーションしているFoodモデルの中で条件を満たすレシピを探す
            $query->orWhereHas('foods',function($subQuery) use ($keyword){
                $subQuery->where('name', 'like', '%' . $keyword . '%');
            });
        }

        // 全件取得
        $recipes = $query->orderBy('created_at','desc')->get();
        return view('recipe.searchResult', compact('keyword','recipes'));
    }


    /**
     * TODO:
     * Request $request
     * 
     * レシピ編集
     */
    public function update(Request $request, $id)
    {
        // バリデーションするデータを$rulesに格納
        $rules = [
            'name' => 'required|string|max:30',
            'category' => 'string|nullable',
            'serving' => 'string|max:255|nullable',
            'link' => 'string|max:255|nullable',
        ];
        
        for ($i = 0; $i < 20; $i++) {
            $rules["ingredient-$i"] = "string|max:255|nullable";
            $rules["amount-$i"] = "string|max:255|nullable";
        }
        for ($j = 0; $j < 8; $j++) {
            $rules["number-$j"] = "integer|nullable";
            $rules["process-$j"] = "string|max:255|nullable";
            $rules["detail-$j"] = "string|max:255|nullable";
        }

        // バリデーション
        $this->validate($request, $rules);

        // 画像ファイルの処理
        $encodedBase64Str = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $encodedBase64Str = base64_encode(file_get_contents($file));
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

        // ingredientsテーブルの更新
        for ($i = 0; $i < 20; $i++) {
            $ingredientKey = "ingredient-$i";
            $amountKey = "amount-$i";

            if ($request->filled($ingredientKey) || $request->filled($amountKey) ) {
                $recipe->ingredients()->where('id', $id)->update([
                    'ingredient' => $request->input($ingredientKey),
                    'amount' => $request->input($amountKey),
                ]);
                $recipe->ingredients()->save($ingredient);
            }
        }

        // processesテーブルの更新
        for ($j = 0; $j < 8; $j++) {
            $processKey = "process-$j";
            $detailKey = "detail-$j";

            if ($request->input($processKey) !== null || $request->input($detailKey) !== null) {
                $recipe->processes()->where('id', $id)->update([
                    'process' => $request->input($processKey),
                    'detail' => $request->input($detailKey),
                ]);
                $recipe->processes()->save($process);
            }
        }

        return redirect('detail-recipe');
    }

    /**
     * Request $request
     * 
     * レシピ削除
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();
        return redirect('index-recipes');
    }


}

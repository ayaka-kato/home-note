<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // TODO:あとでミドルウェアに書き換える
use App\Models\Food;
use App\Models\Recipe;

class recipeController extends Controller
{
    // TODO:後でミドルウェアに書き換える
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Request $request
     * 
     * レシピ新規登録
     */
    public function store(Request $request){

        // key名.* で配列のバリデーションができる
        $this->validate($request, [
            'name' => 'required|string|max:30',
            'category' => 'string|nullable',
            'food.*' => 'integer|nullable',
            'link' => 'string|max:255|nullable',
            'heading-0' => 'string|max:255|nullable',
            'heading-1' => 'string|max:255|nullable',
            'heading-2' => 'string|max:255|nullable',
            'heading-3' => 'string|max:255|nullable',
            'heading-4' => 'string|max:255|nullable',
            'heading-5' => 'string|max:255|nullable',
            'heading-6' => 'string|max:255|nullable',
            'heading-7' => 'string|max:255|nullable',
            'detail-0' => 'string|max:255|nullable',
            'detail-1' => 'string|max:255|nullable',
            'detail-2' => 'string|max:255|nullable',
            'detail-3' => 'string|max:255|nullable',
            'detail-4' => 'string|max:255|nullable',
            'detail-5' => 'string|max:255|nullable',
            'detail-6' => 'string|max:255|nullable',
            'detail-7' => 'string|max:255|nullable',
        ]);

        $encodedBase64Str = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $encodedBase64Str = base64_encode(file_get_contents($file));
        }

        $recipe = $request->user()->recipes()->create([
            'name' => $request->name,
            'category' => $request->category,
            'link' => $request->link,
            'image' => $encodedBase64Str,
            'heading_0' => $request->input('heading-0'),
            'heading_1' => $request->input('heading-1'),
            'heading_2' => $request->input('heading-2'),
            'heading_3' => $request->input('heading-3'),
            'heading_4' => $request->input('heading-4'),
            'heading_5' => $request->input('heading-5'),
            'heading_6' => $request->input('heading-6'),
            'heading_7' => $request->input('heading-7'),
            'detail_0' => $request->input('detail-0'),
            'detail_1' => $request->input('detail-1'),
            'detail_2' => $request->input('detail-2'),
            'detail_3' => $request->input('detail-3'),
            'detail_4' => $request->input('detail-4'),
            'detail_5' => $request->input('detail-5'),
            'detail_6' => $request->input('detail-6'),
            'detail_7' => $request->input('detail-7'),
        ]);


        // recipe Tableにfoodを保存したい時
        // $i = 0;
        // foreach ($Foods as $Food) {
        //     $recipe->{'food_' . $i} = $Food;
        //     $i++;
        // }
        
        // $recipe->save();



        // $request->input('select-food') で選択された食材の配列にアクセスできます
        $Foods = $request->input('food');

        // 選択された食材の配列をレシピに関連付ける
        // sync() :中間テーブルを使用して多対多の関連を更新するためのメソッド
        $recipe->foods()->sync($Foods);

        return redirect('/index-recipes');
    }

    /**
     * Request $request
     * 
     * 食材データを取得する
     */
    public function getFoods()
    {
        // 食材のカテゴリを取得（typeカラムのみを配列で取得）
        $types = Food::distinct()->pluck('type')->toArray();

        // 読み仮名であいうえお順で取得
        $foods = Food::orderBy('read', 'asc')->get();
        return view('recipe.create', compact('types','foods'));
    }

    /**
     * Request $request
     * 
     * レシピ一覧表示
     */
    public function index()
    {
        $recipes = Recipe::orderBy('created_at', 'desc')->get();
        return view('recipe.index', compact('recipes'));
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

        // 食材のカテゴリを取得（typeカラムのみを配列で取得）
        $types = Food::distinct()->pluck('type')->toArray();

        // 読み仮名であいうえお順で取得
        $foods = Food::orderBy('read', 'asc')->get();

        // 遷移先が編集ページなら
        $toEditPage = request()->input('toEditPage');

        if($toEditPage){
            return view('recipe.edit', compact('recipe','types','foods'));
        }else {
            return view('recipe.detail', compact('recipe'));
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
    public function edit()
    {
        
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

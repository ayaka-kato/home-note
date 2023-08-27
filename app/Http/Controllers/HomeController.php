<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Date;
use App\Models\Recipe;
use App\Models\FoodRecord;
// use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * 廃棄食品ランキング・おすすめメニュー表示
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showInfo()
    {
        // ロスの多かった食材のランキング表示
        // -------------------------------------------
        $user = Auth::user();
        // 集計する期間を取得
        $start_date = now()->startOfMonth()->format('Y-m-d');  // 今月の始まりの日付
        $end_date = now()->endOfMonth()->format('Y-m-d');


        $rankings = Date::join('food_records','dates.id','food_records.date_id')
            ->where('dates.user_id', Auth::id()) // ユーザーの特定・日付データが取得できる
            ->whereBetween('dates.date',  [$start_date, $end_date]) //日付の特定
            ->groupBy('ingredient') //
            ->select('ingredient', DB::raw('SUM(waste_amount) as total_waste'))
            ->orderByDesc('total_waste')
            ->limit(3)
            ->get();

        // ロスが一番多い食材を含むレシピを表示
        // -------------------------------------------
        // $rankingの食材を含むレシピを取得
        if (count($rankings) > 0 && count($rankings[0]->foodRecords) > 0) {
            $mostWastedIngredient = $rankings[0]->foodRecords[0]->ingredient;

            $useUpRecipes = Recipe::whereHas('ingredients', function ($query) use ($mostWastedIngredient) {
                $query->where('ingredient', $mostWastedIngredient);
            })
            ->inRandomOrder()
            ->limit(2)
            ->get();

            // $useUpRecipesのレシピIDを取得
            $useUpRecipesIds = $useUpRecipes->pluck('id');


            // 直近の在庫データで、在庫が多い食材を含むレシピをおすすめとして表示
            // -------------------------------------------
            // 一番新しいdate_idから食材在庫のレコードを取得
            $latestStocks = $user->dates()->foodRecords()
            ->select('ingredient', DB::raw('MAX(date_id) as latest_date_id'))
            ->groupBy('ingredient')
            ->get();
        
            // 食材テーブルと在庫データテーブルで名前が一致する食材を含むレシピを取得
            $recommendRecipes = Recipe::whereIn('id', function ($query) use ($latestStocks, $useUpRecipesIds) {
                $query->select('recipe_id')
                    ->from('ingredients')
                    // pluck():コレクション内の要素の特定のカラムの値を取得する。
                    ->whereIn('ingredient', $latestStocks->pluck('ingredient')) // 食材テーブルの食材名と、直近の在庫レコードの食材名が一致するものを取得
                    ->whereNotIn('recipe_id', $useUpRecipesIds) // すでに$useUpRecipesに含まれているレシピは除く
                    ->get();
            })
            ->inRandomOrder()
            ->limit(2)
            ->get();

            return view('home', compact('rankings', 'start_date', 'end_date', 'useUpRecipes', 'recommendRecipes'));

        }else {
            $rankings = collect(); 
            $useUpRecipes = collect(); 
            $recommendRecipes = Recipe::inRandomOrder()
                ->limit(3)
                ->get();
            return view('home', compact('rankings', 'start_date', 'end_date', 'useUpRecipes', 'recommendRecipes'));
        }
    }
}
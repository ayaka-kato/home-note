<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
        // 集計する期間を取得
        $now = now();  // 現在日時を取得
        $start_date = $now->startOfMonth()->format('Y-m-d');  // 今月の始まりの日付
        $end_date = $now->endOfMonth()->format('Y-m-d');

        // 期間中に一番廃棄数が多かった食材を取得
        $rankings = DB::table('food_records')
        ->join('dates', 'food_records.date_id', '=', 'dates.id') 
        ->whereBetween('dates.date', [$start_date, $end_date]) // カラムが指定した期間内に収まるように結果を制限
        ->groupBy('ingredient')
        ->select('ingredient', DB::raw('SUM(waste_amount) as total_waste'))
        ->orderByDesc('total_waste')
        ->limit(3)
        ->get();

        // ロスが一番多い食材を含むレシピを表示
        // -------------------------------------------
        // $rankingの食材を含むレシピを取得
        $mostWastedIngredient = $rankings[0]->ingredient;

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
        $latestStocks = DB::table('food_records')
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
    }
}
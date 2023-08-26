<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Date;
use App\Models\Recipe;
use App\Models\FoodRecord;
use Carbon\Carbon;

class FoodRecordController extends Controller
{

    // TODO:後でミドルウェアに書き換える
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 
     * 累計データ表示
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

    /**
     * 
     * 食材データ新規入力画面表示
     */
    public function viewNewCreate()
    {
        return view('food-records.create');
    }

    /**
     * 
     * 食材データ入力画面表示
     */
    public function viewReferenceCreate()
    {
        // 当日の登録データを取得する
        $today = date('Y-m-d');
        $user = Auth::user();
        $date = $user->dates()->whereDate('created_at', $today)->first();
        // 過去最新のレコードを取得する
        $latestDate = $user->dates()->latest('created_at')->first();

        
        // 本日の在庫データの登録がすでにあれば、
        if ($date){
            $foodRecords = $date->foodRecords()->get();
            return view('food-records.edit', compact('foodRecords', 'date'));

        // 本日の在庫データが未登録で,過去のレコードがあれば
        }elseif ($latestDate) {
            $foodRecords = $latestDate->foodRecords()->get();
            return view('food-records.referenceCreate', compact('foodRecords', 'today'));

        // 過去のレコードが無ければ
        }else {
            return redirect()->route(createNewRecord);
        }
    }

    /**
     * Request $request
     * 
     * バリデーション
     */
    public function recordValidate(Request $request)
    {
        $rules = [];
        
        for ($i = 0; $i < 50; $i++) {
            $rules["order-$i"] = "integer";
            $rules["color-$i"] = "string|nullable";
            $rules["ingredient-$i"] = "string|max:30|nullable";
            $rules["ideal-amount-$i"] = "string|max:30|nullable";
            $rules["real-amount-$i"] = "integer|max:5|nullable";
            $rules["waste-amount-$i"] = "integer|max:5|nullable";
            $rules["restock-amount-$i"] = "string|max:100|nullable";
        }

        $this->validate($request, $rules);
    }

    /**
     * Request $request
     * 
     * 新規登録
     */
    public function store(Request $request)
    {
        $this->recordValidate($request); 

        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $dateModel = $user->dates()->firstOrCreate(['date' => $date]);

        for($i = 0; $i < 50; $i++){
            $orderKey =  'order-' . $i;
            $colorKey =  'color-' . $i;
            $ingredientKey =  'ingredient-' . $i;
            $idealAmountKey =  'ideal-amount-' . $i;
            $realAmountKey =  'real-amount-' . $i;
            $wasteAmountKey =  'waste-amount-' . $i;
            $restockAmountKey =  'restock-amount-' . $i;

            if($request->input($ingredientKey) !== null && $request->input($idealAmountKey) !== null && $request->input($realAmountKey) !== null){
                $record = new FoodRecord([
                    'order' => $request->input($orderKey),
                    'color' => $request->input($colorKey),
                    'ingredient' => $request->input($ingredientKey),
                    'ideal_amount' => $request->input($idealAmountKey),
                    'real_amount' => $request->input($realAmountKey),
                    'waste_amount' => $request->input($wasteAmountKey),
                    'restock_amount' => $request->input($restockAmountKey),
                ]);

                // リレーション登録
                $dateModel->foodRecords()->save($record);
            }
        }
        return redirect()->route('indexRecords');
    }  

    /**
     * 
     * 食材データ詳細画面表示
     */
    public function getRecord($id)
    {
        $date = Date::find($id);
        $foodRecords = FoodRecord::where('date_id', $id)->orderBy('order','asc')->get();
        return view('food-records.detail', compact('foodRecords', 'date'));
    }    

    /**
     * 
     * 食材データ編集画面表示
     */
    public function viewEdit($id)
    {
        $date = Date::find($id);
        $foodRecords = FoodRecord::where('date_id', $id)->orderBy('order','asc')->get();
        return view('food-records.edit', compact('foodRecords', 'date'));
    }


    /**
     * Request $request
     * 
     * 編集
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $this->recordValidate($request);

        // DBに登録されているレコードの取得($foodRecords)
        $date = Date::find($id);
        $foodRecords = $date->foodRecords;

        // 順番の配列を取得($order)
        $recordCount = count($request->all());
        $order = array();
        for($i = 0; $i < $recordCount; $i++){
            $orderKey = 'order-' . $i;
            if($request->input($orderKey) != null){
                $order[] = $request->input($orderKey);
            }
        }
        
        // 並び替え順にデータを更新
        foreach ($order as $index) {

            // DBにレコードがある場合（更新・削除）
            if (isset($foodRecords[$index])){
                $record = $foodRecords[$index];
                $dltFrag = $request->input('dlt-frag-' . $index);

                $orderKey =  'order-' . $index;
                $colorKey =  'color-' . $index;
                $ingredientKey =  'ingredient-' . $index;
                $idealAmountKey =  'ideal-amount-' . $index;
                $realAmountKey =  'real-amount-' . $index;
                $wasteAmountKey =  'waste-amount-' . $index;
                $restockAmountKey =  'restock-amount-' . $index;

                
                // delete-frag=0であれば更新
                if($dltFrag == 0){
                    if ($request->input($ingredientKey) !== null || $request->input($idealAmountKey) !== null || $request->input($realAmountKey) !== null) {
                        // fillメソッドを使用して更新
                        $record->fill([
                            'order' => $request->input($orderKey),
                            'color' => $request->input($colorKey),
                            'ingredient' => $request->input($ingredientKey),
                            'ideal_amount' => $request->input($idealAmountKey),
                            'real_amount' => $request->input($realAmountKey),
                            'waste_amount' => $request->input($wasteAmountKey),
                            'restock_amount' => $request->input($restockAmountKey),
                        ])->save();
                    }

                // delete-frag=1であれば削除
                }else {
                    $record->delete();

                }          

            // DBにレコードがない場合（新規登録）
            }else {
                    $orderKey =  'order-' . $index;
                    $colorKey =  'color-' . $index;
                    $ingredientKey =  'ingredient-' . $index;
                    $idealAmountKey =  'ideal-amount-' . $index;
                    $realAmountKey =  'real-amount-' . $index;
                    $wasteAmountKey =  'waste-amount-' . $index;
                    $restockAmountKey =  'restock-amount-' . $index;

                    if($request->input($ingredientKey) !== null || $request->input($idealAmountKey) !== null || $request->input($realAmountKey) !== null){
                        FoodRecord::create([
                            'date_id' => $date->id,
                            'order' => $request->input($orderKey),
                            'color' => $request->input($colorKey),
                            'ingredient' => $request->input($ingredientKey),
                            'ideal_amount' => $request->input($idealAmountKey),
                            'real_amount' => $request->input($realAmountKey),
                            'waste_amount' => $request->input($wasteAmountKey),
                            'restock_amount' => $request->input($restockAmountKey),
                        ]);
                    }
            }
        }
        return redirect()->route('indexRecords');
    }

    /**
     * Request $request
     * 
     * 買い物リスト表示
     */
    public function viewRestockList() {

        $latestRecord = FoodRecord::latest('created_at')->first();
        $date = $latestRecord->created_at->format('Y-m-d');

        $foodRecords = FoodRecord::whereDate('created_at', $date)
            ->where(function($query){
                $query->whereNotNull('restock_amount');
            })
            ->get();

        return view('food-records.restockList', compact('foodRecords', 'date'));
    }   

}
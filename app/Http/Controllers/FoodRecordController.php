<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use App\Models\User;
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
     * 一覧表示
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $foodRecords = $user->foodRecords()
            ->select(DB::raw('DATE(created_at) as date'))
            ->addSelect(DB::raw('MAX(updated_at) as latest_update'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('latest_update', 'desc') 
            ->get();
    
        return view('food-records.index', compact('foodRecords'));
    }
    

    /**
     * 
     * 食材データ入力画面表示
     */
    public function viewCreate()
    {
        return view('food-records.create');
    }

    
    /**
     * 
     * 食材データ編集画面表示
     */
    public function viewEdit($date)
    {
        $foodRecords = FoodRecord::whereDate('created_at', $date)
        ->get();

    return view('food-records.edit', compact('foodRecords','date'));
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

        $userId = Auth::id(); 

        for($i = 0; $i < 50; $i++){
            $colorKey =  'color-' . $i;
            $ingredientKey =  'ingredient-' . $i;
            $idealAmountKey =  'ideal-amount-' . $i;
            $realAmountKey =  'real-amount-' . $i;
            $wasteAmountKey =  'waste-amount-' . $i;
            $restockAmountKey =  'restock-amount-' . $i;

            if($request->input($ingredientKey) !== null && $request->input($idealAmountKey) !== null && $request->input($realAmountKey) !== null){
                FoodRecord::create([
                    'user_id' => $userId,
                    'color' => $request->input($colorKey),
                    'ingredient' => $request->input($ingredientKey),
                    'ideal_amount' => $request->input($idealAmountKey),
                    'real_amount' => $request->input($realAmountKey),
                    'waste_amount' => $request->input($wasteAmountKey),
                    'restock_amount' => $request->input($restockAmountKey),
                ]);
            }
        }
        return redirect()->route('indexRecords');
    }

    /**
     * Request $request
     * 
     * 編集
     */
    public function update(Request $request, $date)
    {
        // バリデーション
        $this->recordValidate($request);

        // 日付部分だけで絞るためにwhereDate()を使う
        $foodRecords = FoodRecord::whereDate('created_at', $date)->get();
        
        foreach ($foodRecords as $index => $record) {
            $colorKey =  'color-' . $index;
            $ingredientKey =  'ingredient-' . $index;
            $idealAmountKey =  'ideal-amount-' . $index;
            $realAmountKey =  'real-amount-' . $index;
            $wasteAmountKey =  'waste-amount-' . $index;
            $restockAmountKey =  'restock-amount-' . $index;
    
            // 更新する時
            if ($request->input($ingredientKey) !== null || $request->input($idealAmountKey) !== null || $request->input($realAmountKey) !== null) {
                $record->update([
                    'color' => $request->input($colorKey),
                    'ingredient' => $request->input($ingredientKey),
                    'ideal_amount' => $request->input($idealAmountKey),
                    'real_amount' => $request->input($realAmountKey),
                    'waste_amount' => $request->input($wasteAmountKey),
                    'restock_amount' => $request->input($wasteAmountKey),
                ]);

            // 削除する時
            } else {
                $record->delete();
            }
        }

        // DBに登録済みのデータがない場合
        for($i = $foodRecords->count(); $i < 50; $i++ ){
            $colorKey =  'color-' . $i;
            $ingredientKey =  'ingredient-' . $i;
            $idealAmountKey =  'ideal-amount-' . $i;
            $realAmountKey =  'real-amount-' . $i;
            $wasteAmountKey =  'waste-amount-' . $i;
            $restockAmountKey =  'restock-amount-' . $i;

            if($request->input($ingredientKey) !== null || $request->input($idealAmountKey) !== null || $request->input($realAmountKey) !== null){
                FoodRecord::create([
                    'color' => $request->input($colorKey),
                    'ingredient' => $request->input($ingredientKey),
                    'ideal_amount' => $request->input($idealAmountKey),
                    'real_amount' => $request->input($realAmountKey),
                    'waste_amount' => $request->input($wasteAmountKey),
                    'restock_amount' => $request->input($restockAmountKey),
                ]);
            }
        }
        return redirect()->route('indexRecords');
    }

    /**
     * Request $request
     * 
     * 買い物リスト更新
     */
    public function viewRestockList() {
        $today = Carbon::now()->format('Y-m-d');
        $foodRecords = FoodRecord::whereDate('created_at',$today)
            ->where(function($query){
                $query->where('real_amount', '0')
                      ->orWhere('real_amount', '1');
            })
            ->get();

        return view('food-records.restockList', compact('foodRecords'));
    }   

    /**
     * Request $request
     * 
     * 削除
     */
    public function destroy($id)
    {
        $food = Food::find($id);
        $food->delete();
        return redirect()->route('indexRecords');
    }
}
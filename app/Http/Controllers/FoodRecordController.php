<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Date;
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
     * 食材データ入力画面表示
     */
    public function viewCreate()
    {
        return view('food-records.create');
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

        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $dateModel = $user->dates()->firstOrCreate(['date' => $date]);

        for($i = 0; $i < 50; $i++){
            $colorKey =  'color-' . $i;
            $ingredientKey =  'ingredient-' . $i;
            $idealAmountKey =  'ideal-amount-' . $i;
            $realAmountKey =  'real-amount-' . $i;
            $wasteAmountKey =  'waste-amount-' . $i;
            $restockAmountKey =  'restock-amount-' . $i;

            if($request->input($ingredientKey) !== null && $request->input($idealAmountKey) !== null && $request->input($realAmountKey) !== null){
                $record = new FoodRecord([
                    'color' => $request->input($colorKey),
                    'ingredient' => $request->input($ingredientKey),
                    'ideal_amount' => $request->input($idealAmountKey),
                    'real_amount' => $request->input($realAmountKey),
                    'waste_amount' => $request->input($wasteAmountKey),
                    'restock_amount' => $request->input($restockAmountKey),
                ]);

                $dateModel->foodRecords()->save($record);
            }
        }
        return redirect()->route('indexRecords');
    }  
    
    /**
     * 
     * 食材データ編集画面表示
     */
    public function viewEdit($id)
    {
        $date = Date::find($id);
        $foodRecords = FoodRecord::whereDate('date_id', $id)->get();
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

        $date = Date::find($id);
        $foodRecords = $date->foodRecords;
        
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
                    'restock_amount' => $request->input($restockAmountKey),
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
                    'date_id' => $date->id,
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
        $latestRecord = FoodRecord::latest('created_at')->first();
        $latestDate = $latestRecord->created_at->format('Y-m-d');

        $foodRecords = FoodRecord::whereDate('created_at', $latestDate)
            ->where(function($query){
                $query->whereNotNull('restock_amount');
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
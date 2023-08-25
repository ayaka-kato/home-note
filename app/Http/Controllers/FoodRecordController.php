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
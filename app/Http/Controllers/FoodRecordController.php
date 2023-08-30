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

    public function __construct()
    {
        $this->middleware('auth');
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
            return redirect()->route('createNewRecord');
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
            $rules["color-$i"] = "string|max:10|nullable";
            $rules["ingredient-$i"] = "string|max:20|nullable";
            $rules["ideal-amount-$i"] = "string|max:50|nullable";
            $rules["real-amount-$i"] = "integer|max:2|nullable";
            $rules["waste-amount-$i"] = "integer|max:2|nullable";
            $rules["restock-amount-$i"] = "string|max:50|nullable";
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
    public function viewRestockList() 
    {
        $user = Auth::user();
        $latestDate = $user->dates()->latest('created_at')->first();

        if ($latestDate){
            $date = $latestDate->created_at->format('Y-m-d');
            $foodRecords = $latestDate->foodRecords()
            ->where(function($query){
                $query->whereNotNull('restock_amount');
            })
            ->get();

            return view('food-records.restockList', compact('foodRecords', 'date'));
        }else {
            $date = date('Y-m-d');
            $foodRecords = collect(); // 空のコレクションを代入
            return view('food-records.restockList',compact('foodRecords', 'date'));
        }
    }   

}
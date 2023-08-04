<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Food;
use App\Models\User;
use Illuminate\Validation\Rule;

class foodController extends Controller
{
    /**
     * Request $request
     * 
     * 新規登録
     */
    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required | string | max:30 | unique:foods',
            'read' => 'nullable|string | max:30',
            'type' => 'required|string',
            'text' => 'nullable|string | max:100',
        ]);
        // dd($request->name,$request->read,$request->text);

        // Food::create([
        //     'name' => $request->name,
        //     'read' => $request->read,
        //     'text' => $request->text,
        // ]);

        // 上のやり方でダメな時は(tableが見つからないなどのエラーが出る)
        $food = new Food();
        $food->name = $request->name;
        $food->read = $request->read;
        $food->type = $request->type;
        $food->text = $request->text;
        $food->save();

        // 続けて入力するか確認するためのJavaScriptで設定した値を判定
        if ($request->input('continue_input') == 1) {
            return redirect('/create-food');
        } else {
            return redirect('/index-foods');
        }
    }

    /**
     * 
     * 一覧表示
     */
    public function index()
    {
        $foods = Food::all();

        return view('food.index',compact('foods'));
    }

    /**
     * Request $request
     * 
     * 食材1件取得
     */
    public function getFood($id)
    {
        $food = Food::find($id);
        return view('food.edit', compact('food'));
    }

    /**
     * Request $request
     * 
     * 食材検索
     */
    public function searchFoods(Request $request)
    {
        // キーワード受け取り
        $keyword = $request->input('keyword');
        // クエリ作成
        $query = Food::query();

        // もしキーワードがあったら
        if(!empty($keyword))
        {
            $query->where('name','like','%'.$keyword.'%');
            $query->orWhere('read','like','%'.$keyword.'%');
        }

        // 全件取得
        $foods = $query->orderBy('read','asc')->get();
        return view('food.searchResult', compact('keyword','foods'));
    }


    /**
     * Request $request
     * 
     * 食材編集
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'max:30',
                Rule::unique('foods')->ignore($request->id),
            ],
            'read' => 'nullable|string|max:30',
            'type' => 'required|string',
            'text' => 'nullable|string|max:100',
        ]);

        $food = Food::where('id', $id)->first();
        $food->update([
            'name' => $request->name,
            'read' => $request->read,
            'type' => $request->type,
            'text' => $request->text,
        ]);

        return redirect()->to('/index-foods');
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
        return redirect('index-foods');
    }
}

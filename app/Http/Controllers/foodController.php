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
            'read' => 'string | max:30',
            'text' => 'string | max:100',
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
        $food->text = $request->text;
        $food->save();

        return redirect()->back();
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
        // dd($food);
        return view('food.edit', compact('food'));
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
            'read' => 'string|max:30',
            'text' => 'string|max:100',
        ]);

        $food = Food::where('id', $id)->first();
        $food->update([
            'name' => $request->name,
            'read' => $request->read,
            'text' => $request->text,
        ]);

        return redirect('/index-foods');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Recipe;

class recipeController extends Controller
{
    /**
     * Request $request
     * 
     * 新規登録
     */
    public function store(Request $request){

        $this->validate($request, [
            'image' => 'integer',
            'name' => 'string | max:30',
            'link' => 'string | max:100',
            'food_id' => 'string | max:100',
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

        return redirect('/index-recipes');
    }

    /**
     * Request $request
     * 
     * 一覧表示
     */
    public function index()
    {
        
    }

    /**
     * Request $request
     * 
     * 編集
     */
    public function edit()
    {
        
    }

    /**
     * Request $request
     * 
     * 削除
     */
    public function delete()
    {
        
    }


}

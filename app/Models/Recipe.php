<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    public function joinFoodOnRecipe()
    {
        // テーブルとテーブルをインナージョイン(結合)する
        $foods = Food::join('recipes', function($join) {
            $join->on('foods.recipe_id', '=', 'recipes.id');
        })
        ->get();

        // ここで取得したデータをビューに渡すなど、適切な処理を行う
        // 書き換える
        return view('your-view', compact('foods'));
    }

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'name',
        'category',
        'link',
        'image',
        'heading_0',
        'heading_1',
        'heading_2',
        'heading_3',
        'heading_4',
        'heading_5',
        'heading_6',
        'heading_7',
        'detail_0',
        'detail_1',
        'detail_2',
        'detail_3',
        'detail_4',
        'detail_5',
        'detail_6',
        'detail_7',
    ];

    // Recipe ModelがFood Modelのデータを取得できるコードを記述
    // Food は複数のRecipeに関連付けられる（Many-to-Many）
    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }

    // user は複数のrecipeを保持している
    public function user()
    {
        return $this->belongTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    // ---------------------------
    // 登録カラム
    // ---------------------------
    // ※リレーションで繋ぐカラムは記述しなくてよい
    protected $fillable = [
        'ingredient',
        'amount',
    ];

    // ---------------------------
    // リレーション
    // ---------------------------
    // レシピと食材は一対多の関係。
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

}

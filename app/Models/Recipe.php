<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    // ---------------------------
    // 登録カラム
    // ---------------------------
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'serving',
        'link',
        'image',
    ];

    // ---------------------------
    // リレーション
    // ---------------------------
    // ユーザーとレシピは一対多の関係
    public function user()
    {
        return $this->belongTo(User::class);
    }

    // レシピと食材は一対多の関係。
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    // レシピと手順は一対多の関係。
    public function processes()
    {
        return $this->hasMany(Process::class);
    }
}

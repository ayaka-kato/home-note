<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    // ---------------------------
    // 登録カラム
    // ---------------------------
    // ※リレーションで繋ぐカラムは記述しなくてよい
    protected $fillable = [
        'process',
        'detail',
    ];
    

    // ---------------------------
    // リレーション
    // ---------------------------
    // レシピと手順は一対多の関係。
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}

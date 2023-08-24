<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
    ];

    // ---------------------------
    // リレーション
    // ---------------------------
    // 日付とレコードは一対多の関係
    public function user()
    {
        return $this->belongTo(User::class);
    }
    // レコードと日付は一対多の関係
    public function FoodRecords()
    {
        return $this->hasMany(FoodRecord::class);
    }
}

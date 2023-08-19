<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRecord extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];

    protected $fillable = [
        'ingredient',
        'ideal_amount',
        'real_amount',
        'waste_amount',
        'restock_amount',
    ];

    // ---------------------------
    // リレーション
    // ---------------------------
    // ユーザーとレコードは一対多の関係
    public function user()
    {
        return $this->belongTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRecord extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];

    protected $fillable = [
        'ideal-amount',
        'real-amount',
        'waste-amount',
        'restock-amount',
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

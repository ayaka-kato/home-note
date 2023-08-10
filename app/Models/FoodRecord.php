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

    // FoodRecord ModelがFood Modelのデータを取得できるコードを記述
    // Food は複数のFoodRecordに関連付けられる（Many-to-Many）
    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }

    // user は複数のfood-recordを保持している
    public function user()
    {
        return $this->belongTo(User::class);
    }
}

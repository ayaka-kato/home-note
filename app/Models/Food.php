<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];
    protected $table = "foods";
    
    protected $fillable = [
        'name',
        'read',
        'type',
        'text',
    ];

    // ↓Food Modelからrecipeデータを取得できるコードを記述
    // Food は複数のRecipeに関連付けられる（Many-to-Many）
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }

    // ↓FoodRecord Modelからfoodrecordデータを取得できるコードを記述
    // Food は複数のRecipeに関連付けられる（Many-to-Many）
    public function food_records()
    {
        return $this->belongsToMany(FoodRecord::class);
    }
}

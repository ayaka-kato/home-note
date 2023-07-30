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
        'text',
    ];

    // ↓Food Modelからrecipeデータを取得できるコードを記述
    // foodはrecipeに所属する

    /**
     * 食材を保持するレシピの取得
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}

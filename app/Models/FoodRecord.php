<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_id',
        'color',
        'ingredient',
        'ideal_amount',
        'real_amount',
        'waste_amount',
        'restock_amount',
    ];

    // 更新イベントリスナーの登録
    // モデルが保存・更新される前後の処理を追加するために使う
    protected static function boot()
    {
        // 親クラス(Model)のbootメソッドを呼び出す
        parent::boot();

        static::updating(function ($foodRecord) {
            // 関連するdateレコードを取得
            $date = $foodRecord->date;

            // dateレコードのupdated_atを更新
            if ($date) {
                // touch():updated_atを現在の日時に更新するための関数
                $date->touch(); // updated_atを現在時刻に更新
            }
        });
    }

    // ---------------------------
    // リレーション
    // ---------------------------
    // 日付とレコードは一対多の関係
    public function date()
    {
        return $this->belongsTo(Date::class);
    }
}

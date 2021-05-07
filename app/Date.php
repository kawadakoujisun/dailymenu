<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;  // 追加

class Date extends Model
{
    use SoftDeletes;  //　論理削除
    
    protected $fillable = [
        'date',
    ];
    
    /**
     * このDateを所有するDish。（Dishモデルとの関係を定義）
     */
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
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

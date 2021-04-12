<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'image_public_id',
    ];
    
    /**
     * このDishが所有するDate。（Dateモデルとの関係を定義）
     */
    public function dates()
    {
        return $this->hasMany(Date::class);
    }
}

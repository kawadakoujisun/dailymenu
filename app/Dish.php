<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;  // 追加

class Dish extends Model
{
    use SoftDeletes;  //　論理削除
    
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
    
    /**
     * このDishが所有するRequestCount。（RequestCountモデルとの関係を定義）
     */
    public function requestCount()
    {
        return $this->hasOne(RequestCount::class);
    }
    
    /**
     * モデルの「初期起動」メソッド
     * をオーバーライドする
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // deletedイベントにて、Dishが論理削除されたときにそれが所有するDateの論理削除も行う。
        static::deleted(function ($dish) {
            $dish->dates()->delete();
        });
    }
}

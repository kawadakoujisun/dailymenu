<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestCount extends Model
{
    protected $fillable = [
        'request_count',
        'total_request_count',
    ];
    
    /**
     * このRequestCountを所有するDish。（Dishモデルとの関係を定義）
     */
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
    
    /**
     * リクエストカウントをリセットする
     * request_countのみ0にし、total_request_countは変更しない。
     */
    public function resetRequestCount()
    {
        $this->request_count = 0;
    }

    /**
     * リクエストカウントを増やして、データベースに保存まで行う
     * request_count、total_request_countどちらも1つ増やす。
     */
    public function incrementRequestCount()
    {
        \DB::transaction( function() {
            $requestCountMax = 100000000;  // 上限（この値までOK）
    
            // ロックしたいのでこのidのものを取得し直す
            $requestCount = RequestCount::where('id', $this->id)->lockForUpdate()->first();
            
            // リクエストカウントを増やして、データベースに保存まで行う
            if($requestCount->request_count < $requestCountMax)
            {
                $requestCount->increment('request_count');
            }
            
            if($requestCount->total_request_count < $requestCountMax)
            {
                $requestCount->increment('total_request_count');
            }
        } );
    }
}

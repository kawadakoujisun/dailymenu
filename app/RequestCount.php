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
            
            /*
            // Typeがint(10) unsignedの上限テスト
            $requestCount->request_count = 4294967295;
            $requestCount->save();
            $requestCount->increment('request_count');
            
            // エラーになった
            Illuminate\Database\QueryException
            SQLSTATE[22003]: Numeric value out of range: 1264 Out of range value for column 'request_count' at row 1 (SQL: update `request_counts` set `request_count` = `request_count` + 1, `request_counts`.`updated_at` = 2021-04-23 20:22:33 where `id` = 34)
            */
        } );
    }
}

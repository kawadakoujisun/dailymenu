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
     * リクエストカウントを増やす
     * request_count、total_request_countどちらも1つ増やす。
     */
    public function incrementRequestCount()
    {
        $requestCountMax = 100000000;  // 上限（この値までOK）
        
        if($this->request_count < $requestCountMax)
        {
            ++$this->request_count;
        }
        
        if($this->total_request_count < $requestCountMax)
        {
            ++$this->total_request_count;
        }
    }
}

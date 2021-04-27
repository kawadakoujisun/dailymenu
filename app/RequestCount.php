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
        /*
        // ローカルディスクを使うテスト
        if (\Storage::disk('local')->exists('file.txt')) {
            $contents = \Storage::disk('local')->get('file.txt');
            dd($contents);
        } else {
            \Storage::disk('local')->put('file.txt', 'Contents in file.txt');
            // ↑storage/app内にfile.txtができ、そのファイルには「Contents in file.txt」と書かれていた。
            //  もう一度呼ぶと、file.txtが作り直される。
        }
        */
        
        // リクエスト済みのときは何もしない
        $requestCountCookieKey = 'request_count_' . $this->id;
        $requestCountCookie    = \Cookie::get($requestCountCookieKey);
        if ($this->isRequested()) {
            return;
        } else {
            // \Cookie::queue($this->getRequestedCookieKey(), 'requested', 60*12);  // (60*12)分
            \Cookie::queue($this->getRequestedCookieKey(), 'requested', 1);  // 1分
        }
        
        \DB::transaction( function() {
            $requestCountMax = 100000000;  // 上限（この値までOK）
    
            // ロックしたいのでこのidのものを取得し直す
            $requestCount = RequestCount::where('id', $this->id)->lockForUpdate()->first();
            
            /*
            // ロックのテスト
            // リクエストカウントが17のときに１つ目のブラウザでリクエストボタンを押す。１つ目のブラウザが固まる。
            // それから10秒後、test_cookieが設定され、１つ目のブラウザが復活する。
            // それから45秒後、１つ目のブラウザでリクエストボタンを押す。１つ目のブラウザが固まる。
            // それから15秒後、test_cookieが消えるので、２つ目のブラウザでリクエストボタンを押す。２つ目のブラウザはスリープしないはずだが固まる。
            // それから5秒後、１つ目のブラウザが復活する。２つ目のブラウザも復活する。
            // これで、１つ目のブラウザがロックしていたために２つ目のブラウザが固まっていたことの証明になるかな。
            $cookie = \Cookie::get('test_cookie');
            if (is_null($cookie) && $requestCount->request_count == 17) {
                \Cookie::queue('test_cookie', 'test_cookie_value', 1);  // 1分
                sleep(10);  // 10秒
            } else if(!is_null($cookie)) {
                sleep(20);  // 20秒
            } else {
                // sleepしない
            }
            */
            
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
    
    /**
     * リクエスト済みかどうか
     * リクエスト済みのときtrueを返す。
     */
    public function isRequested()
    {
        $requestedCookie = \Cookie::get($this->getRequestedCookieKey());
        return (!is_null($requestedCookie));
    }
    
    /**
     * リクエスト済みかどうかを記録しているCookieのキーを取得する
     */
    private function getRequestedCookieKey()
    {
        $requestedCookieKey = 'requested_' . $this->id;
        return $requestedCookieKey;
    }
}

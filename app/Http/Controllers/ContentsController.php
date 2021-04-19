<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dish;          // 追加
use App\Date;          // 追加

class ContentsController extends Controller
{
    public function index()
    {
        // Date一覧をdateの降順で取得
        $dates = Date::orderBy('date', 'desc')->paginate(\Config::get('contents.ContentsDef.ITEM_NUM_IN_PAGE'));
        
        // Date一覧ビュー
        return view('contents.index', ['dates' => $dates]);
    }
    
    public function getRankingOfRequestCount()
    {
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // 試行錯誤　ここから
        //
        
        /*
        // 実験01：datesテーブルをdish_idでグループ化する。
        $uniqueDishIdData = \DB::table('dates')
            ->select('dish_id', \DB::raw('max(date) as max_date'))
            ->from('dates')
            ->groupBy('dish_id')
            ->get();

        dd($uniqueDishIdData);
        */

        /*
        // 実験02：datesテーブルをdish_idでグループ化し、datesテーブルの指定したカラムの値を得る。
        $uniqueDishIdData = \DB::table('dates')
            ->select('id', 'dish_id', 'date')
            ->whereIn(\DB::raw('(dish_id, date)'), function($sub){
                $sub
                    ->select('dish_id', \DB::raw('max(date) as max_date'))
                    ->from('dates')
                    ->groupBy('dish_id');
            })
            ->get();
        
        dd($uniqueDishIdData);
        */

        /*
        // 実験03：dishesテーブルにdatesテーブル、request_countsテーブルを結合する。
        //         datesテーブルのどのレコードからも使用されていないdishesテーブルのレコードも取得できるように、leftJoinで結合する。
        $joinedData = \DB::table('dishes')
            ->leftJoin('dates', 'dishes.id', '=', 'dates.dish_id')
            ->leftjoin('request_counts', 'dishes.id', '=', 'request_counts.dish_id')
            ->select(
                'dishes.id',
                'dishes.name',
                'dishes.description',
                'dishes.image_url',
                'dates.id as dates_id',
                'dates.date as dates_date',
                'request_counts.id as request_counts_id',
                'request_counts.request_count as request_counts_request_count'
            )
            ->get();

        dd($joinedData);
        */
        
        /*
        // 実験04：dishesテーブルにdatesテーブル、request_countsテーブルを結合し、
        //         datesテーブルのdish_idでグループ化する。
        $joinedData = \DB::table('dishes')
            ->leftJoin('dates', 'dishes.id', '=', 'dates.dish_id')
            ->leftjoin('request_counts', 'dishes.id', '=', 'request_counts.dish_id')
            ->select(
                'dishes.id',
                'dishes.name',
                'dishes.description',
                'dishes.image_url',
                'dates.id as dates_id',
                'dates.date as dates_date',
                'request_counts.id as request_counts_id',
                'request_counts.request_count as request_counts_request_count'
            )
            ->whereIn(\DB::raw('(dates.dish_id, dates.date)'), function($sub){
                $sub
                    ->select('dates.dish_id', \DB::raw('max(dates.date) as dates_max_date'))
                    ->from('dates')
                    ->groupBy('dates.dish_id');
            })
            ->get();

        dd($joinedData);
        */
        
        /*
        // 実験05：dishesテーブルにdatesテーブル、request_countsテーブルを結合し、
        //         datesテーブルのdish_idでグループ化する。使用されていないdishesテーブルのレコードも取得する。
        $joinedData = \DB::table('dishes')
            ->leftJoin('dates', 'dishes.id', '=', 'dates.dish_id')
            ->leftjoin('request_counts', 'dishes.id', '=', 'request_counts.dish_id')
            ->select(
                'dishes.id',
                'dishes.name',
                'dishes.description',
                'dishes.image_url',
                'dates.id as dates_id',
                'dates.date as dates_date',
                'request_counts.id as request_counts_id',
                'request_counts.request_count as request_counts_request_count'
            )
            ->whereIn(\DB::raw('(dates.dish_id, dates.date)'), function($sub){
                $sub
                    ->select('dates.dish_id', \DB::raw('max(dates.date) as dates_max_date'))
                    ->from('dates')
                    ->groupBy('dates.dish_id');
            })
            ->orWhere('dates.id', '=', null)
            ->get();

        dd($joinedData);
        */

        /*
        // 実験06：dishesテーブルにdatesテーブル、request_countsテーブルを結合し、dishesテーブルのレコードが重複していないものを得る。
        //         それを並び替える。
        $joinedData = \DB::table('dishes')
            ->leftJoin('dates', 'dishes.id', '=', 'dates.dish_id')
            ->leftjoin('request_counts', 'dishes.id', '=', 'request_counts.dish_id')
            ->orderBy('dates.date', 'desc')         // (2) (1)で並べた結果に対して、次にこれで並べる。ここではdatesテーブルのdateカラムが未来→過去の順に並べている。
            ->orderBy('dishes.created_at', 'desc')  // (1) まずはこれで並べる。ここではdishesテーブルへの登録日時が未来→過去の順に並べている。
            ->select(
                'dishes.id',
                'dishes.name',
                'dishes.description',
                'dishes.image_url',
                'dishes.created_at',
                'dates.id as dates_id',
                'dates.date as dates_date',
                'request_counts.id as request_counts_id',
                'request_counts.request_count as request_counts_request_count'
            )
            ->whereIn(\DB::raw('(dates.dish_id, dates.date)'), function($sub){
                $sub
                    ->select('dates.dish_id', \DB::raw('max(dates.date) as dates_max_date'))
                    ->from('dates')
                    ->groupBy('dates.dish_id');
            })
            ->orWhere('dates.id', '=', null)
            ->get();

        dd($joinedData);
        */
        
        /*
        // 実験07：datesテーブルをdish_idでグループ化し、集計する。
        $uniqueDishIdData = \DB::table('dates')
            ->select(\DB::raw('count(*) as count_dish_id'))
            ->from('dates')
            ->groupBy('dish_id')
            ->get();

        dd($uniqueDishIdData);
        */
        
        /*
        // 実験08：datesテーブルをdish_idでグループ化し、集計する。dish_idもselectにいれる。
        $uniqueDishIdData = \DB::table('dates')
            ->select('dish_id', \DB::raw('count(*) as count_dish_id'))
            ->from('dates')
            ->groupBy('dish_id')
            ->get();

        dd($uniqueDishIdData);
        */
        
        /*
        // 実験09：DateTimeクラスの使い方。
        $d0 = new \DateTime();
        $d1 = $d0->format('Y-m-d');  // $d1はstring
        $d2 = new \DateTime($d1);
        $d3 = $d2->sub(new \DateInterval('P10D'));  // P2Yは2年、P2Dは2日
        dd($d3);
        */
        
        $d0 = new \DateTime();
        $d1 = $d0->format('Y-m-d');  // $d1はstring
        $d2 = new \DateTime($d1);
        $d3 = $d2->sub(new \DateInterval('P5D'));
        $d4 = $d3->format('Y-m-d');
        $startTime = $d4;
        $endTime   = $d1;
        
        /*
        // 実験10：datesテーブルをdateで絞り込む。
        $uniqueDishIdData = \DB::table('dates')
            ->select('id', 'dish_id', 'date', 'created_at')
            ->from('dates')
            ->where([
                ['date', '>=', $startTime],
                ['date', '<=', $endTime]
            ])
            ->get();

        dd($uniqueDishIdData);
        */
        
        /*
        // 実験11：datesテーブルをdateで絞り込んでdish_idでグループ化し、集計する。
        $uniqueDishIdData = \DB::table('dates')
            ->select('dish_id', \DB::raw('count(*) as count_dish_id'))
            ->from('dates')
            ->where([
                ['date', '>=', $startTime],
                ['date', '<=', $endTime]
            ])
            ->groupBy('dish_id')
            ->get();

        dd($uniqueDishIdData);
        */
        
        /*
        // 実験12：withCountを使ってみる。
        //         https://readouble.com/laravel/6.x/ja/eloquent-relationships.html#counting-related-models
        $dishes = Dish::withCount('dates')->get();
        foreach($dishes as $dish) {
            dump($dish->dates_count);
            dump($dish);
        }
        dd();
        */

        /*
        // 実験13：withCountを使ってみる。
        //         クエリによる制約を加えて、件数を取得してみる。
        $dishes = Dish::withCount(['dates as appearance_count' => function(\Illuminate\Database\Eloquent\Builder $query) use($startTime, $endTime) {
            $query->where([
                ['date', '>=', $startTime],
                ['date', '<=', $endTime]
            ]);
        }])->get();
        foreach($dishes as $dish) {
            dump($dish->appearance_count);
            dump($dish);
        }
        dd();        
        */
        
        /*
        // この後の並び替えをDish型ではなく\DB::table('dishes')で行っているため、
        // Dish::withCountをやっても意味がない。
        
        // ある期間のDishの登場回数appearance_count
        $d0 = new \DateTime();
        $d1 = $d0->format('Y-m-d');  // $d1はstring
        $d2 = new \DateTime($d1);
        $d3 = $d2->sub(new \DateInterval('P5D'));
        $d4 = $d3->format('Y-m-d');
        $startTime = $d4;
        $endTime   = $d1;
        
        $dishes = Dish::withCount(['dates as appearance_count' => function(\Illuminate\Database\Eloquent\Builder $query) use($startTime, $endTime) {
            $query->where([
                ['date', '>=', $startTime],
                ['date', '<=', $endTime]
            ]);
        }])->paginate(7);
        
        dd($dishes);
        */
        
        /*
        // この書き方では$joinedDishesはDish型ではないものの配列のページネーションになる。

        // Dishの一覧を「RequestCountのrequest_countの降順」で取得
        // リクエスト数順(多いほうが前) > 登場した順(最近登場したほうが前) > 登録日時順(最近登録したほうが前)
        $joinedDishes = \DB::table('dishes')
            ->leftJoin('dates', 'dishes.id', '=', 'dates.dish_id')
            ->leftjoin('request_counts', 'dishes.id', '=', 'request_counts.dish_id')
            ->orderBy('request_counts.request_count', 'desc')
            ->orderBy('dates.date', 'desc')
            ->orderBy('dishes.created_at', 'desc')
            ->select(
                'dishes.id',
                'dishes.name',
                'dishes.description',
                'dishes.image_url',
                'dishes.created_at',
                'dates.id as dates_id',
                'dates.date as dates_date',
                'request_counts.id as request_counts_id',
                'request_counts.request_count as request_counts_request_count'
            )
            ->whereIn(\DB::raw('(dates.dish_id, dates.date)'), function($sub){
                $sub
                    ->select('dates.dish_id', \DB::raw('max(dates.date) as dates_max_date'))
                    ->from('dates')
                    ->groupBy('dates.dish_id');
            })
            ->orWhere('dates.id', '=', null)
            ->paginate(7);
        */        
        
        /*
        // 先の「この書き方では$joinedDishesはDish型ではないものの配列のページネーションになる。」をDish型で書いてみる。
        // この書き方なら$dishesはDish型の配列になる。
        // Dish型なのでここからdatesやrequestCountを取得できる。
        
        $dishes =
            Dish::leftJoin('dates', 'dishes.id', '=', 'dates.dish_id')
            ->leftjoin('request_counts', 'dishes.id', '=', 'request_counts.dish_id')
            ->select(  // このselectに書いたものがDish型のカラムとして存在するようになった
                'dishes.id',
                'dishes.name',
                'dishes.description',
                'dishes.image_url',
                'dishes.created_at',
                'dates.id as dates_id',
                'dates.date as dates_date',
                'request_counts.id as request_counts_id',
                'request_counts.request_count as request_counts_request_count'
            )
            ->withCount(['dates as appearance_count' => function(\Illuminate\Database\Eloquent\Builder $query) use($startTime, $endTime) {  // selectの後にwithCountを書くことでDish型のカラムとしてこれが存在するようになった
                $query->where([
                    ['date', '>=', $startTime],
                    ['date', '<=', $endTime]
                ]);
            }])
            ->orderBy('request_counts.request_count', 'desc')
            ->orderBy('dates.date', 'desc')
            ->orderBy('dishes.created_at', 'desc')
            ->whereIn(\DB::raw('(dates.dish_id, dates.date)'), function($sub){
                $sub
                    ->select('dates.dish_id', \DB::raw('max(dates.date) as dates_max_date'))
                    ->from('dates')
                    ->groupBy('dates.dish_id');
            })
            ->orWhere('dates.id', '=', null)
            ->get();
        
        dump($startTime);
        dump($endTime);
        foreach($dishes as $dish){
            $dateOfDish = $dish->dates;
            $dateKakko  = $dish->dates();
            $requestCountOfDish = $dish->requestCount;
            $requestCountKakko  = $dish->requestCount();
            dump($dateOfDish);
            //dump($dateKakko);          // 大量に出力されるのでコメントアウト
            dump($requestCountOfDish);
            //dump($requestCountKakko);  // 大量に出力されるのでコメントアウト
        }
        dd($dishes);
        */
        
        /*
        // nullの並び順に関して試したこと
        // gitに何回もコミットしなくて済むよう、また、herokuに何回もプッシュしなくて済むよう、
        // 環境変数の値を使うようにして試した
        
        $orderByForNull = null;
        if (env('DB_CONNECTION') == 'mysql') {
            $orderByForNull = 'dates.date IS NULL ASC';
        } else {  // (env('DB_CONNECTION') == 'pgsql')
            $orderByForNull = env('ORDER_BY_FOR_NULL');
            // .envに
            // ORDER_BY_FOR_NULL="dates.date IS NULL ASC"
            // と書いておく。
            
            // herokuのconfigにいろいろ書いて試した結果
            // ↓null最後、そして他は日付が古いほうが前に来てしまう
            //     heroku config:set ORDER_BY_FOR_NULL="dates.date NULLS LAST"
            // ↓null最初、そして他は日付が古いほうが前に来てしまう
            //     heroku config:set ORDER_BY_FOR_NULL="dates.date NULLS FIRST"
            //
            // ↓null最後、そして他は日付が新しいほうが前に来る←採用。pgsqlで使えるようだ。
            //     heroku config:set ORDER_BY_FOR_NULL="dates.date IS NULL ASC"
            // ↓null最初、そして他は日付が新しいほうが前に来る
            //     heroku config:set ORDER_BY_FOR_NULL="dates.date IS NULL DESC"
            //
            // ↓エラーになる
            //     heroku config:set ORDER_BY_FOR_NULL="'dates.date', 'desc NULLS LAST'"
        }        
        
        // Dishの登場回数appearance_countをカウントする期間
        $d0 = new \DateTime();
        $d1 = $d0->format('Y-m-d');
        $d2 = new \DateTime($d1);
        $d3 = $d2->sub(new \DateInterval('P30D'));
        $d4 = $d3->format('Y-m-d');
        $startTime = $d4;
        $endTime   = $d1;
        
        // Dishの一覧を「RequestCountのrequest_countの降順」で取得
        // 登場した順(最近登場したほうが前) > 登録日時順(最近登録したほうが前)        
        $joinedDishes =
            Dish::leftJoin('dates', 'dishes.id', '=', 'dates.dish_id')
            ->leftjoin('request_counts', 'dishes.id', '=', 'request_counts.dish_id')
            ->select(  // このselectに書いたものがDish型のカラムとして存在するようになった
                'dishes.id',
                'dishes.name',
                'dishes.description',
                'dishes.image_url',
                'dishes.created_at',
                'dates.id as dates_id',
                'dates.date as dates_date',
                'request_counts.id as request_counts_id',
                'request_counts.request_count as request_counts_request_count'
            )
            ->withCount(['dates as appearance_count' => function(\Illuminate\Database\Eloquent\Builder $query) use($startTime, $endTime) {  // selectの後にwithCountを書くことでDish型のカラムとしてこれが存在するようになった
                $query->where([
                    ['date', '>=', $startTime],
                    ['date', '<=', $endTime]
                ]);
            }])
            // // MySQL
            // ->orderByRaw('dates.date IS NULL ASC')  // MySQLではnullが最後（orderBy('dates.date', 'desc')があっての最後かもしれないので注意）
            // //->orderByRaw('dates.date IS NULL DESC')  // MySQLではnullが最初（orderBy('dates.date', 'desc')があっての最初かもしれないので注意）
            ->orderByRaw($orderByForNull)
            ->orderBy('dates.date', 'desc')
            ->orderBy('dishes.created_at', 'desc')
            ->whereIn(\DB::raw('(dates.dish_id, dates.date)'), function($sub){
                $sub
                    ->select('dates.dish_id', \DB::raw('max(dates.date) as dates_max_date'))
                    ->from('dates')
                    ->groupBy('dates.dish_id');
            })
            ->orWhere('dates.id', '=', null)
            ->paginate(7);
        
        // 一覧ビュー
        return view('contents.ranking', ['joinedDishes' => $joinedDishes, 'order_key' => 2]);        
        */

        //
        // 試行錯誤　ここまで
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        
        // Dishの一覧を「RequestCountのrequest_countの降順」で取得
        // リクエスト数順(多いほうが前) > 登場した順(最近登場したほうが前) > 登録日時順(最近登録したほうが前)        
        $joinedDishes =
            $this->getJoinedDishes()
                ->orderBy('request_counts.request_count', 'desc')
                ->orderByRaw('dates.date IS NULL ASC')
                ->orderBy('dates.date', 'desc')
                ->orderBy('dishes.created_at', 'desc')        
                ->paginate(\Config::get('contents.ContentsDef.ITEM_NUM_IN_PAGE'));
        
        // 一覧ビュー
        // 'order_key'はConfig::get('contents.RankingDef.orderArray')のキー
        return view('contents.ranking', ['joinedDishes' => $joinedDishes, 'order_key' => 'REQUEST_COUNT']);
    }
    
    public function getRankingOfAppearanceCount()
    {
        // Dishの一覧を「withCountで得たppearance_countの降順」で取得
        // 登場回数順(多いほうが前) > 登場した順(最近登場したほうが前) > 登録日時順(最近登録したほうが前)        
        $joinedDishes =
            $this->getJoinedDishes()
                ->orderBy('appearance_count', 'desc')  // 'dishes.appearance_count'と書いたらエラー。Illuminate\Database\QueryException : Column not foundとなる。
                ->orderByRaw('dates.date IS NULL ASC')
                ->orderBy('dates.date', 'desc')
                ->orderBy('dishes.created_at', 'desc')
                ->paginate(\Config::get('contents.ContentsDef.ITEM_NUM_IN_PAGE'));
        
        // 一覧ビュー
        // 'order_key'はConfig::get('contents.RankingDef.orderArray')のキー
        return view('contents.ranking', ['joinedDishes' => $joinedDishes, 'order_key' => 'APPEARANCE_COUNT']);        
    }    
    
    public function getRankingOfRecentAppearance()
    {
        // Dishの一覧を「Dateのdateの降順」で取得
        // 登場した順(最近登場したほうが前) > 登録日時順(最近登録したほうが前)        
        $joinedDishes =
            $this->getJoinedDishes()
                ->orderByRaw('dates.date IS NULL ASC')  // MySQLでもPostgreSQLでもnullが最後（orderBy('dates.date', 'desc')があっての最後かもしれないので注意）
                ->orderBy('dates.date', 'desc')
                ->orderBy('dishes.created_at', 'desc')
                ->paginate(\Config::get('contents.ContentsDef.ITEM_NUM_IN_PAGE'));
        
        // 一覧ビュー
        // 'order_key'はConfig::get('contents.RankingDef.orderArray')のキー
        return view('contents.ranking', ['joinedDishes' => $joinedDishes, 'order_key' => 'RECENT_APPEARANCE']);              
    }
    
    public function postRanking(Request $request)
    {
        // 他のルートへリダイレクト
        // $request->orderはConfig::get('contents.RankingDef.orderArray')のキー
        if ($request->order == 'REQUEST_COUNT') {
            return redirect()->route('contents.GetRankingOfRequestCount');
        } else if ($request->order == 'APPEARANCE_COUNT') {
            return redirect()->route('contents.GetRankingOfAppearanceCount');
        } else {  // ($request->order == 'RECENT_APPEARANCE')
            return redirect()->route('contents.GetRankingOfRecentAppearance');
        }
    }
    
    public function RequestDish($dish_id)
    {
        // dish_idの値でDishを検索して取得
        $dish = Dish::findOrFail($dish_id);
        
        // RequestCountを取得
        $requestCount = $dish->requestCount;
        // リクエストカウントを増やす
        $requestCount->incrementRequestCount();
        // データベースに保存する
        $requestCount->save();
        
        // 前のURLへリダイレクト
        return back();
    }
    
    private function getAppearanceCountPeriod()
    {
        // Dishの登場回数appearance_countをカウントする期間
        $d0 = new \DateTime();       // 今日
        $d1 = $d0->format('Y-m-d');  // 今日 
        $d2 = new \DateTime($d1);
        $d3 = $d2->sub(new \DateInterval('P1Y'));  // 1年前
        $d4 = $d3->format('Y-m-d');                // 1年前
        $d5 = new \DateTime($d1);  // $d2の値はsubしたときに変わってしまっているので、別のインスタンスを新たに用意する。
        $d6 = $d5->add(new \DateInterval('P1Y'));  // 1年後（明日の料理を投稿済みのこともあるだろうから）
        $d7 = $d6->format('Y-m-d');                // 1年後
        $startTime = $d4;
        $endTime   = $d7;
        
        return [$startTime, $endTime];
    }
    
    private function getJoinedDishes()
    {
        // Dishの登場回数appearance_countをカウントする期間
        list($startTime, $endTime) = $this->getAppearanceCountPeriod();
        
        return Dish::leftJoin('dates', 'dishes.id', '=', 'dates.dish_id')
            ->leftjoin('request_counts', 'dishes.id', '=', 'request_counts.dish_id')
            ->select(  // このselectに書いたものがDish型のカラムとして存在するようになった
                'dishes.id',
                'dishes.name',
                'dishes.description',
                'dishes.image_url',
                'dishes.created_at',
                'dates.id as dates_id',
                'dates.date as dates_date',
                'request_counts.id as request_counts_id',
                'request_counts.request_count as request_counts_request_count'
            )
            ->withCount(['dates as appearance_count' => function(\Illuminate\Database\Eloquent\Builder $query) use($startTime, $endTime) {  // selectの後にwithCountを書くことでDish型のカラムとしてこれが存在するようになった
                $query->where([
                    ['date', '>=', $startTime],
                    ['date', '<=', $endTime]
                ]);
            }])
            ->whereIn(\DB::raw('(dates.dish_id, dates.date)'), function($sub){
                $sub
                    ->select('dates.dish_id', \DB::raw('max(dates.date) as dates_max_date'))
                    ->from('dates')
                    ->groupBy('dates.dish_id');
            })
            ->orWhere('dates.id', '=', null);
    }
}

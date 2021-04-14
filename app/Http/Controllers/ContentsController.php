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
        $dates = Date::orderBy('date', 'desc')->paginate(7);
        
        // Date一覧ビュー
        return view('contents.index', ['dates' => $dates]);
    }
    
    public function getRankingOfRequestCount()
    {
        // Dish一覧をidの降順で取得
        $dishes = Dish::orderBy('id', 'desc')->paginate(7);

        // Dish一覧ビュー
        return view('contents.ranking', ['dishes' => $dishes, 'order_key' => 0]);
    }
    
    public function getRankingOfAppearanceCount()
    {
        // Dish一覧をidの昇順で取得
        $dishes = Dish::orderBy('id', 'asc')->paginate(7);

        // Dish一覧ビュー
        return view('contents.ranking', ['dishes' => $dishes, 'order_key' => 1]);
    }    
    
    public function getRankingOfRecentAppearance()
    {
        // Dish一覧をidの昇順で取得
        $dishes = Dish::orderBy('id', 'asc')->paginate(7);

        // Dish一覧ビュー
        return view('contents.ranking', ['dishes' => $dishes, 'order_key' => 2]);
    }
    
    public function postRanking(Request $request)
    {
        // 他のルートへリダイレクト
        if ($request->order == 0) {
            return redirect()->route('contents.GetRankingOfRequestCount');
        } else if ($request->order == 1) {
            return redirect()->route('contents.GetRankingOfAppearanceCount');
        } else {  // ($request->order == 2)
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
}

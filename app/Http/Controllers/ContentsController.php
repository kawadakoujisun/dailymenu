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
    
    public function getRanking()
    {
        // Dish一覧をidの降順で取得
        $dishes = Dish::orderBy('id', 'desc')->paginate(7);

        // Dish一覧ビュー
        return view('contents.ranking', ['dishes' => $dishes, 'order_key' => 0]);
    }
    
    public function postRanking(Request $request)
    {
        $dishes = null;
        if ($request->order == 0) {
            // Dish一覧をidの降順で取得
            $dishes = Dish::orderBy('id', 'desc')->paginate(7);
        } else {
            $dishes = Dish::orderBy('id', 'asc')->paginate(7);
        }
        
        // Dish一覧ビュー
        return view('contents.ranking', ['dishes' => $dishes, 'order_key' => $request->order]);
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

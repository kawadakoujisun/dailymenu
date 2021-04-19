<?php

namespace App\Http\Controllers;

require_once(dirname(__FILE__)."/../../contents/ImageUtil.php");  // 追加

use Illuminate\Http\Request;

use App\Dish;  // 追加
use App\Date;  // 追加
use App\Contents\ImageUtil;  // 追加

class ManagementDatesController extends Controller
{
    public function index()
    {
        // Date一覧をdateの降順で取得
        $dates = Date::orderBy('date', 'desc')->paginate(\Config::get('contents.ContentsDef.ITEM_NUM_IN_PAGE'));
        
        // Date一覧ビュー
        return view('management.dates.index', ['dates' => $dates]);
    }
    
    public function createNewDish()
    {
        return view('management.dates.CreateNewDish');
    }
    
    public function storeNewDish(Request $request)
    {
        // バリデーション
        $validateValueArray = \Config::get('contents.ContentsDef.requestValidateValueArray');
        $request->validate([
            'date'                => $validateValueArray['date'],
            'name'                => $validateValueArray['name'],
            'description'         => $validateValueArray['description'],
            'selected_image_file' => 'required | ' . $validateValueArray['selected_image_file'],
        ]);
        
        // 画像ファイルをアップする
        $selectedImageFile = $request->selected_image_file;
        list($image_url, $image_public_id) = ImageUtil::uploadImage($selectedImageFile, null);
        
        // データベースに保存する
        $dish = Dish::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'image_url'       => $image_url,
            'image_public_id' => $image_public_id,
        ]);
        
        $dish->dates()->create([
            'date' => $request->date,  // 年-月-日(例2021-04-12)だけだと時:分:秒には0が入るようだ
        ]);
        
        $dish->requestCount()->create([
            'request_count'       => 0,
            'total_request_count' => 0,
        ]);
        
        // 管理者ページトップへリダイレクト
        return redirect('/management/base');
    }
    
    public function createSameDish($dish_id)
    {
        // dish_idの値でDishを検索して取得
        $dish = Dish::findOrFail($dish_id);
        
        return view('management.dates.CreateSameDish', ['dish' => $dish]);
    }
    
    public function storeSameDish(Request $request, $dish_id)
    {
        // バリデーション
        $validateValueArray = \Config::get('contents.ContentsDef.requestValidateValueArray');
        $request->validate([
            'date'                => $validateValueArray['date'],
        ]);
        
        // dish_idの値でDishを検索して取得
        $dish = Dish::findOrFail($dish_id);
        
        // データベースに保存する
        $dish->dates()->create([
            'date' => $request->date,  // 年-月-日(例2021-04-12)だけだと時:分:秒には0が入るようだ
        ]);
        
        // 管理者ページトップへリダイレクト
        return redirect('/management/base');
    }
    
    public function destroy($id)
    {
        // idの値でDateを検索して取得
        $date = Date::findOrFail($id);
        
        // Dateを削除
        $date->delete();
        
        // 前のURLへリダイレクト
        return back();
    }
}

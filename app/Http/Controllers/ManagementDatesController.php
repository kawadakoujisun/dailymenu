<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cloudinary\Cloudinary;  // vendorにあるcloudinaryを追加

use App\Dish;  // 追加
use App\Date;  // 追加

class ManagementDatesController extends Controller
{
    public function index()
    {
        // Date一覧をdateの降順で取得
        $dates = Date::orderBy('date', 'desc')->paginate(7);
        
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
        $request->validate([
            'date'                => 'required | date | unique:dates',
            'name'                => 'required | max:127',
            'description'         => 'required | max:511',
            'selected_image_file' => 'required | mimes:jpeg,jpg,gif,png,bmp | max:2048',
        ]);
        
        // 画像ファイルをCloudinaryにアップする
        $selectedImageFile = $request->selected_image_file;
        
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ],
        ]);
    
        $uploadApi = $cloudinary->uploadApi();
        $apiResponse = $uploadApi->upload(
            $selectedImageFile->getPathname(),
            [
                "resource_type" => "image",
                "folder"        => "uploads"
            ]
        );
        
        // データベースに保存する
        $dish = Dish::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'image_url'       => $apiResponse["secure_url"],
            'image_public_id' => $apiResponse["public_id"],
        ]);
        
        $dish->dates()->create([
            'date' => $request->date,  // 年-月-日(例2021-04-12)だけだと時:分:秒には0が入るようだ
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
        $request->validate([
            'date'                => 'required | date | unique:dates',
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cloudinary\Cloudinary;  // vendorにあるcloudinaryを追加

use App\Dish;          // 追加

class ManagementDishesController extends Controller
{
    public function index()
    {
        // Dish一覧をidの降順で取得
        $dishes = Dish::orderBy('id', 'desc')->paginate(7);
        
        // Dish一覧ビュー
        return view('management.dishes.index', ['dishes' => $dishes]);
    }
    
    public function edit($id)
    {
        // idの値でDishを検索して取得
        $dish = Dish::findOrFail($id);
        
        return view('management.dishes.edit', ['dish' => $dish]);
    }
    
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'name'                => 'required | max:127',
            'description'         => 'required | max:511',
            'selected_image_file' => 'mimes:jpeg,jpg,gif,png,bmp | max:2048',  // 画像を変更していないときはnull
        ]);

        // idの値でDishを検索して取得
        $dish = Dish::findOrFail($id);
        
        // Dishを更新
        $dish->name        = $request->name;
        $dish->description = $request->description;
        
        // 画像を変更しているか
        $selectedImageFile = $request->selected_image_file;
        if(!is_null($selectedImageFile)) {
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
            
            // 古い画像ファイルをCloudinaryから削除する
            $uploadApi->destroy($dish->image_public_id);
            
            // 新しい画像ファイルをCloudinaryにアップする
            $apiResponse = $uploadApi->upload(
                $selectedImageFile->getPathname(),
                [
                    "resource_type" => "image",
                    "folder"        => "uploads"
                ]
            );
            
            $dish->image_url       = $apiResponse["secure_url"];
            $dish->image_public_id = $apiResponse["public_id"];
        }
        
        // データベースに保存する
        $dish->save();
        
        // 管理者ページトップへリダイレクト
        return redirect('/management/base');
    }
    
    public function destroy($id)
    {
        // idの値でDishを検索して取得
        $dish = Dish::findOrFail($id);
        
        // 画像ファイルをCloudinaryから削除する
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
        $uploadApi->destroy($dish->image_public_id);

        // Dishを削除
        $dish->delete();
        
        // 前のURLへリダイレクト
        return back();
    }
    
    public function ResetRequestCount($id)
    {
        // idの値でDishを検索して取得
        $dish = Dish::findOrFail($id);
        
        // RequestCountを取得
        $requestCount = $dish->requestCount;
        // リクエストカウントをリセットする
        $requestCount->resetRequestCount();
        // データベースに保存する
        $requestCount->save();
        
        // 前のURLへリダイレクト
        return back();
    }
}

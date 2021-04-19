<?php

namespace App\Http\Controllers;

require_once(dirname(__FILE__)."/../../contents/ImageUtil.php");  // 追加

use Illuminate\Http\Request;

use App\Dish;          // 追加
use App\Contents\ImageUtil;  // 追加

class ManagementDishesController extends Controller
{
    public function index()
    {
        // Dish一覧をidの降順で取得
        $dishes = Dish::orderBy('id', 'desc')->paginate(\Config::get('contents.ContentsDef.ITEM_NUM_IN_PAGE'));
        
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
        $validateValueArray = \Config::get('contents.ContentsDef.requestValidateValueArray');
        $request->validate([
            'name'                => $validateValueArray['name'],
            'description'         => $validateValueArray['description'],
            'selected_image_file' => $validateValueArray['selected_image_file'],  // 画像を変更していないときはnull
        ]);

        // idの値でDishを検索して取得
        $dish = Dish::findOrFail($id);
        
        // Dishを更新
        $dish->name        = $request->name;
        $dish->description = $request->description;
        
        // 画像を変更しているか
        $selectedImageFile = $request->selected_image_file;
        if(!is_null($selectedImageFile)) {
            // 古い画像ファイルを削除し、新しい画像ファイルをアップする
            list($image_url, $image_public_id) = ImageUtil::uploadImage($selectedImageFile, $dish->image_public_id);
            $dish->image_url       = $image_url;
            $dish->image_public_id = $image_public_id;
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
        
        // 画像ファイルを削除する
        ImageUtil::destroyImage($dish->image_public_id);

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

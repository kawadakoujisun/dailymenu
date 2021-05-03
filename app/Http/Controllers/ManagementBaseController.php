<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagementBaseController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            // ログイン後
            return view('management.base.index');
        } else {
            // ログイン前
            // 管理者ページログインへリダイレクト
            return redirect('/management/login');
        }
    }
    
    public function resizeImage()
    {
        return view('management.base.ResizeImage');
    }
    
    public function executeResizeImage(Request $request)
    {
        // バリデーション
        $validateValueArray = \Config::get('contents.ContentsDef.requestValidateValueArray');
        $request->validate([
            'selected_image_file' => 'required | mimes:jpeg,jpg,gif,png,bmp,webp | max:16384',
            'resize_image_width'  => 'required',
            'resize_image_height' => 'required',
        ]);
        
        // 画像ファイルを取得する
        $selectedImageFile = $request->selected_image_file;

        $headers = ['Content-Type' => $selectedImageFile->getMimeType()];
        
        $originalInfo = pathinfo($selectedImageFile->getClientOriginalName());
        $saveFileName = $originalInfo['filename'] . '_resized.' . 'jpg';  // jpg固定
        
        // storageに一時フォルダを作成する。手動でも削除し易いように、専用の一時フォルダを削除しておく。
        $tmpDirPath = $tmpDirPath = \Config::get('contents.ContentsDef.STORAGE_TMP_UPLOADS_DIR');
        if(!(\Storage::exists($tmpDirPath))) {
            \Storage::makeDirectory($tmpDirPath);
        }
        
        // storageに画像ファイルをコピーする。一時ファイルであり、この関数を抜ける前に消している。
        $tmpFilePath         = $tmpDirPath . '/' . 'tmp_upload_image_src.' . $originalInfo['extension'];
        $tmpFileAbsolutePath = storage_path('app/' . $tmpFilePath);
        copy($selectedImageFile->getPathname(), $tmpFileAbsolutePath);
        
        // storage内に作成する縮小ファイル。一時ファイルだけど消していない。毎回同じ名前なので上書きされる。
        $tmpSmallFilePath         = $tmpDirPath . '/' . 'tmp_upload_image_dst.' . 'jpg';  // jpg固定
        $tmpSmallFileAbsolutePath = storage_path('app/' . $tmpSmallFilePath);
        $tmpSmallFileExist = false;  // 正常に縮小ファイルを作成できたときtrue
        
        // 画像ファイルを縮小する
        if (extension_loaded('gd')) {  // GDライブラリが有効のときだけ縮小する
            // 元の画像名を指定してサイズを取得
            list($srcWidth, $srcHeight, $srcImageType) = getimagesize($tmpFileAbsolutePath);

            // 元の画像から新しい画像を作る準備
            $srcImage = null;
            switch($srcImageType) {
            case IMAGETYPE_GIF:  $srcImage = imagecreatefromgif($tmpFileAbsolutePath);   break;
            case IMAGETYPE_JPEG: $srcImage = imagecreatefromjpeg($tmpFileAbsolutePath);  break;
            case IMAGETYPE_PNG:  $srcImage = imagecreatefrompng($tmpFileAbsolutePath);   break;
            case IMAGETYPE_BMP:  $srcImage = imagecreatefrombmp($tmpFileAbsolutePath);   break;
            case IMAGETYPE_WEBP: $srcImage = imagecreatefromwebp($tmpFileAbsolutePath);  break;
            }
            
            if(!is_null($srcImage)) {
                $dstWidth  = $request->resize_image_width;
                $dstHeight = $request->resize_image_height;

                if($dstWidth <= 0 && $dstHeight <= 0) {
                    $dstWidth  = $srcWidth;
                    $dstHeight = $srcHeight;
                } else if($dstWidth <= 0 && $srcHeight > 0) {
                    $dstWidth = round($srcWidth * ($dstHeight / $srcHeight));  // 四捨五入
                    if($dstWidth < 0) $dstWidth = 1;
                } else if($dstHeight <= 0 && $srcWidth > 0) {
                    $dstHeight = round($srcHeight * ($dstWidth / $srcWidth));  // 四捨五入
                    if($dstHeight < 0) $dstHeight = 1;
                }
                
                // 大き過ぎるとき対策
                if($dstWidth > 2000 || $dstHeight > 2000) {
                    $dstWidth  = $srcWidth;
                    $dstHeight = $srcHeight;                    
                }
                
                // サイズを指定して新しい画像のキャンバスを作成
                $dstImage = imagecreatetruecolor($dstWidth, $dstHeight);
                
                if(!is_null($dstImage)) {
                    // 画像のコピーと伸縮
                    $retCopyResampled = imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
                    
                    if($retCopyResampled) {
                        // コピーした画像を出力する
                        $retImage = imagejpeg($dstImage , $tmpSmallFileAbsolutePath);
                        if($retImage) {
                            $tmpSmallFileExist = true;  // 正常に縮小ファイルを作成できた
                        }
                    }
                    
                    // 不要な画像リソースを保持するメモリを解放する
                    imagedestroy($dstImage);
                }
                
                // 不要な画像リソースを保持するメモリを解放する
                imagedestroy($srcImage);
            }
        }
        
        // storageにコピーしてきていた一時画像ファイルを削除する。
        \Storage::delete($tmpFilePath);
        
        if($tmpSmallFileExist) {
            // 縮小した画像ファイルをダウンロードする
            return \Storage::download($tmpSmallFilePath, $saveFileName, $headers);
        } else {
            // 失敗したときは前のURLへリダイレクト
            return back();
        }
    }
    
    public function clearTmpResizeImage()
    {
        // storageの一時フォルダを削除する。
        $tmpDirPath = \Config::get('contents.ContentsDef.STORAGE_TMP_UPLOADS_DIR');
        if(\Storage::exists($tmpDirPath)) {
            \Storage::deleteDirectory($tmpDirPath);  // ディレクトリと中に含まれている全ファイルを削除する
        }
        
        // 前のURLへリダイレクト
        return back();
    }
}

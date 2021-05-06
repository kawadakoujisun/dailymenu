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
            
            // 元の画像名を指定してExifデータを取得
            $srcOrientation = 1;
            $srcExifData = @exif_read_data($tmpFileAbsolutePath);  // exif_read_dataを実行してもいいかどうかを事前にチェックする術はないのでエラー制御演算子@を付けておく
            if($srcExifData) {  // @exif_read_dataがエラーのときはfalseになっているもよう
                if(array_key_exists('Orientation', $srcExifData)) {
                    $srcOrientation = $srcExifData['Orientation'];
                    if(is_null($srcOrientation)) {  // nullになることはないなら不要だがチェックしておくことにした
                        $srcOrientation = 1;
                    }
                }
            }
            
            // デバッグ用の名前。コメントアウトしておく。この名前で保存するとデバッグし易い。
            //$saveFileName = $originalInfo['filename'] . '_resized_' . $srcOrientation . '_' . $srcWidth . 'x' . $srcHeight . '.' . 'jpg';  // jpg固定
            
            // 元の画像が縦横逆になっているか
            $srcRotated = $this->doesNeedChangeHorizontalAndVertical($srcOrientation);
            // $srcRotatedがtrueのとき縦横逆になっている。
            // 縦横逆になっているとき、ユーザが見たとき縦になっているのは$srcWidthに、横になっているのは$srcHeightに入っている。

            // 元の画像から新しい画像を作る準備
            $srcImage = null;
            switch($srcImageType) {
            case IMAGETYPE_GIF:  $srcImage = imagecreatefromgif($tmpFileAbsolutePath);   break;
            case IMAGETYPE_JPEG: $srcImage = imagecreatefromjpeg($tmpFileAbsolutePath);  break;
            case IMAGETYPE_PNG:  $srcImage = imagecreatefrompng($tmpFileAbsolutePath);   break;
            case IMAGETYPE_BMP:  $srcImage = imagecreatefrombmp($tmpFileAbsolutePath);   break;
            case IMAGETYPE_WEBP: $srcImage = imagecreatefromwebp($tmpFileAbsolutePath);  break;
            default: break;
            }
            
            if(!is_null($srcImage)) {
                if($srcRotated) {
                    // ユーザが見ているものは縦横逆になっているので、ユーザの指示を逆にしておく。
                    $dstWidth  = $request->resize_image_height;
                    $dstHeight = $request->resize_image_width;
                } else {
                    $dstWidth  = $request->resize_image_width;
                    $dstHeight = $request->resize_image_height;
                }

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
                    
                    // 不要な画像リソースを保持するメモリを解放する
                    imagedestroy($srcImage);  // 回転が必要なときに処理が返って来なくなることがあったが、ここでメモリを空けたら大丈夫になった。
                    $srcImage = null;
                    
                    if($retCopyResampled) {
                        // 画像を反転、回転させる必要があるか？
                        list($flipMode, $rotateAngle) = $this->getFlipAndRotateValue($srcOrientation);
                        
                        // 反転
                        if(!is_null($flipMode)) {
                            imageflip($dstImage, $flipMode);  // 成功したときtrue、失敗したときfalseが返ってくる
                        }
                        
                        // 回転
                        if($rotateAngle > 0) {
                            $dstImage2 = imagerotate($dstImage, $rotateAngle, 0);  // 回転させた画像のリソースかfalseが返ってくる
                            if($dstImage2) {
                                // 不要な画像リソースを保持するメモリを解放する
                                imagedestroy($dstImage);
                                
                                // dstImage2をdstImageにいれておく
                                $dstImage = $dstImage2;
                                $dstImage2 = null;
                            }
                        }
                        
                        // コピーした画像を出力する
                        $retImage = imagejpeg($dstImage , $tmpSmallFileAbsolutePath);
                        if($retImage) {
                            $tmpSmallFileExist = true;  // 正常に縮小ファイルを作成できた
                        }
                    }
                    
                    // 不要な画像リソースを保持するメモリを解放する
                    imagedestroy($dstImage);
                }
                
                if(!is_null($srcImage)) {
                    // 不要な画像リソースを保持するメモリを解放する
                    imagedestroy($srcImage);
                    $srcImage = null;
                }
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
        /*
        {
            // コメントアウトしておくこと！
            // デバッグ用に出力していたpublic/images/内のmy_log.txtを削除する。
            // my_log.txtはapp/Http/Controllers/ManagementDatesController.phpのstoreNewDishで作ったもの。
            $publicImagesDir = public_path('/images/');
            $myLogFilePath = "$publicImagesDir" . "my_log.txt";
            if(file_exists($myLogFilePath)) {
                unlink($myLogFilePath);
            }
        }
        */
        
        
        // storageの一時フォルダを削除する。
        $tmpDirPath = \Config::get('contents.ContentsDef.STORAGE_TMP_UPLOADS_DIR');
        if(\Storage::exists($tmpDirPath)) {
            \Storage::deleteDirectory($tmpDirPath);  // ディレクトリと中に含まれている全ファイルを削除する
        }
        
        // 前のURLへリダイレクト
        return back();
    }
    
    /**
     * 画像が縦横逆になっているか。
     * 縦横逆になっているときtrueを返す。
     */
    private function doesNeedChangeHorizontalAndVertical($orientation)
    {
        return ($orientation == 8 || $orientation == 6 || $orientation == 7 || $orientation == 5);
    }
    
    /**
     * 画像を直すのに必要な反転、回転の値を取得する。
     * 直すときはflipしてからrotateする。imageflip、imagerotateにそのまま渡せる値を返す。
     */
    private function getFlipAndRotateValue($orientation)
    {
        $flipMode    = null;  // imageflipが必要ないときはnull、必要なときはIMG_FLIP_の定数。
        $rotateAngle = 0;  // degree  // imagerotateが必要ないときは0、必要なときは0より大。

        // 右に回転=時計回りに回転
        // のつもりで書いています。

	    switch($orientation) {
	    // 1, 8, 3, 6は回転のみした絵
		case 1:		// 回転なし
			break;
		case 8:		// 右に90度回転した絵  // 右に90度回転した絵になっているので、直すには左に90度回転する必要がある。imagerotateに渡す値は左に何度回転するかである。
			$rotateAngle = 90;
			break;
		case 3:		// 右に180度回転した絵  // 直すには上下反転、左右反転の両方を行う必要がある。
			$flipMode = IMG_FLIP_VERTICAL;
			break;
		case 6:		// 右に270度回転した絵
			$rotateAngle = 270;
			break;
		// 2, 7, 4, 5は左右反転してから回転
		case 2:		// 左右反転のみで回転なし  // 左右反転した絵になっているので、直すには左右反転する必要がある。
			$flipMode = IMG_FLIP_HORIZONTAL;
			break;
		case 7:		// 左右反転してから右に90度回転した絵  // 左右反転してから右に90度回転した絵になっているので、直すには左右反転してから左に270度回転する必要がある。
			$flipMode    = IMG_FLIP_HORIZONTAL;
			$rotateAngle = 270;
			break;
		case 4:		// 左右反転してから右に180度回転した絵  // 直すには上下反転する必要がある。
			$flipMode = IMG_FLIP_VERTICAL;
			break;
		case 5:		// 左右反転してから右に270度回転した絵  // 直すには左右反転してから左に90度回転する必要がある。
		    $flipMode    = IMG_FLIP_HORIZONTAL;
			$rotateAngle = 90;
			break;
		default:
		    break;
	    }
	    
	    return [$flipMode, $rotateAngle];
    }
}

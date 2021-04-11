<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cloudinary\Cloudinary;

class SampleObjectsController extends Controller
{
    public function index()
    {
        $data = [
            'selected_image_file_path' => null,
        ];
        return view('contents.SampleObject', $data);
    }
    
    public function store(Request $request)
    {
        $uploadToCloudinary  = true;
        $destroyOnCloudinary = false;
        
        $data = [
            'selected_image_file_path' => null,
        ];
        
        $selectedImageFile = $request->selected_image_file;
        
        if (!is_null($selectedImageFile)) {
            if ($uploadToCloudinary) {
                // Cloudinaryにアップする
                $cloudinary = new Cloudinary([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                        'api_key'    => env('CLOUDINARY_API_KEY'),
                        'api_secret' => env('CLOUDINARY_API_SECRET'), ],
                    'url' => [
                        'secure' => true ]]);
        
                $uploadApi = $cloudinary->uploadApi();
                $apiResponse = $uploadApi->upload(
                    $selectedImageFile->getPathname(),
                    [
                        "resource_type" => "image",
                        "folder"        => "uploads" ]);
                $data['selected_image_file_path'] = $apiResponse["secure_url"];
                
                if ($destroyOnCloudinary) {
                    // Cloudinaryからの削除を試してみる
                    $uploadApi->destroy(
                        $apiResponse["public_id"]);
                }
            } else {
                // ここにアップする
                $targetDir = public_path('uploads/');
                $selectedImageFile->move($targetDir, $selectedImageFile->getClientOriginalName());
            
                $selectedImageFileTargetPath  = $targetDir . $selectedImageFile->getClientOriginalName();  // "/home/ubuntu/environment/dailymenu/public/uploads/photo01.jpg"
                $selectedImageFileUploadsPath = 'uploads/' . $selectedImageFile->getClientOriginalName();  // "uploads/photo01.jpg"
    
                $data['selected_image_file_path'] = $selectedImageFileUploadsPath;
            }
        }
        
        return view('contents.SampleObject', $data);
    }
}

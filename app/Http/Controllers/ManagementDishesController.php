<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dish;  // 追加

class ManagementDishesController extends Controller
{
    public function index()
    {
        // Dish一覧をidの降順で取得
        $dishes = Dish::orderBy('id', 'desc')->paginate(7);
        
        // Dish一覧ビュー
        return view('management.dishes.index', ['dishes' => $dishes]);
    }
}

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
}

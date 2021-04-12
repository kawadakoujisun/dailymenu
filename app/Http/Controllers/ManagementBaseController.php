<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagementBaseController extends Controller
{
    public function index()
    {
        return view('management.base.index');
    }
}

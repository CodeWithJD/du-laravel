<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSwapController extends Controller
{
    public function swapListShow() {

        return view('admin.swap');
    }
}

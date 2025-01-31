<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HelpController extends Controller
{
    /**
     * ヘルプページの表示
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('help.index');
    }
}

<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * ウェルカムページを表示
     */
    public function __invoke()
    {
        return view('welcome');
    }
}

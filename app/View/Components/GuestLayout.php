<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * コンポーネントを表すビューを取得
     *
     * @return View
     */
    public function render(): View
    {
        // ゲスト用のレイアウトビューを返却
        return view('layouts.guest');
    }
}

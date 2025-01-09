<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * コンポーネントを表すビューを取得
     *
     * @return View
     */
    public function render(): View
    {
        // レイアウトビューを返却
        return view('layouts.app');
    }
}

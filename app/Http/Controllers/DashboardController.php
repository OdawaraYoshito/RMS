<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Person;

class DashboardController extends Controller
{
    /**
     * ダッシュボード画面を表示
     *
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ユーザが登録した会社とその関連人物を取得
        $companies = $user->companies() // ログイン中のユーザが所有する会社
            ->with('people') // 会社に関連する人物をロード（Eager Loading）
            ->get();

        // ユーザに紐付いた、会社に属していない人物を取得
        $unassignedPeople = Person::query()
            ->where('user_id', Auth::id()) // ログイン中のユーザの人物データ
            ->whereNull('company_id') // 未所属の条件
            ->get();

        // ダッシュボードビューを表示
        return view('dashboard', compact('companies', 'unassignedPeople'));
    }
}

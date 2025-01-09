<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * ユーザ登録画面を表示
     */
    public function create(): View
    {
        // ユーザ登録ビューを返す
        return view('auth.register');
    }

    /**
     * ユーザ登録リクエストを処理
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 入力データのバリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:255'], // 必須、文字列、最大255文字
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class], // 必須、一意、小文字化
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // パスワード要件を満たす
        ]);

        // 新しいユーザを作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, // メールアドレスを小文字化して保存
            'password' => Hash::make($request->password), // パスワードをハッシュ化
        ]);

        // 登録イベントを発火
        event(new Registered($user));

        // 作成されたユーザでログイン
        Auth::login($user);

        // ダッシュボードにリダイレクト
        return redirect(route('dashboard', absolute: false));
    }
}

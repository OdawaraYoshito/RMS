<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * ユーザのパスワードを更新
     */
    public function update(Request $request): RedirectResponse
    {
        // 入力データのバリデーション
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'], // 現在のパスワードが正しいか確認
            'password' => ['required', Password::defaults(), 'confirmed'], // 新しいパスワード
        ]);

        // ユーザモデルのパスワードを更新
        $request->user()->update([
            'password' => Hash::make($validated['password']), // ハッシュ化して保存
        ]);

        // パスワード更新成功時にステータスを付加して元のページに戻る
        return back()->with('status', 'password-updated');
    }
}

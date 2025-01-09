<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * ユーザプロフィールの編集画面を表示
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        // 現在ログイン中のユーザ情報をビューに渡す
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * ユーザプロフィールを更新
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // バリデーション済みのデータをユーザモデルに反映
        $user->fill($request->validated());

        // メールアドレスが変更された場合、確認ステータスをリセット
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save(); // ユーザ情報を保存

        // プロフィール画面にリダイレクトし、成功メッセージを表示
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * ユーザアカウントを削除
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // ユーザ入力のパスワードを確認
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout(); // ログアウト処理

        // ユーザ情報を削除
        $user->delete();

        // セッションを無効化し、クロスセッション攻撃を防止
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ホームページにリダイレクト
        return Redirect::to('/');
    }
}

<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

/**
 * メール認証画面が正しく表示されることをテスト
 */
test('email verification screen can be rendered', function (): void {
    // メール未認証のテストユーザーを作成
    $user = User::factory()->unverified()->create();

    // メール認証画面にアクセス
    $response = $this->actingAs($user)->get('/verify-email');

    // ステータスコード200（成功）を確認
    $response->assertStatus(200);
});

/**
 * メールアドレスが認証されることをテスト
 */
test('email can be verified', function (): void {
    // メール未認証のテストユーザーを作成
    $user = User::factory()->unverified()->create();

    // イベントの偽装を開始
    Event::fake();

    // 仮のメール認証URLを生成
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',   // ルート名
        now()->addMinutes(60),   // 有効期限
        ['id' => $user->id, 'hash' => sha1($user->email)] // ユーザーIDとメールハッシュ
    );

    // 認証URLにアクセス
    $response = $this->actingAs($user)->get($verificationUrl);

    // メール認証イベントが発火されたことを確認
    Event::assertDispatched(Verified::class);

    // ユーザーがメール認証済みになったことを確認
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();

    // ダッシュボードにリダイレクトされ、verified=1クエリパラメータが含まれていることを確認
    $response->assertRedirect(route('dashboard', absolute: false) . '?verified=1');
});

/**
 * 無効なハッシュではメールアドレスが認証されないことをテスト
 */
test('email is not verified with invalid hash', function (): void {
    // メール未認証のテストユーザーを作成
    $user = User::factory()->unverified()->create();

    // 無効なハッシュを使用した仮のメール認証URLを生成
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',   // ルート名
        now()->addMinutes(60),   // 有効期限
        ['id' => $user->id, 'hash' => sha1('wrong-email')] // 不正なメールハッシュ
    );

    // 認証URLにアクセス
    $this->actingAs($user)->get($verificationUrl);

    // ユーザーがメール認証済みになっていないことを確認
    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

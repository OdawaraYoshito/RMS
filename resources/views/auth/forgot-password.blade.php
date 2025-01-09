<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ config('app.name', 'Relation Management System (RMS)') }} - パスワードリセット
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('RMSでアカウントのパスワードをリセットするためのページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="display-6 font-semibold text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('RMSパスワードリセットページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <!-- カードヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('Forgot Password') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 text-muted">
                            {{ __('パスワードをお忘れですか？問題ありません。登録済みのメールアドレスを入力いただければ、パスワードリセットリンクを送信します。') }}
                        </div>

                        <!-- セッションステータス表示 -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- パスワードリセットフォーム -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- メールアドレス入力 -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 送信ボタン -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Email Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- フッター -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ now()->year }} {{ config('app.name', 'Relation Management System (RMS)') }}</p>
    </footer>
</x-app-layout>

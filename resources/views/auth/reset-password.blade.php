<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ config('app.name', 'Relation Management System (RMS)') }} - 新パスワード登録
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('RMSで新しいパスワードを登録するためのページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="display-6 font-semibold text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('RMS新パスワード登録ページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <!-- カードヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('Reset Password') }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- 新パスワード登録フォーム -->
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- パスワードリセットトークン -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- メールアドレス入力 -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- パスワード入力 -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- パスワード確認 -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 送信ボタン -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
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

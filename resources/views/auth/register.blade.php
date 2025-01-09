<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ config('app.name', 'Relation Management System (RMS)') }} - ユーザ登録ページ
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('RMSは会社と人物の情報を簡単に管理できるシステムです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="display-6 font-semibold text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('RMSユーザ登録ページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <!-- カードヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('Register') }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- ユーザ登録フォーム -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- 名前入力 -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- メールアドレス入力 -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
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

                            <!-- 操作ボタン -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none">
                                    {{ __('Already registered?') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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

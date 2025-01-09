<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ config('app.name', 'Relation Management System (RMS)') }} - パスワード確認
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('アプリケーションのセキュアエリアにアクセスするために、パスワードを再確認する必要があります。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="display-6 font-semibold text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('RMSパスワード確認ページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <!-- カードヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('Confirm Password') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 text-muted">
                            {{ __('このアクションを実行するには、パスワードを再入力してください。') }}
                        </div>

                        <!-- パスワード確認フォーム -->
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <!-- パスワード入力 -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 確認ボタン -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm') }}
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

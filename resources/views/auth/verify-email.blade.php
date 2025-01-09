<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ config('app.name', 'Relation Management System (RMS)') }} - メールアドレス確認
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('メールアドレスを確認して、アカウントを有効化してください。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="display-6 font-semibold text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('RMSメールアドレス確認ページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <!-- カードヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('Verify Email Address') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 text-muted">
                            {{ __('アカウントを有効化するには、登録されたメールアドレスに送信された確認リンクをクリックしてください。リンクを受け取っていない場合は、以下のボタンをクリックして新しいリンクをリクエストしてください。') }}
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-success">
                                {{ __('新しい確認リンクが送信されました。') }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <!-- 再送信フォーム -->
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    {{ __('確認リンクを再送信') }}
                                </button>
                            </form>

                            <!-- ログアウトフォーム -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none">
                                    {{ __('ログアウト') }}
                                </button>
                            </form>
                        </div>
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

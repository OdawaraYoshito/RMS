<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ config('app.name', 'Relation Management System (RMS)') }} - ホームページ
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('RMSは会社と人物の情報を簡単に管理できるシステムです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="display-6 font-semibold text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('RMSホームページ') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <!-- ヘッダーセクション -->
        <header class="bg-primary text-white py-5 text-center">
            <h1>{{ __('ようこそ') }} {{ config('app.name', 'Relation Management System (RMS)') }} {{ __('へ') }}</h1>
            <p class="lead">{{ __('会社と人物の情報を管理できるシステムです。') }}</p>
        </header>

        <!-- ボタンセクション -->
        <div class="text-center mt-4">
            @auth
                <!-- ユーザーがログインしている場合 -->
                <p>{{ __('ログイン済みです。以下のボタンからシステムを利用できます。') }}</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary me-3">ダッシュボード</a>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">プロフィール設定</a>
            @else
                <!-- ユーザーがログインしていない場合 -->
                <p>{{ __('ログインまたは新規登録してシステムを利用開始してください。') }}</p>
                <a href="{{ route('login') }}" class="btn btn-primary me-3">ログイン</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">ユーザ登録</a>
            @endauth
        </div>
    </div>

    <!-- フッター -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ now()->year }} {{ config('app.name', 'Relation Management System (RMS)') }}</p>
    </footer>
</x-app-layout>

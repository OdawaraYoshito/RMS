<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('RMSプロフィール編集ページ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('ユーザーの名前やメールアドレスを更新するためのページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RMSプロフィール編集ページ') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <!-- フォームセクション -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('プロフィールを編集') }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- プロフィール情報更新フォーム -->
                        @include('profile.partials.update-profile-information-form')

                        <!-- パスワード更新フォーム -->
                        <hr class="my-4">
                        @include('profile.partials.update-password-form')

                        <!-- アカウント削除フォーム -->
                        <hr class="my-4">
                        @include('profile.partials.delete-user-form')
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

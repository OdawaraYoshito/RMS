<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ページごとに異なるメタデータ -->
    <meta name="description" content="{{ $metaDescription ?? 'Relation Management System (RMS) - 会社と人物の情報を管理するシンプルで効率的なアプリケーション' }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- BootstrapおよびカスタムCSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- ViteでバンドルしたCSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen bg-light app-background">
        <!-- ナビゲーションバー -->
        @include('layouts.navigation')

        <!-- ページ固有のヘッダー（省略可能） -->
        @isset($header)
            <header class="bg-primary text-white py-4" aria-label="Page Header">
                <div class="container">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- ページコンテンツ -->
        <main class="container mt-5">
            {{ $slot ?? '' }}
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

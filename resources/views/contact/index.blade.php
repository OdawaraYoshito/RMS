<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('お問い合わせ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('RMSへのお問い合わせページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('お問い合わせ') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h2 class="my-4">お問い合わせ</h2>

        <!-- フラッシュメッセージの表示 -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- フォームの開始 -->
        <form action="{{ route('contact.send') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 名前 -->
            <div class="mb-3">
                <label for="name" class="form-label">お名前</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- メールアドレス -->
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 件名（タイトル） -->
            <div class="mb-3">
                <label for="subject" class="form-label">件名</label>
                <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- メッセージ内容 -->
            <div class="mb-3">
                <label for="message" class="form-label">メッセージ</label>
                <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 添付ファイル -->
            <div class="mb-3">
                <label for="attachment" class="form-label">添付ファイル（画像・PDFのみ）</label>
                <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror" accept=".jpg,.jpeg,.png,.gif,.pdf">
                @error('attachment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 送信ボタン -->
            <button type="submit" class="btn btn-primary">送信</button>
        </form>
    </div>

    <!-- フッター -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ now()->year }} {{ config('app.name', 'Relation Management System (RMS)') }}</p>
    </footer>
</x-app-layout>

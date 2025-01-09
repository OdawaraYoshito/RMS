<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('RMS新規会社作成ページ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('新しい会社を登録して、RMSで管理を開始しましょう。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RMS新規会社作成ページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <!-- カードのヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('新しい会社を追加') }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- 会社作成フォーム -->
                        <form method="POST" action="{{ route('companies.store') }}">
                            @csrf

                            <!-- 会社名入力 -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('会社名') }}</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- URL入力 -->
                            <div class="mb-3">
                                <label for="url" class="form-label">{{ __('会社URL') }}</label>
                                <input type="url" id="url" name="url" class="form-control" value="{{ old('url') }}">
                                @error('url')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ステータス選択 -->
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('ステータス') }}</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('アクティブ') }}</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('非アクティブ') }}</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 備考入力 -->
                            <div class="mb-3">
                                <label for="remarks" class="form-label">{{ __('備考') }}</label>
                                <textarea id="remarks" name="remarks" class="form-control" rows="3">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 登録ボタン -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('登録') }}
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

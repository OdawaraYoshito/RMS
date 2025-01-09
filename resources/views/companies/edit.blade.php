<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('RMS会社更新ページ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('会社情報を更新するためのページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RMS会社更新ページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <!-- カードのヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('会社情報を編集') }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- 会社情報編集フォーム -->
                        <form action="{{ route('companies.update', $company) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- フォームメソッドをPUTに設定 -->

                            <!-- 会社名入力 -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('会社名') }}</label>
                                <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- URL入力 -->
                            <div class="mb-3">
                                <label for="url" class="form-label">{{ __('URL') }}</label>
                                <input id="url" type="url" name="url" class="form-control" value="{{ old('url', $company->url) }}">
                                @error('url')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ステータス選択 -->
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('ステータス') }}</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="active" {{ old('status', $company->status) === 'active' ? 'selected' : '' }}>{{ __('アクティブ') }}</option>
                                    <option value="inactive" {{ old('status', $company->status) === 'inactive' ? 'selected' : '' }}>{{ __('非アクティブ') }}</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 備考入力 -->
                            <div class="mb-3">
                                <label for="remarks" class="form-label">{{ __('備考') }}</label>
                                <textarea id="remarks" name="remarks" class="form-control" rows="3">{{ old('remarks', $company->remarks) }}</textarea>
                                @error('remarks')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 更新ボタン -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ __('更新') }}</button>
                                <a href="{{ route('companies.index') }}" class="btn btn-secondary ms-2">{{ __('キャンセル') }}</a>
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

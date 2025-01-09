<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('RMS人物更新ページ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('人物情報を編集するためのページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RMS人物更新ページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <!-- カードのヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('人物情報を編集') }}</h4>
                    </div>
                    <div class="card-body">
                        <!-- 人物情報編集フォーム -->
                        <form method="POST" action="{{ route('people.update', $person) }}">
                            @csrf
                            @method('PUT') <!-- フォームメソッドをPUTに設定 -->

                            <!-- 名前入力 -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('名前') }}</label>
                                <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $person->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 所属会社選択 -->
                            <div class="mb-3">
                                <label for="company_id" class="form-label">{{ __('所属会社') }}</label>
                                <select id="company_id" name="company_id" class="form-select">
                                    <option value="">{{ __('会社を選択しない') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $person->company_id) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 連絡先入力 -->
                            <div class="mb-3">
                                <label for="contact" class="form-label">{{ __('連絡先 (メールアドレス)') }}</label>
                                <input id="contact" type="email" name="contact" class="form-control" value="{{ old('contact', $person->contact) }}">
                                @error('contact')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ステータス選択 -->
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('ステータス') }}</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="active" {{ old('status', $person->status) === 'active' ? 'selected' : '' }}>{{ __('アクティブ') }}</option>
                                    <option value="inactive" {{ old('status', $person->status) === 'inactive' ? 'selected' : '' }}>{{ __('非アクティブ') }}</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 備考入力 -->
                            <div class="mb-3">
                                <label for="remarks" class="form-label">{{ __('備考') }}</label>
                                <textarea id="remarks" name="remarks" class="form-control" rows="3">{{ old('remarks', $person->remarks) }}</textarea>
                                @error('remarks')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ボタン -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ __('更新') }}</button>
                                <a href="{{ route('people.index') }}" class="btn btn-secondary ms-2">{{ __('キャンセル') }}</a>
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

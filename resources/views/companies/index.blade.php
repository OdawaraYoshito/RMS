<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('RMS会社一覧ページ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('登録されている会社の情報を確認、編集、削除ができるページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RMS会社一覧ページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5">
        <h1 class="mb-4">会社リスト</h1>

        <!-- 検索フォーム -->
        <form action="{{ route('companies.index') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <!-- 会社名検索 -->
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="会社名で検索" value="{{ request('name') }}">
                </div>

                <!-- ステータス検索 -->
                <div class="col-md-4">
                    <select name="status" class="form-control">
                        <option value="">すべてのステータス</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>アクティブ</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>非アクティブ</option>
                    </select>
                </div>

                <!-- 表示件数選択 -->
                <div class="col-md-4">
                    <select name="per_page" class="form-control" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10件</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20件</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50件</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100件</option>
                    </select>
                </div>

                <!-- 検索ボタンとリセット -->
                <div class="col-md-4 mt-3">
                    <button type="submit" class="btn btn-primary">検索</button>
                    <a href="{{ route('companies.index') }}" class="btn btn-secondary">リセット</a>
                </div>
            </div>
        </form>

        <!-- 会社リスト表示 -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>会社名</th>
                    <th>URL</th>
                    <th>ステータス</th>
                    <th>備考</th>
                    <th colspan="2">操作</th>
                </tr>
            </thead>
            <tbody>
                <!-- 各会社データを表示 -->
                @forelse ($companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>
                            @if($company->url)
                                <a href="{{ $company->url }}" target="_blank" rel="noopener noreferrer">{{ $company->url }}</a>
                            @else
                                <span class="text-muted">なし</span>
                            @endif
                        </td>
                        <td>{{ $company->status }}</td>
                        <td>{{ $company->remarks }}</td>
                        <td>
                            <!-- 編集ボタン -->
                            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-warning">編集</a>
                        </td>
                        <td>
                            <!-- 削除ボタン -->
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <!-- データがない場合のメッセージ -->
                    <tr>
                        <td colspan="6" class="text-center">該当する会社が見つかりませんでした。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- ページネーション -->
        <div class="mt-4">
            {{ $companies->appends(request()->except('page'))->links() }}
        </div>
    </div>

    <!-- フッター -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ now()->year }} {{ config('app.name', 'Relation Management System (RMS)') }}</p>
    </footer>
</x-app-layout>

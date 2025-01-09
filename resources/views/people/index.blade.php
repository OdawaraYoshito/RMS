<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('RMS人物一覧ページ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('登録されている人物の情報を確認、編集、削除ができるページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RMS人物一覧ページ') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <!-- タイトル -->
        <h1 class="mb-4">人物リスト</h1>

        <!-- 検索フォーム -->
        <form method="GET" action="{{ route('people.index') }}" class="mb-4">
            <div class="row g-3">
                <!-- 名前で検索 -->
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="名前で検索" value="{{ request('name') }}">
                </div>
                <!-- 所属会社で検索 -->
                <div class="col-md-3">
                    <select name="company_id" class="form-control">
                        <option value="">所属会社で検索</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- ステータスで検索 -->
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">ステータスで検索</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>アクティブ</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>非アクティブ</option>
                    </select>
                </div>
                <!-- ページネーション選択 -->
                <div class="col-md-3">
                    <select name="per_page" class="form-control" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10件</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20件</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50件</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100件</option>
                    </select>
                </div>
            </div>
            <!-- 検索ボタン -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">検索</button>
                <a href="{{ route('people.index') }}" class="btn btn-secondary">リセット</a>
            </div>
        </form>

        <!-- 人物リストテーブル -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>所属会社</th>
                    <th>連絡先</th>
                    <th>ステータス</th>
                    <th>備考</th>
                    <th colspan="2">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($people as $person)
                    <tr>
                        <td>{{ $person->name }}</td>
                        <td>{{ $person->company ? $person->company->name : '未設定' }}</td>
                        <td>{{ $person->contact }}</td>
                        <td>{{ $person->status }}</td>
                        <td>{{ $person->remarks }}</td>
                        <td>
                            <a href="{{ route('people.edit', $person->id) }}" class="btn btn-sm btn-warning">編集</a>
                        </td>
                        <td>
                            <form action="{{ route('people.destroy', $person->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">該当する人物データが見つかりませんでした。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- ページネーション -->
        <div class="mt-4">
            {{ $people->appends(request()->except('page'))->links() }}
        </div>
    </div>

    <!-- フッター -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ now()->year }} {{ config('app.name', 'Relation Management System (RMS)') }}</p>
    </footer>
</x-app-layout>

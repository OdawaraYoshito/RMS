<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('RMSダッシュボードページ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('RMSダッシュボードでは、登録済みの会社や人物情報を簡単に管理できます。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RMSダッシュボード') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <!-- タイトル -->
        <h1 class="mb-4">会社情報と人物情報</h1>

        <!-- ナビゲーションボタン -->
        <div class="d-flex justify-content-between mb-4">
            <div>
                <!-- 会社リストと人物リストへのリンク -->
                <a href="{{ route('companies.index') }}" class="btn btn-outline-primary me-2">会社リストを見る</a>
                <a href="{{ route('people.index') }}" class="btn btn-outline-secondary">人物リストを見る</a>
            </div>
            <div>
                <!-- 新しい会社と人物の作成リンク -->
                <a href="{{ route('companies.create') }}" class="btn btn-primary me-2">新しい会社を作成</a>
                <a href="{{ route('people.create') }}" class="btn btn-secondary">新しい人物を作成</a>
            </div>
        </div>

        <!-- 会社情報カード -->
        @foreach ($companies as $company)
            <div class="card mb-3">
                <div class="card-header">
                    <h3>{{ $company->name }}</h3>
                    <p><a href="{{ $company->url }}" target="_blank">{{ $company->url }}</a></p>
                    <p>{{ $company->remarks }}</p>
                </div>
                <div class="card-body">
                    <h5>人物リスト:</h5>
                    @if ($company->people->isEmpty())
                        <p>この会社には登録された人物がいません。</p>
                    @else
                        <ul class="list-group">
                            @foreach ($company->people as $person)
                                <li class="list-group-item">
                                    <strong>{{ $person->name }}</strong> ({{ $person->contact }})
                                    <p>{{ $person->remarks }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- 未所属の人物リスト -->
        @if ($unassignedPeople->isNotEmpty())
            <div class="card mb-3">
                <div class="card-header">
                    <h3>未所属の人物</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($unassignedPeople as $person)
                            <li class="list-group-item">
                                <strong>{{ $person->name }}</strong> ({{ $person->contact }})
                                <p>{{ $person->remarks }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

<nav class="navbar navbar-expand-lg navbar-light border-bottom">
    <div class="container">
        <!-- システムロゴ（トップページへのリンク） -->
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="img-fluid" style="max-height: 120px;">
        </a>

        <!-- ナビゲーションのトグルボタン -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- 認証情報の簡易表示(デバッグ用) -->
            @if (Auth::check())
                <p>認証済み: {{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
                <p>メール認証済み: {{ Auth::user()->email_verified_at ? 'はい' : 'いいえ' }}</p>
            @else
                <p>未認証ユーザーです。</p>
            @endif

            <!-- 右側のナビゲーションメニュー -->
            <ul class="navbar-nav ms-auto">
                <!-- ダッシュボードリンク -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>

                <!-- お問い合わせページへのリンク -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('Contact Us') }}</a>
                </li>

                <!-- エクスポートメニュー -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="exportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Export Data') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                            <!-- エクスポート: 会社 -->
                            <li class="dropdown-item">
                                <a href="{{ route('export.companies', ['format' => 'xlsx']) }}">{{ __('Export Companies (Excel)') }}</a>
                            </li>
                            <li class="dropdown-item">
                                <a href="{{ route('export.companies', ['format' => 'csv']) }}">{{ __('Export Companies (CSV)') }}</a>
                            </li>
                            <!-- エクスポート: 人物 -->
                            <li class="dropdown-item">
                                <a href="{{ route('export.people', ['format' => 'xlsx']) }}">{{ __('Export People (Excel)') }}</a>
                            </li>
                            <li class="dropdown-item">
                                <a href="{{ route('export.people', ['format' => 'csv']) }}">{{ __('Export People (CSV)') }}</a>
                            </li>
                        </ul>
                    </li>

                    <!-- インポートメニュー -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="importDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Import Data') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="importDropdown">
                            <!-- インポート: 会社 -->
                            <li>
                                <form action="{{ route('import.companies') }}" method="POST" enctype="multipart/form-data" class="dropdown-item">
                                    @csrf
                                    <label>{{ __('Import Companies') }}</label>
                                    <input type="file" name="file" accept=".xlsx,.csv" class="form-control form-control-sm">
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">{{ __('Upload') }}</button>
                                </form>
                            </li>
                            <!-- インポート: 人物 -->
                            <li>
                                <form action="{{ route('import.people') }}" method="POST" enctype="multipart/form-data" class="dropdown-item">
                                    @csrf
                                    <label>{{ __('Import People') }}</label>
                                    <input type="file" name="file" accept=".xlsx,.csv" class="form-control form-control-sm">
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">{{ __('Upload') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <!-- ユーザーメニュー -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                            <li>
                                <!-- ログアウトフォーム -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- ログイン/登録リンク（未ログイン時） -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endauth
                <!-- ヘルプページへのリンク -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('help') ? 'active' : '' }}" href="{{ route('help') }}">{{ __('Help') }}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

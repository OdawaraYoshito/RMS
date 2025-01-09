<!-- プロフィール情報更新フォーム -->
<section>
    <header class="mb-4">
        <h2 class="h5 text-primary">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-muted small">
            {{ __("アカウントのプロフィール情報とメールアドレスを更新します。") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
        @csrf
        @method('patch')

        <!-- 名前 -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            <div class="invalid-feedback">
                {{ __('名前を入力してください。') }}
            </div>
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- メールアドレス -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- メール未確認状態 -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning small mt-3">
                <p class="mb-1">{{ __('メールアドレスが未確認です。') }}</p>
                <button form="send-verification" class="btn btn-link p-0">
                    {{ __('確認メールを再送するにはこちらをクリックしてください。') }}
                </button>
                @if (session('status') === 'verification-link-sent')
                    <p class="text-success small mt-1">{{ __('確認メールを再送しました。') }}</p>
                @endif
            </div>
        @endif

        <!-- 保存ボタン -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
</section>

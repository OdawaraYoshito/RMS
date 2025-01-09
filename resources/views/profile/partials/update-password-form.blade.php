<!-- パスワード更新フォーム -->
<section>
    <header class="mb-4">
        <h2 class="h5 text-primary">
            {{ __('Update Password') }}
        </h2>
        <p class="text-muted small">
            {{ __('アカウントのセキュリティを強化するために、安全で長いパスワードを設定してください。') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="needs-validation" novalidate>
        @csrf
        @method('put')

        <!-- 現在のパスワード -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input type="password" id="update_password_current_password" name="current_password" class="form-control" required>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <!-- 新しいパスワード -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input type="password" id="update_password_password" name="password" class="form-control" required>
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <!-- 新しいパスワード確認 -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control" required>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <!-- 保存ボタン -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
</section>

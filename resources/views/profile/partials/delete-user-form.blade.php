<!-- アカウント削除フォーム -->
<section>
    <header class="mb-4">
        <h2 class="h5 text-danger">
            {{ __('Delete Account') }}
        </h2>
        <p class="text-muted small">
            {{ __('アカウント削除により、すべてのデータが完全に削除されます。必要な情報を事前に保存してください。') }}
        </p>
    </header>

    <button class="btn btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}
    </button>

    <!-- モーダル -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h2 class="text-center text-danger">{{ __('本当にアカウントを削除しますか？') }}</h2>
            <p class="text-muted text-center">{{ __('アカウント削除を確認するにはパスワードを入力してください。') }}</p>

            <!-- パスワード入力 -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <x-input-error :messages="$errors->userDeletion->get('password')" />
            </div>

            <!-- キャンセル＆削除ボタン -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
            </div>
        </form>
    </x-modal>
</section>

<section class="space-y-6">
    <header>
        <h2 class="h5">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
        @csrf
        @method('delete')

        <div class="mb-3">
            <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
            <input id="password" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="{{ __('Password') }}">
            @error('password', 'userDeletion')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-danger ms-3" onclick="return confirm('Are you sure you want to delete your account?')">
                {{ __('Delete Account') }}
            </button>
        </div>
    </form>
</section>
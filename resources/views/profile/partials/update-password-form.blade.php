<section class="space-y-4">
    <header>
        <h2 class="text-lg font-semibold text-heading dark:text-white">Update Password</h2>
        <p class="text-sm text-body dark:text-neutral-400">Ensure your account is using a long, random password to stay
            secure.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password"
                class="block text-sm font-medium text-heading dark:text-white mb-1">Current Password</label>
            <input type="password" name="current_password" id="update_password_current_password"
                autocomplete="current-password"
                class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('current_password', 'updatePassword') border-red-500 @enderror">
            @error('current_password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password"
                class="block text-sm font-medium text-heading dark:text-white mb-1">New Password</label>
            <input type="password" name="password" id="update_password_password" autocomplete="new-password"
                class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password', 'updatePassword') border-red-500 @enderror">
            @error('password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation"
                class="block text-sm font-medium text-heading dark:text-white mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="update_password_password_confirmation"
                autocomplete="new-password"
                class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-base hover:bg-primary-700 transition focus:outline-none focus:ring-2 focus:ring-primary-500">Save</button>
            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600 dark:text-green-400">Saved.</p>
            @endif
        </div>
    </form>
</section>

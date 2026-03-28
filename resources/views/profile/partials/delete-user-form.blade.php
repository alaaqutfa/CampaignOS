<section class="space-y-4">
    <header>
        <h2 class="text-lg font-semibold text-heading dark:text-white">Delete Account</h2>
        <p class="text-sm text-body dark:text-neutral-400">Once your account is deleted, all of its resources and data
            will be permanently deleted. Before deleting your account, please download any data or information that you
            wish to retain.</p>
    </header>

    <!-- Button to trigger modal -->
    <button type="button" data-modal-target="delete-user-modal" data-modal-toggle="delete-user-modal"
        class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-base hover:bg-red-100 dark:hover:bg-red-800/30 transition focus:outline-none focus:ring-2 focus:ring-red-500">
        Delete Account
    </button>

    <!-- Modal -->
    <div id="delete-user-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-light dark:bg-dark rounded-base shadow border border-default">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-semibold text-heading dark:text-white">Are you sure you want to delete your
                        account?</h2>
                    <p class="mt-1 text-sm text-body dark:text-neutral-400">Once your account is deleted, all of its
                        resources and data will be permanently deleted. Please enter your password to confirm.</p>

                    <div class="mt-4">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password"
                            class="w-full px-3 py-2 border border-default rounded-base bg-light dark:bg-dark text-heading dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password', 'userDeletion') border-red-500 @enderror">
                        @error('password', 'userDeletion')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" data-modal-hide="delete-user-modal"
                            class="px-4 py-2 text-sm font-medium text-heading dark:text-white bg-light border border-default rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 transition focus:outline-none focus:ring-2 focus:ring-primary-500">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-base hover:bg-red-700 transition focus:outline-none focus:ring-2 focus:ring-red-500">Delete
                            Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

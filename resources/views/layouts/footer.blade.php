<footer class="bg-light dark:bg-dark border-t border-neutral-200 dark:border-neutral-700 mt-8">
    <div class="container mx-auto px-4 py-6 md:flex md:items-center md:justify-between">
        <span class="text-sm text-neutral-500 dark:text-gray-400 sm:text-center">
            © {{ date('Y') }} <a href="{{ url('/') }}"
                class="hover:text-primary-600 dark:hover:text-primary-400">CampaignOS</a>. All Rights Reserved.
        </span>
        <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-neutral-500 dark:text-gray-400 sm:mt-0">
            <li>
                <a href="{{ route('pages.about') }}"
                    class="hover:text-primary-600 dark:hover:text-primary-400 me-4 md:me-6">About</a>
            </li>
            <li>
                <a href="{{ route('pages.privacy') }}"
                    class="hover:text-primary-600 dark:hover:text-primary-400 me-4 md:me-6">Privacy Policy</a>
            </li>
            <li>
                <a href="{{ route('pages.terms') }}"
                    class="hover:text-primary-600 dark:hover:text-primary-400 me-4 md:me-6">Terms of Service</a>
            </li>
            <li>
                <a href="{{ route('pages.contact') }}"
                    class="hover:text-primary-600 dark:hover:text-primary-400">Contact</a>
            </li>
        </ul>
    </div>
</footer>

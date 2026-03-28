@php
    $user = Auth::user();
    $isSuperAdmin = $user->hasRole('super_admin');
    $isCompanyAdmin = $user->hasRole('company_admin');
@endphp

<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full sm:translate-x-0 bg-light dark:bg-dark border-r border-neutral-200 dark:border-neutral-700"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <ul class="space-y-1 font-medium">
            @if($isSuperAdmin)
                {{-- Super Admin Menu --}}
                <li>
                    <a href="{{ route('super-admin.dashboard') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('super-admin.dashboard') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('super-admin.companies.index') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('super-admin.companies.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2-1h8a1 1 0 011 1v12a1 1 0 01-1 1H6a1 1 0 01-1-1V4a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                            <path d="M8 6h4v2H8V6zm0 4h4v2H8v-2z"></path>
                        </svg>
                        <span class="ms-3">Companies</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('super-admin.users.index') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('super-admin.users.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                            </path>
                        </svg>
                        <span class="ms-3">Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('super-admin.plans.index') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('super-admin.plans.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-1 1v8a1 1 0 001 1h10a1 1 0 001-1V8a1 1 0 00-1-1h-1V6a4 4 0 00-4-4zM8 6a2 2 0 114 0v1H8V6zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ms-3">Plans</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('super-admin.subscriptions.index') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('super-admin.plans.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-1 1v8a1 1 0 001 1h10a1 1 0 001-1V8a1 1 0 00-1-1h-1V6a4 4 0 00-4-4zM8 6a2 2 0 114 0v1H8V6zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Subscriptions</span>
                    </a>
                </li>
            @else
                {{-- Company / Regular User Menu --}}
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('dashboard') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                @can('view campaigns')
                    <li>
                        <a href="{{ route('campaigns.index') }}"
                            class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('campaigns.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                            <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                                </path>
                            </svg>
                            <span class="ms-3">Campaigns</span>
                        </a>
                    </li>
                @endcan
                <li>
                    <a href="{{ route('cities.index') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('cities.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.002.018-.006a5.854 5.854 0 00.27-.115 8.354 8.354 0 002.571-2.007c.765-.872 1.425-1.969 1.835-3.16.416-1.206.598-2.474.5-3.729-.097-1.254-.451-2.482-.988-3.581a9.71 9.71 0 00-1.866-2.584L10 4.5l-1.353 1.25a9.71 9.71 0 00-1.866 2.584c-.537 1.099-.89 2.327-.988 3.581-.098 1.255.084 2.523.5 3.729.41 1.191 1.07 2.288 1.835 3.16a8.354 8.354 0 002.571 2.007l.018.006.006.002zM10 12a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ms-3">Cities</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('shops.index') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('shops.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 text-neutral-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v7a2 2 0 002 2h12a2 2 0 002-2V9zM7 12h6a1 1 0 011 1v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-1a1 1 0 011-1z">
                            </path>
                        </svg>
                        <span class="ms-3">Shops</span>
                    </a>
                </li>
                @can('view users')
                    <li>
                        <a href="{{ route('users.index') }}"
                            class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('users.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                            <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <span class="ms-3">Staff</span>
                        </a>
                    </li>
                @endcan
                <li>
                    <a href="{{ route('company.subscriptions.index') }}"
                        class="flex items-center p-2 text-neutral-900 dark:text-white rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 group {{ request()->routeIs('users.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}">
                        <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span class="ms-3">Subscriptions</span>
                    </a>
                </li>
                <li class="flex justify-center items-center flex-col gap-4">
                    <hr class="w-full h-[1px] bg-dark dark:bg-light">
                    <a href="#"
                        class="w-full sm:w-auto bg-dark dark:bg-light hover:bg-blue-500 hover:dark:bg-blue-500 transition-colors ease-in focus:ring-4 focus:outline-none focus:ring-neutral-quaternary text-white dark:text-black rounded-base inline-flex items-center justify-center px-4 py-3">
                        <svg class="me-2 w-7 h-7" aria-hidden="true" focusable="false" data-prefix="fab"
                            data-icon="google-play" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l256.6-256L47 0zm425.2 225.6l-58.9-34.1-65.7 64.5 65.7 64.5 60.1-34.1c18-14.3 18-46.5-1.2-60.8zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z">
                            </path>
                        </svg>
                        <div class="text-left rtl:text-right">
                            <div class="text-xs">Get in on</div>
                            <div class="text-sm font-bold">Google Play</div>
                        </div>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>

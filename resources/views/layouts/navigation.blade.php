@php
    $user = Auth::user();
    $isSuperAdmin = $user->hasRole('super_admin');
@endphp
<nav class="fixed top-0 z-50 w-full bg-light dark:bg-dark border-b border-neutral-200 dark:border-neutral-700">
    <div class="px-3 py-2 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar" type="button"
                    class="sm:hidden inline-flex items-center p-2 text-neutral-500 rounded-base hover:bg-neutral-100 dark:hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <a href="{{ $isSuperAdmin ? route('super-admin.dashboard') : route('dashboard') }}" class="flex items-center ms-2 md:me-24">
                    <img src="{{ asset('public/assets/img/icon.png') }}" class="h-6 me-3" alt="CampaignOS Logo" />
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-primary-600 dark:text-primary-400">CampaignOS</span>
                </a>
            </div>

            <div class="flex items-center gap-2">
                <!-- Dark Mode Toggle (optional) -->
                <button id="theme-toggle" type="button" class="text-neutral-500 dark:text-gray-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div class="relative">
                    <button type="button" class="flex text-sm rounded-full focus:ring-2 focus:ring-primary-500" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=5B3DF5&color=fff' }}" alt="{{ Auth::user()->name }}">
                    </button>
                    <div class="z-50 hidden bg-light dark:bg-dark border border-neutral-200 dark:border-neutral-700 rounded-base shadow-lg w-44" id="dropdown-user">
                        <div class="px-4 py-3 border-b border-neutral-200 dark:border-neutral-700">
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-neutral-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <ul class="py-1 text-sm text-neutral-700 dark:text-neutral-300">
                            <li>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-800">Profile</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-800">Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

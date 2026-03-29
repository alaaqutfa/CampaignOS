<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo & description -->
            <div>
                <img src="{{ asset('assets/img/icon.png') }}" class="h-10 mb-3" alt="CampaignOS Logo" />
                <h3 class="text-xl font-bold gradient-text">CampaignOS</h3>
                <p class="mt-2 text-gray-400">The Operating System for Advertising Campaigns</p>
            </div>

            <!-- Product links -->
            <div>
                <h4 class="font-semibold">Product</h4>
                <ul class="mt-2 space-y-1">
                    <li><a href="{{ url('/#features') }}" class="text-gray-400 hover:text-white">Features</a></li>
                    <li><a href="{{ url('/#pricing') }}" class="text-gray-400 hover:text-white">Pricing</a></li>
                </ul>
            </div>

            <!-- Company links -->
            <div>
                <h4 class="font-semibold">Company</h4>
                <ul class="mt-2 space-y-1">
                    <li><a href="{{ route('pages.about') }}" class="text-gray-400 hover:text-white">About</a></li>
                    <li><a href="{{ route('pages.contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
                    <li><a href="{{ route('pages.faq') }}" class="text-gray-400 hover:text-white">FAQ</a></li>
                </ul>
            </div>

            <!-- Support / Legal links -->
            <div>
                <h4 class="font-semibold">Support</h4>
                <ul class="mt-2 space-y-1">
                    <li><a href="{{ route('pages.terms') }}" class="text-gray-400 hover:text-white">Terms of Service</a>
                    </li>
                    <li><a href="{{ route('pages.privacy') }}" class="text-gray-400 hover:text-white">Privacy Policy</a>
                    </li>
                    <li><a href="{{ route('pages.cookie') }}" class="text-gray-400 hover:text-white">Cookie Policy</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} CampaignOS. All rights reserved.</p>
        </div>
    </div>
</footer>

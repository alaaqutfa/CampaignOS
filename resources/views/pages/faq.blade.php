@extends('landing.app')

@section('title', 'Frequently Asked Questions')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl bg-white dark:bg-gray-800">
        <h1 class="text-3xl font-bold mb-6 dark:text-white">Frequently Asked Questions</h1>

        <div class="space-y-6 dark:text-white">
            <div>
                <h2 class="text-xl font-semibold">How do I create a campaign?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">After logging in, navigate to "Campaigns" and click "New
                    Campaign". Fill in the details and save. You can then add measurements and assets.</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold">What is a measurement item?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">A measurement item represents a specific location (shop)
                    within a campaign. You can record before/after photos and track installation status.</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold">How do I upgrade my subscription?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Company admins can request a new subscription from the
                    "Subscriptions" section. The admin will then process your request.</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold">Can I change my password?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Yes, go to your profile settings (click your avatar in the
                    top right) and select "Change Password".</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold">How do I add users to my company?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Company admins can go to "Staff" and click "Add New User".
                    You can assign roles such as designer, contractor, etc.</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold">What happens if I exceed my plan limits?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">You will be notified and may need to upgrade to a higher
                    plan. Limits are checked automatically when creating new campaigns or users.</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold">Is my data secure?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Yes, we use encryption and secure servers. Please refer to
                    our <a href="{{ route('pages.privacy') }}" class="text-blue-600 hover:underline">Privacy Policy</a> for
                    details.</p>
            </div>
        </div>
    </div>
@endsection

@extends('landing.app')

@section('title', 'Cookie Policy')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl bg-white dark:bg-gray-800">
        <h1 class="text-3xl font-bold mb-6 dark:text-white">Cookie Policy</h1>

        <div class="prose dark:prose-invert max-w-none dark:text-white">
            <p>This Cookie Policy explains how CampaignOS uses cookies and similar technologies.</p>

            <h2>What are cookies?</h2>
            <p>Cookies are small text files stored on your device when you visit websites. They help us remember your
                preferences and improve your experience.</p>

            <h2>Types of cookies we use</h2>
            <ul>
                <li><strong>Essential cookies:</strong> Necessary for the Platform to function (e.g., authentication).</li>
                <li><strong>Preference cookies:</strong> Remember your settings (e.g., language, theme).</li>
                <li><strong>Analytics cookies:</strong> Help us understand how visitors interact with the Platform (e.g.,
                    Google Analytics).</li>
            </ul>

            <h2>Third-party cookies</h2>
            <p>We may use services like Google Analytics that set their own cookies. These are governed by the third
                parties' privacy policies.</p>

            <h2>Managing cookies</h2>
            <p>You can control or delete cookies through your browser settings. Please note that disabling essential cookies
                may affect functionality.</p>

            <h2>Changes to this policy</h2>
            <p>We may update this policy from time to time. Continued use of the Platform indicates acceptance of changes.
            </p>

            <h2>Contact</h2>
            <p>If you have questions, email <a href="mailto:support@campaignos.com"
                    class="text-blue-600 hover:underline">support@campaignos.com</a>.</p>
        </div>
    </div>
@endsection

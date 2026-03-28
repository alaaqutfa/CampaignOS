@extends('landing.app')

@section('title', 'Terms of Service')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl bg-white dark:bg-gray-800">
        <h1 class="text-3xl font-bold mb-6 dark:text-white">Terms of Service</h1>

        <div class="prose dark:prose-invert max-w-none dark:text-white">
            <p>Last updated: {{ now()->format('F d, Y') }}</p>

            <h2>1. Acceptance of Terms</h2>
            <p>By accessing or using CampaignOS ("the Platform"), you agree to be bound by these Terms of Service. If you do
                not agree, please do not use the Platform.</p>

            <h2>2. Description of Service</h2>
            <p>CampaignOS provides tools for managing advertising campaigns, measurements, assets, and workflows. The
                Platform is intended for businesses and their authorized personnel.</p>

            <h2>3. User Accounts</h2>
            <p>You are responsible for maintaining the confidentiality of your account credentials. You agree to notify us
                immediately of any unauthorized use. We reserve the right to suspend or terminate accounts that violate
                these terms.</p>

            <h2>4. Subscription and Payments</h2>
            <p>Certain features require a paid subscription. Fees are billed in advance and are non-refundable except as
                required by law. You may cancel your subscription at any time; cancellation will take effect at the end of
                the current billing period.</p>

            <h2>5. Acceptable Use</h2>
            <p>You may not use the Platform for any illegal or unauthorized purpose. You must comply with all applicable
                laws and regulations. You are solely responsible for any content you upload or share.</p>

            <h2>6. Intellectual Property</h2>
            <p>All content, trademarks, and intellectual property on the Platform are owned by us or our licensors. You may
                not copy, modify, or distribute any part without permission.</p>

            <h2>7. Limitation of Liability</h2>
            <p>To the maximum extent permitted by law, we shall not be liable for any indirect, incidental, or consequential
                damages arising from your use of the Platform.</p>

            <h2>8. Changes to Terms</h2>
            <p>We may update these terms from time to time. Continued use of the Platform after changes constitutes
                acceptance of the new terms.</p>

            <h2>9. Contact</h2>
            <p>If you have any questions, please contact us at <a href="mailto:support@campaignos.com"
                    class="text-blue-600 hover:underline">support@campaignos.com</a>.</p>
        </div>
    </div>
@endsection

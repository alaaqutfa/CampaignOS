@extends('landing.app')

@section('title', 'Privacy Policy')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl bg-white dark:bg-gray-800">
        <h1 class="text-3xl font-bold mb-6">Privacy Policy</h1>

        <div class="prose dark:prose-invert max-w-none">
            <p>Last updated: {{ now()->format('F d, Y') }}</p>

            <h2>1. Information We Collect</h2>
            <p>We collect personal information you provide directly, such as name, email, company details. We also collect
                usage data automatically (IP address, browser type, pages visited).</p>

            <h2>2. How We Use Your Information</h2>
            <p>We use your information to operate, maintain, and improve the Platform; to process transactions; to
                communicate with you; and to comply with legal obligations.</p>

            <h2>3. Sharing of Information</h2>
            <p>We do not sell your personal information. We may share it with service providers who assist us, or as
                required by law. Your data is stored securely within the Platform.</p>

            <h2>4. Data Retention</h2>
            <p>We retain your information as long as your account is active or as needed to provide services. You may
                request deletion of your data subject to legal requirements.</p>

            <h2>5. Security</h2>
            <p>We implement reasonable security measures to protect your data. However, no method of transmission over the
                internet is 100% secure.</p>

            <h2>6. Cookies</h2>
            <p>We use cookies to enhance user experience. See our <a href="{{ route('pages.cookie') }}"
                    class="text-blue-600 hover:underline">Cookie Policy</a> for details.</p>

            <h2>7. Your Rights</h2>
            <p>Depending on your location, you may have rights to access, correct, or delete your personal data. Contact us
                to exercise these rights.</p>

            <h2>8. Contact Us</h2>
            <p>For privacy inquiries, email <a href="mailto:privacy@campaignos.com"
                    class="text-blue-600 hover:underline">privacy@campaignos.com</a>.</p>
        </div>
    </div>
@endsection

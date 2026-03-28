@extends('landing.app')

@section('title', 'About Us')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl bg-white dark:bg-gray-800">
        <h1 class="text-3xl font-bold mb-6 dark:text-white">About CampaignOS</h1>

        <div class="prose dark:prose-invert max-w-none dark:text-white">
            <p>CampaignOS is a comprehensive platform designed to streamline the management of advertising campaigns,
                measurements, and workflows. Our mission is to empower businesses with intuitive tools to manage their
                outdoor advertising efficiently.</p>

            <h2>Our Story</h2>
            <p>Founded in 2026, CampaignOS emerged from the need for a unified solution that connects campaign planning,
                execution, and tracking. We believe in simplifying complex processes so that teams can focus on what matters
                most – delivering impactful campaigns.</p>

            <h2>What We Offer</h2>
            <ul>
                <li>Campaign management with real-time status updates</li>
                <li>Measurement and asset tracking (before/after photos)</li>
                <li>Workflow automation for design, print, and installation</li>
                <li>Detailed audit logs and issue tracking</li>
                <li>Multi‑company support with role‑based access</li>
            </ul>

            <h2>Our Team</h2>
            <p>We are a dedicated team of developers, designers, and marketing professionals committed to delivering
                high‑quality solutions. We value transparency, innovation, and customer satisfaction.</p>

            <h2>Contact Us</h2>
            <p>We’d love to hear from you! Visit our <a href="{{ route('pages.contact') }}"
                    class="text-blue-600 hover:underline">Contact Page</a> or email us at <a
                    href="mailto:info@campaignos.com">info@campaignos.com</a>.</p>
        </div>
    </div>
@endsection

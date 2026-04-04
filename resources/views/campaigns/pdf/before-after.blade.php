<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Before/After Report - {{ $campaign->title }}</title>

    <style>
        /* ============================================
            GLOBAL & PAGE SETUP (A4 Landscape)
        ============================================= */
        @page {
            size: A4 landscape;
            margin: 1.2cm;
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', 'Helvetica Neue', sans-serif;
            background: #ffffff;
            color: #1e293b;
            font-size: 12px;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }

        /* ============================================
           REUSABLE COMPONENTS
        ============================================= */
        .page {
            page-break-after: always;
            margin-bottom: 30px;
        }

        /* Region header with modern gradient */
        .region-header {
            text-align: center;
            margin: 20px 0 30px;
            page-break-after: avoid;
        }

        .region-header h2 {
            font-size: 28px;
            background: linear-gradient(135deg, #5B3DF5, #3B82F6, #22D3EE);
            display: inline-block;
            padding: 8px 32px;
            border-radius: 60px;
            color: white;
            letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(91, 61, 245, 0.2);
        }

        /* Campaign master header */
        .master-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e2e8f0;
        }

        .master-header h1 {
            font-size: 26px;
            background: linear-gradient(120deg, #5B3DF5, #3B82F6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0 0 8px 0;
        }

        .campaign-meta {
            display: flex;
            justify-content: center;
            gap: 24px;
            color: #475569;
            font-size: 11px;
        }

        /* Report card container */
        .report-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2ff;
            overflow: hidden;
            margin-bottom: 28px;
            page-break-inside: avoid;
            transition: all 0.2s;
        }

        /* Card header with gradient strip */
        .card-header {
            background: linear-gradient(105deg, #f8fafc 0%, #ffffff 100%);
            padding: 16px 24px;
            border-bottom: 2px solid #e0e7ff;
        }

        .shop-title {
            font-size: 18px;
            font-weight: 800;
            color: #1e1b4b;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .shop-badge {
            background: #5B3DF5;
            color: white;
            font-size: 11px;
            padding: 4px 14px;
            border-radius: 40px;
            font-weight: 500;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 14px;
        }

        .detail-item {
            background: #f1f5f9;
            padding: 8px 12px;
            border-radius: 32px;
            text-align: center;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .detail-label {
            font-weight: 700;
            color: #5B3DF5;
        }

        /* Image gallery - 2 columns with modern design */
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            padding: 24px;
            background: #fefefe;
        }

        .image-card {
            flex: 1;
            min-width: 220px;
            border-radius: 20px;
            background: #f9fafb;
            padding: 16px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            transition: all 0.2s;
            border: 1px solid #f0f2f5;
        }

        .image-label {
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 18px;
            border-radius: 40px;
            background: #eef2ff;
            color: #3B82F6;
        }

        .image-label.before {
            background: #dbeafe;
            color: #2563eb;
        }

        .image-label.after {
            background: #dcfce7;
            color: #15803d;
        }

        .image-wrapper {
            margin-top: 12px;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .image-wrapper img {
            width: 100%;
            height: auto;
            max-height: 280px;
            object-fit: contain;
            display: block;
        }

        .no-image {
            padding: 50px 20px;
            color: #94a3b8;
            font-style: normal;
            background: #f8fafc;
            border-radius: 16px;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .card-footer {
            background: #fafcff;
            border-top: 1px solid #eef2ff;
            padding: 10px 24px;
            font-size: 9px;
            color: #94a3b8;
            text-align: right;
        }

        .page-number {
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            margin-top: 8px;
        }

        /* SVG icon sizing */
        .icon-svg {
            width: 16px;
            height: 16px;
            vertical-align: middle;
        }

        .icon-large {
            width: 32px;
            height: 32px;
        }
    </style>
</head>

<body>
    @foreach($grouped as $regionName => $regionItems)
        <!-- REGION HEADER PAGE (intro for region) -->
        <div class="page">
            <div class="region-header">
                <h2>{{ $regionName }}</h2>
            </div>
            <div class="master-header">
                <h1>{{ $campaign->title }}</h1>
                <div class="campaign-meta">
                    <span>
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M15 9h6m-6 3h6m-6 3h6M3 9h6m-6 3h6m-6 3h6M9 5v16m6-16v16" stroke="currentColor" />
                        </svg>
                        {{ $campaign->client_name ?? '—' }}
                    </span>
                    <span>
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 21a9 9 0 100-18 9 9 0 000 18z" stroke="currentColor" />
                            <path d="M12 7v5l3 3" stroke="currentColor" />
                        </svg>
                        Due: {{ $campaign->due_date ? $campaign->due_date->format('M d, Y') : '—' }}
                    </span>
                    <span>
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                stroke="currentColor" />
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" />
                        </svg>
                        {{ $campaign->location ?? '—' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- ITEMS OF THIS REGION -->
        @foreach($regionItems as $item)
            <div class="page">
                <div class="report-card">
                    <div class="card-header">
                        <div class="shop-title">
                            <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M3 9l9-6 9 6v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke="currentColor" />
                                <path d="M9 22V12h6v10" stroke="currentColor" />
                            </svg>
                            {{ $item->shop->name }}
                            <span class="shop-badge">{{ $item->shop->city->name ?? 'No city' }}</span>
                        </div>
                        <div class="details-grid">
                            <div class="detail-item">
                                <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M4 7h16M4 12h16M4 17h10" stroke="currentColor" />
                                </svg>
                                <span class="detail-label">Material:</span> {{ $item->material }}
                            </div>
                            <div class="detail-item">
                                <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" />
                                    <path d="M8 8h8M8 12h6" stroke="currentColor" />
                                </svg>
                                <span class="detail-label">Dimensions:</span> {{ $item->width }}x{{ $item->height }}
                                {{ $item->unit }}
                            </div>
                            <div class="detail-item">
                                <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M9 12h6M12 9v6" stroke="currentColor" />
                                    <circle cx="12" cy="12" r="9" stroke="currentColor" />
                                </svg>
                                <span class="detail-label">Qty:</span> {{ $item->quantity }}
                            </div>
                            <div class="detail-item">
                                <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M20 12H4M12 4v16" stroke="currentColor" />
                                    <rect x="2" y="2" width="20" height="20" rx="2" stroke="currentColor" />
                                </svg>
                                <span class="detail-label">SQM:</span> {{ number_format($item->sqm, 2) }}
                            </div>
                        </div>
                    </div>

                    <div class="image-gallery">
                        <!-- Before Image Card -->
                        <div class="image-card">
                            <div class="image-label before">
                                <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                                        stroke="currentColor" />
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" />
                                </svg>
                                Before Installation
                            </div>
                            <div class="image-wrapper">

                                @php $before = $item->assets->where('type', 'before')->first(); @endphp
                                @if($before)
                                    <img src="{{ public_path('storage/' . $before->path) }}"
                                        onerror="this.src='https://placehold.co/1080x1080/667eea/ffffff?text=Before'"
                                        alt="Before installation">
                                @else
                                    <div class="no-image">
                                        <svg class="icon-large" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.2">
                                            <path d="M4 16l4-4 4 4 4-4 4 4M4 8h16" stroke="currentColor" />
                                            <rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" />
                                        </svg>
                                        <span>No before image available</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- After Image Card -->
                        <div class="image-card">
                            <div class="image-label after">
                                <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" />
                                    <path d="M9 12l2 2 4-4" stroke="currentColor" />
                                </svg>
                                After Installation
                            </div>
                            <div class="image-wrapper">
                                @php $after = $item->assets->where('type', 'after')->first(); @endphp
                                @if($after)
                                    <img src="{{ public_path('storage/' . $after->path) }}"
                                        onerror="this.src='https://placehold.co/1080x1080/667eea/ffffff?text=After'"
                                        alt="After installation">
                                @else
                                    <div class="no-image">
                                        <svg class="icon-large" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.2">
                                            <path d="M12 4v16m8-8H4" stroke="currentColor" />
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" />
                                        </svg>
                                        <span>No after image uploaded</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <svg class="icon-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" />
                        </svg>
                        Generated: {{ now()->format('d M Y, H:i') }}
                    </div>
                </div>
                <div class="page-number">
                    Page {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                </div>
            </div>
        @endforeach
    @endforeach
</body>

</html>

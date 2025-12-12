@extends('Admin.AdminLayout')

@section('title', 'Sponsor Details')

<style>
    /* === SPONSOR DETAILS PAGE STYLES === */
    :root {
        --primary: #4361ee;
        --primary-light: #4895ef;
        --primary-dark: #3a0ca3;
        --secondary: #7209b7;
        --success: #38b000;
        --warning: #f72585;
        --danger: #e63946;
        --info: #4cc9f0;
        --light-bg: #f8f9ff;
        --card-shadow: 0 8px 30px rgba(67, 97, 238, 0.08);
        --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.12);
    }

    /* === PAGE LAYOUT === */
    .container-fluid {
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        min-height: calc(100vh - 70px);
    }

    /* === MAIN CARD === */
    .card.shadow-sm {
        border: none;
        border-radius: 20px;
        box-shadow: var(--card-shadow) !important;
        background: white;
        overflow: hidden;
        border: 1px solid #f0f3ff;
        animation: fadeInUp 0.5s ease-out;
    }

    /* === CARD HEADER === */
    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        color: white;
        border: none;
        padding: 1.75rem 2rem !important;
        border-radius: 20px 20px 0 0 !important;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 12px 12px;
        opacity: 0.2;
    }

    .card-header h5 {
        font-size: 1.6rem !important;
        font-weight: 700 !important;
        color: white !important;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header h5::before {
        content: '👤';
        font-size: 1.4rem;
        filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.2));
    }

    /* === BACK BUTTON === */
    .btn-outline-secondary {
        border: 2px solid rgba(255, 255, 255, 0.3) !important;
        color: white !important;
        background: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(10px);
        border-radius: 10px !important;
        padding: 0.5rem 1.25rem !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
        transition: all 0.3s ease !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .btn-outline-secondary:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        transform: translateX(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
    }

    /* === CARD BODY === */
    .card-body {
        padding: 2.5rem 2rem !important;
        background: white;
    }

    /* === DETAILS LAYOUT === */
    .row > div {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }

    .row > .col-md-6:nth-child(1) { animation-delay: 0.1s; }
    .row > .col-md-6:nth-child(2) { animation-delay: 0.2s; }

    /* === DETAILS LIST === */
    dl.row {
        margin: 0;
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.02) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-radius: 16px;
        padding: 1.5rem !important;
        border: 1px solid #f0f3ff;
    }

    dt.col-sm-4 {
        font-weight: 600 !important;
        color: var(--primary-dark) !important;
        padding: 0.75rem 1rem !important;
        border-bottom: 1px dashed #e8edff;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    dd.col-sm-8 {
        color: #1e293b !important;
        padding: 0.75rem 1rem !important;
        border-bottom: 1px dashed #e8edff;
        font-size: 0.95rem;
        font-weight: 500;
        margin: 0;
    }

    /* Add icons to detail labels */
    dt.col-sm-4:nth-child(1)::before { content: '👤'; }
    dt.col-sm-4:nth-child(3)::before { content: '📧'; }
    dt.col-sm-4:nth-child(5)::before { content: '📱'; }
    dt.col-sm-4:nth-child(7)::before { content: '🔑'; }

    /* === NOTES SECTION === */
    .col-md-6:nth-child(2) {
        padding-left: 2rem;
    }

    .text-muted {
        font-size: 1rem !important;
        font-weight: 600 !important;
        color: var(--primary-dark) !important;
        margin-bottom: 1rem !important;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .text-muted::before {
        content: '📝';
        font-size: 1.1rem;
    }

    .col-md-6:nth-child(2) p {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.02) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-radius: 16px;
        padding: 1.5rem !important;
        border: 1px solid #f0f3ff;
        color: #475569;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
        min-height: 200px;
        display: flex;
        align-items: flex-start;
    }

    /* Empty notes styling */
    .col-md-6:nth-child(2) p:empty::before {
        content: 'No notes provided.';
        color: #94a3b8;
        font-style: italic;
    }

    /* === HR STYLING === */
    hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e8edff, transparent);
        margin: 2.5rem 0;
        opacity: 0;
        animation: fadeIn 0.5s ease-out 0.3s forwards;
    }

    /* === SCHOLARSHIPS SECTION === */
    h6.mt-4 {
        font-size: 1.2rem !important;
        font-weight: 700 !important;
        color: var(--primary-dark) !important;
        margin-bottom: 1.5rem !important;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        opacity: 0;
        animation: fadeIn 0.5s ease-out 0.4s forwards;
    }

    h6.mt-4::before {
        content: '🏆';
        font-size: 1.1rem;
    }

    /* === SCHOLARSHIP LIST === */
    .list-group {
        border-radius: 16px !important;
        border: 1px solid #f0f3ff !important;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.05);
        opacity: 0;
        animation: fadeIn 0.5s ease-out 0.5s forwards;
    }

    .list-group-item {
        border: none !important;
        border-bottom: 1px solid #f0f3ff !important;
        padding: 1.25rem 1.5rem !important;
        background: white;
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(136, 149, 239, 0.01) 100%);
        transform: translateX(5px);
    }

    .list-group-item:last-child {
        border-bottom: none !important;
    }

    .list-group-item h6 {
        font-weight: 600 !important;
        color: #1e293b !important;
        margin-bottom: 0.25rem !important;
        font-size: 1rem;
    }

    .list-group-item small {
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .list-group-item small::before {
        content: '🎯';
        font-size: 0.9rem;
    }

    /* === VIEW SCHOLARSHIP BUTTON === */
    .btn-outline-info {
        border: 2px solid var(--info) !important;
        color: var(--info) !important;
        background: rgba(76, 201, 240, 0.05) !important;
        border-radius: 8px !important;
        padding: 0.5rem 1.25rem !important;
        font-weight: 600 !important;
        font-size: 0.85rem !important;
        transition: all 0.3s ease !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-outline-info:hover {
        background: var(--info) !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 201, 240, 0.2);
    }

    /* === NO SCHOLARSHIPS ALERT === */
    .alert-info {
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.1) 0%, rgba(255, 255, 255, 0.95) 100%) !important;
        color: #1e293b !important;
        border: 2px solid rgba(76, 201, 240, 0.2) !important;
        border-radius: 12px !important;
        padding: 1.5rem !important;
        box-shadow: 0 4px 15px rgba(76, 201, 240, 0.08) !important;
        display: flex;
        align-items: center;
        gap: 1rem;
        opacity: 0;
        animation: fadeIn 0.5s ease-out 0.5s forwards;
    }

    .alert-info::before {
        content: 'ℹ️';
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* === EDIT BUTTON === */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 1rem 2.5rem !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2) !important;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
        opacity: 0;
        animation: fadeIn 0.5s ease-out 0.6s forwards;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.3) !important;
    }

    /* === ANIMATIONS === */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* === RESPONSIVE DESIGN === */
    @media (max-width: 992px) {
        .container-fluid {
            padding: 1.5rem;
        }

        .card-body {
            padding: 2rem 1.5rem !important;
        }

        .card-header {
            padding: 1.5rem !important;
        }

        .col-md-6:nth-child(2) {
            padding-left: 0;
            margin-top: 2rem;
        }

        .list-group-item {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .btn-outline-info {
            align-self: flex-start;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem 1.25rem !important;
        }

        .card-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem;
            padding: 1.25rem !important;
        }

        .btn-outline-secondary {
            align-self: flex-start;
        }

        .card-header h5 {
            font-size: 1.4rem !important;
        }

        dl.row {
            padding: 1.25rem !important;
        }

        dt.col-sm-4, dd.col-sm-8 {
            padding: 0.5rem 0.75rem !important;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .card-header h5 {
            font-size: 1.2rem !important;
        }

        h6.mt-4 {
            font-size: 1.1rem !important;
        }

        .list-group-item h6 {
            font-size: 0.95rem;
        }

        .btn-primary {
            padding: 0.875rem 1.5rem !important;
            font-size: 0.95rem !important;
        }
    }
</style>

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">👤 {{ $sponsor->sponsor_name }}</h5>
            <a href="{{ route('admin.sponsors.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Sponsors
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Sponsor Name</dt>
                        <dd class="col-sm-8">{{ $sponsor->sponsor_name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">
                            <a href="mailto:{{ $sponsor->email }}" class="text-decoration-none">
                                {{ $sponsor->email }}
                            </a>
                        </dd>

                        <dt class="col-sm-4">Contact Number</dt>
                        <dd class="col-sm-8">
                            @if($sponsor->contact_number)
                                <a href="tel:{{ $sponsor->contact_number }}" class="text-decoration-none">
                                    {{ $sponsor->contact_number }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Username</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-light text-dark border border-secondary p-2">
                                {{ $sponsor->username }}
                            </span>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">📝 Notes</h6>
                    <div class="notes-container">
                        <p class="{{ !$sponsor->notes ? 'text-muted fst-italic' : '' }}">
                            {{ $sponsor->notes ?? 'No notes provided.' }}
                        </p>
                    </div>
                </div>
            </div>

            <hr>

            <h6 class="mt-4">🏆 Associated Scholarships</h6>
            @if ($sponsor->scholarships->isNotEmpty())
                <div class="list-group">
                    @foreach ($sponsor->scholarships as $scholarship)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $scholarship->title }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-tag me-1"></i>
                                    Type: {{ ucwords(str_replace('_', ' ', $scholarship->type)) }}
                                </small>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info mt-3 d-flex align-items-center">
                    <i class="bi bi-info-circle me-2 fs-5"></i>
                    <div>This sponsor has not created any scholarships yet.</div>
                </div>
            @endif

            <div class="mt-4 d-flex gap-3">
                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i> Edit Sponsor
                </a>
                <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this sponsor? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i> Delete Sponsor
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to list items
    const listItems = document.querySelectorAll('.list-group-item');
    listItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        item.classList.add('animate__animated', 'animate__fadeInUp');
    });

    // Format phone numbers if present
    const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
    phoneLinks.forEach(link => {
        const phone = link.getAttribute('href').replace('tel:', '');
        link.innerHTML = formatPhoneNumber(phone);
    });

    function formatPhoneNumber(phoneNumber) {
        // Simple phone number formatting
        const cleaned = ('' + phoneNumber).replace(/\D/g, '');
        const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
        if (match) {
            return '(' + match[1] + ') ' + match[2] + '-' + match[3];
        }
        return phoneNumber;
    }
});
</script>
@endsection

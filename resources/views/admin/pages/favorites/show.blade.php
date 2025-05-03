@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card profile-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-primary">
                        <i class="fas fa-star me-2"></i>
                        {{ __('admin.Favorites_For') }}: {{ $company->name }}
                    </h4>
                    <a href="{{ route('admin.favorites.index', app()->getLocale()) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('admin.Back_To_List') }}
                    </a>
                </div>

                <div class="card-body">
                    @if($favorites->count() > 0)
                        <div class="row g-3">
                            @foreach($favorites as $surrogate)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm hover-card">
                                        @if($surrogate->images->isNotEmpty())
                                            <div class="position-relative image-container">
                                                <img src="{{ Storage::url($surrogate->images->first()->image_path) }}"
                                                     class="card-img-top profile-image"
                                                     alt="{{ $surrogate->name }}">
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    <span class="badge bg-primary rounded-pill px-3 py-2 age-badge">
                                                        {{ $surrogate->age }} {{ __('admin.Years') }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold text-primary mb-3 title-underline">
                                                {{ $surrogate->name }} {{ $surrogate->surname }}
                                            </h5>
                                            <div class="card-text">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="info-section mb-3">
                                                            <h6 class="section-title">
                                                                <i class="fas fa-user-circle me-2"></i>
                                                                {{ __('admin.Personal_Info') }}
                                                            </h6>
                                                            <div class="info-content">
                                                                <p class="info-item">
                                                                    <i class="fas fa-globe text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Nationality') }}:</strong> {{ $surrogate->nationality }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-heart text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Marital_Status') }}:</strong> {{ $surrogate->marital_status }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-user text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Race') }}:</strong> {{ $surrogate->race }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-section mb-3">
                                                            <h6 class="section-title">
                                                                <i class="fas fa-ruler-combined me-2"></i>
                                                                {{ __('admin.Physical_Info') }}
                                                            </h6>
                                                            <div class="info-content">
                                                                <p class="info-item">
                                                                    <i class="fas fa-ruler-vertical text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Height') }}:</strong> {{ $surrogate->height }} cm
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-weight text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Weight') }}:</strong> {{ $surrogate->weight }} kg
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-tint text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Blood_Type') }}:</strong> {{ $surrogate->blood_type }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="info-section mb-3">
                                                            <h6 class="section-title">
                                                                <i class="fas fa-palette me-2"></i>
                                                                {{ __('admin.Appearance') }}
                                                            </h6>
                                                            <div class="info-content">
                                                                <p class="info-item">
                                                                    <i class="fas fa-palette text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Hair_Color') }}:</strong> {{ $surrogate->hair_color }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-eye text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Eye_Color') }}:</strong> {{ $surrogate->eye_color }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-hand-sparkles text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Skin_Complexion') }}:</strong> {{ $surrogate->skin_complexion }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-section mb-3">
                                                            <h6 class="section-title">
                                                                <i class="fas fa-graduation-cap me-2"></i>
                                                                {{ __('admin.Education_Experience') }}
                                                            </h6>
                                                            <div class="info-content">
                                                                <p class="info-item">
                                                                    <i class="fas fa-graduation-cap text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Education') }}:</strong> {{ $surrogate->education }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-star text-primary me-2"></i>
                                                                    <strong>{{ __('admin.Donation_Experience') }}:</strong> {!! $surrogate->donation_experience !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <div class="d-flex justify-content-center">
                                {{ $favorites->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 empty-state">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('admin.No_Favorites_Found') }}</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Card Styles */
.profile-card {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
    border-radius: 1rem;
    overflow: hidden;
}

.profile-card .card-header {
    background-color: #fff;
    border-bottom: 2px solid #f0f0f0;
    padding: 1.5rem;
}

.profile-card .card-header h4 {
    font-size: 1.5rem;
    font-weight: 600;
}

/* Hover Card Styles */
.hover-card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.3s ease;
    border-radius: 0.75rem;
    overflow: hidden;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
}

/* Image Styles */
.image-container {
    overflow: hidden;
}

.profile-image {
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.hover-card:hover .profile-image {
    transform: scale(1.05);
}

.age-badge {
    font-size: 0.9rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Section Styles */
.info-section {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 0.75rem;
    height: 100%;
}

.section-title {
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.info-content {
    padding: 0.25rem 0;
}

.info-item {
    margin-bottom: 0.25rem;
    font-size: 0.85rem;
    color: #6c757d;
}

.info-item strong {
    color: #495057;
}

/* Title Styles */
.title-underline {
    position: relative;
    padding-bottom: 0.5rem;
    font-size: 1.1rem;
}

.title-underline::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: #007bff;
    border-radius: 2px;
}

/* Pagination Styles */
.pagination {
    margin: 0;
    padding: 1rem 0;
}

.pagination .page-item .page-link {
    color: #007bff;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    margin: 0 0.2rem;
    border-radius: 0.25rem;
    transition: all 0.3s ease;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.pagination .page-item .page-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #0056b3;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}

/* Empty State Styles */
.empty-state {
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 1rem;
}

.empty-state i {
    color: #dee2e6;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .profile-card .card-header {
        padding: 1rem;
    }

    .profile-card .card-header h4 {
        font-size: 1.25rem;
    }

    .info-section {
        margin-bottom: 0.5rem;
    }

    .profile-image {
        height: 180px;
    }
}

@media (max-width: 576px) {
    .col-md-4 {
        width: 100%;
    }
}
</style>
@endsection

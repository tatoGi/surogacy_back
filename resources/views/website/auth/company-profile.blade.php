@extends('website.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Favorites Section -->
            <div class="card profile-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-primary">
                        <i class="fas fa-star me-2"></i>
                        {{ __('website.Favorite_Surrogate_People') }}
                    </h4>
                </div>

                <div class="card-body">
                    @if(auth('company')->user()->favoriteSurrogatePeople->count() > 0)
                        <div class="row g-4">
                            @foreach(auth('company')->user()->favoriteSurrogatePeople as $person)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm hover-card">
                                        @if($person->images->isNotEmpty())
                                            <div class="position-relative image-container">
                                                <img src="{{ Storage::url($person->images->first()->image_path) }}"
                                                     class="card-img-top profile-image"
                                                     alt="{{ $person->title }}">
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    <span class="badge bg-primary rounded-pill px-3 py-2 age-badge">
                                                        {{ $person->age }} {{ __('website.Years') }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold text-primary mb-3 title-underline">{{ $person->title }}</h5>
                                            <div class="card-text">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="info-section mb-3">
                                                            <h6 class="section-title">
                                                                <i class="fas fa-user-circle me-2"></i>
                                                                {{ __('website.Personal_Info') }}
                                                            </h6>
                                                            <div class="info-content">
                                                                <p class="info-item">
                                                                    <i class="fas fa-user text-primary me-2"></i>
                                                                    <strong>{{ __('website.Name') }}:</strong> {{ $person->name }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-user text-primary me-2"></i>
                                                                    <strong>{{ __('website.Surname') }}:</strong> {{ $person->surname }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-heart text-primary me-2"></i>
                                                                    <strong>{{ __('website.Marital_Status') }}:</strong> {{ $person->marital_status }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-section mb-3">
                                                            <h6 class="section-title">
                                                                <i class="fas fa-ruler-combined me-2"></i>
                                                                {{ __('website.Physical_Info') }}
                                                            </h6>
                                                            <div class="info-content">
                                                                <p class="info-item">
                                                                    <i class="fas fa-ruler-vertical text-primary me-2"></i>
                                                                    <strong>{{ __('website.Height') }}:</strong> {{ $person->height }} cm
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-weight text-primary me-2"></i>
                                                                    <strong>{{ __('website.Weight') }}:</strong> {{ $person->weight }} kg
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-tint text-primary me-2"></i>
                                                                    <strong>{{ __('website.Blood_Type') }}:</strong> {{ $person->blood_type }}
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
                                                                {{ __('website.Appearance') }}
                                                            </h6>
                                                            <div class="info-content">
                                                                <p class="info-item">
                                                                    <i class="fas fa-globe text-primary me-2"></i>
                                                                    <strong>{{ __('website.Nationality') }}:</strong> {{ $person->nationality }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-user text-primary me-2"></i>
                                                                    <strong>{{ __('website.Race') }}:</strong> {{ $person->race }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-palette text-primary me-2"></i>
                                                                    <strong>{{ __('website.Hair_Color') }}:</strong> {{ $person->hair_color }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-eye text-primary me-2"></i>
                                                                    <strong>{{ __('website.Eye_Color') }}:</strong> {{ $person->eye_color }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-hand-sparkles text-primary me-2"></i>
                                                                    <strong>{{ __('website.Skin_Complexion') }}:</strong> {{ $person->skin_complexion }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-section mb-3">
                                                            <h6 class="section-title">
                                                                <i class="fas fa-graduation-cap me-2"></i>
                                                                {{ __('website.Education_Experience') }}
                                                            </h6>
                                                            <div class="info-content">
                                                                <p class="info-item">
                                                                    <i class="fas fa-graduation-cap text-primary me-2"></i>
                                                                    <strong>{{ __('website.Education') }}:</strong> {{ $person->education }}
                                                                </p>
                                                                <p class="info-item">
                                                                    <i class="fas fa-star text-primary me-2"></i>
                                                                    <strong>{{ __('website.Donation_Experience') }}:</strong> {!! $person->donation_experience !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0 p-3">
                                            <div class="d-grid">
                                                <a href="/{{ $person->getFullSlug() }}" class="btn btn-primary btn-view-details">
                                                    {{ __('website.View_Details') }}
                                                    <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 empty-state">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('website.No_favorites_yet') }}</h5>
                            <p class="text-muted">{{ __('website.Start_adding_favorites') }}</p>
                            <a href="/{{ app()->getLocale() }}/surrogate-people" class="btn btn-primary mt-3 btn-browse">
                                {{ __('website.Browse_Surrogate_People') }}
                            </a>
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
    height: 300px;
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
    padding: 1rem;
    height: 100%;
}

.section-title {
    color: #495057;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.info-content {
    padding: 0.5rem 0;
}

.info-item {
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
    color: #6c757d;
}

.info-item strong {
    color: #495057;
}

/* Title Styles */
.title-underline {
    position: relative;
    padding-bottom: 0.5rem;
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

/* Button Styles */
.btn-view-details {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-view-details:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
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

.btn-browse {
    padding: 0.75rem 2rem;
    font-weight: 500;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-browse:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
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
        margin-bottom: 1rem;
    }

    .profile-image {
        height: 250px;
    }
}
</style>
@endsection

@extends('website.master')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
@endsection

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="row g-0">
                    <div class="col-md-5">
                        @if($model->images->isNotEmpty())
                            <div class="image-container">
                                <a href="{{ Storage::url($model->images->first()->image_path) }}" data-fancybox="gallery" data-caption="{{ $model->title }}">
                                    <img src="{{ Storage::url($model->images->first()->image_path) }}" class="img-fluid main-img" alt="{{ $model->title }}">
                                </a>
                                @if($model->images->count() > 1)
                                    <div class="d-flex flex-wrap gap-2 p-2">
                                        @foreach($model->images->slice(1) as $image)
                                            <a href="{{ Storage::url($image->image_path) }}" data-fancybox="gallery" data-caption="{{ $model->title }}">
                                                <img src="{{ Storage::url($image->image_path) }}" class="img-thumbnail thumb-img" alt="{{ $model->title }}">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <div class="profile-header">{{ $model->title }}</div>
                            <div class="name-section mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <i class="fas fa-user text-primary me-2"></i>
                                            <strong>{{ __('website.first_name') }}:</strong> {{ $model->name }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <i class="fas fa-user text-primary me-2"></i>
                                            <strong>{{ __('website.surname') }}:</strong> {{ $model->surname }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info-section">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <i class="fas fa-birthday-cake text-primary me-2"></i>
                                            <strong>{{ __('website.Age') }}:</strong> {{ $model->age }} {{ __('website.Years') }}
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-ruler-vertical text-primary me-2"></i>
                                            <strong>{{ __('website.Height') }}:</strong> {{ $model->height }} cm
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-weight text-primary me-2"></i>
                                            <strong>{{ __('website.Weight') }}:</strong> {{ $model->weight }} kg
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-tint text-primary me-2"></i>
                                            <strong>{{ __('website.Blood_Type') }}:</strong> {{ $model->blood_type }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <i class="fas fa-globe text-primary me-2"></i>
                                            <strong>{{ __('website.Nationality') }}:</strong> {{ $model->nationality }}
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-user text-primary me-2"></i>
                                            <strong>{{ __('website.Race') }}:</strong> {{ $model->race }}
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-heart text-primary me-2"></i>
                                            <strong>{{ __('website.Marital_Status') }}:</strong> {{ $model->marital_status }}
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-graduation-cap text-primary me-2"></i>
                                            <strong>{{ __('website.Education') }}:</strong> {{ $model->education }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="info-item">
                                            <i class="fas fa-star text-primary me-2"></i>
                                            <strong>{{ __('website.Donation_Experience') }}:</strong> {!! $model->donation_experience !!}
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-palette text-primary me-2"></i>
                                            <strong>{{ __('website.Hair_Color') }}:</strong> {{ $model->hair_color }}
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-eye text-primary me-2"></i>
                                            <strong>{{ __('website.Eye_Color') }}:</strong> {{ $model->eye_color }}
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-user-circle text-primary me-2"></i>
                                            <strong>{{ __('website.Skin_Complexion') }}:</strong> {{ $model->skin_complexion }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    overflow: hidden;
    margin: 0 15px;
}
.image-container {
    height: 100%;
    display: flex;
    flex-direction: column;
}
.main-img {
    height: 400px;
    width: 100%;
    object-fit: cover;
    border-radius: 0.75rem 0.75rem 0 0;
    margin-bottom: 1rem;
    box-shadow: 0 2px 12px rgba(74,20,140,0.10);
    border: 3px solid #f3e8ff;
    transition: transform 0.3s ease;
}
.main-img:hover {
    transform: scale(1.02);
}
.thumb-img {
    height: 80px;
    width: 80px;
    object-fit: cover;
    border-radius: 0.5rem;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    border: 2px solid #e1bee7;
    transition: transform 0.2s, border-color 0.2s;
    cursor: pointer;
}
.thumb-img:hover {
    transform: scale(1.08);
    border-color: #7c43bd;
}
.profile-header {
    font-size: 2rem;
    font-weight: 700;
    color: #4a148c;
    margin-bottom: 1.5rem;
    letter-spacing: 1px;
}
.info-section {
    background: #f8f6fc;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-top: 1rem;
}
.info-item {
    margin-bottom: 1rem;
    font-size: 1.08rem;
    color: #333;
    display: flex;
    align-items: center;
}
.info-item i {
    min-width: 24px;
    font-size: 1.2rem;
    color: #7c43bd;
    margin-right: 0.7rem;
}
@media (max-width: 767px) {
    .main-img {
        height: 300px !important;
        border-radius: 0.75rem;
    }
    .profile-header {
        font-size: 1.5rem;
        margin-top: 1rem;
    }
    .info-section {
        padding: 1rem;
    }
    .card {
        margin: 0 10px;
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script>
$(document).ready(function() {
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            "zoom",
            "share",
            "slideShow",
            "fullScreen",
            "download",
            "thumbs",
            "close"
        ],
        loop: true,
        protect: true,
        animationEffect: "zoom-in-out",
        transitionEffect: "slide",
        thumbs: {
            autoStart: true
        }
    });
});
</script>
@endsection

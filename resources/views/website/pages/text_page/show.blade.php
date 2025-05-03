@extends('website.master')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Title -->
            <h1 class="display-4 fw-bold mb-4 text-primary">{{ $post->translate(app()->getLocale())->title }}</h1>

            <!-- Main Content Area -->
            <div class="row mb-5">
                <!-- Main Image -->
                <div class="col-lg-8">
                    @if(isset($post->files) && count($post->files) > 0)
                        <div class="main-slider mb-4">
                            @foreach($post->files as $file)
                                <div class="slide">
                                    <img src="{{ asset('uploads/img/thumb/' . $file->file) }}"
                                         class="img-fluid rounded shadow-lg"
                                         alt="{{ $post->translate(app()->getlocale())->title }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="col-lg-4">
                    <div class="description-box p-4 bg-light rounded">
                        <p class="lead text-muted fst-italic">
                            {{ $post->translate(app()->getLocale())->desc }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Post Content -->
            <div class="post-content mb-5">
                {!! $post->translate(app()->getlocale())->content !!}
            </div>

            <!-- Thumbnail Gallery -->
            @if(isset($post->files) && count($post->files) > 1)
                <div class="thumbnail-slider mb-5">
                    @foreach($post->files as $file)
                        <div class="thumb">
                            <img src="{{ asset('uploads/img/thumb/' . $file->file) }}"
                                 class="img-fluid rounded"
                                 alt="{{ $post->translate(app()->getlocale())->title }}">
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Date and Share Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div class="text-muted">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                </div>
                <div class="d-flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                       class="btn btn-primary btn-lg"
                       target="_blank">
                        <i class="fab fa-facebook-f me-2"></i> Share on Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->translate(app()->getlocale())->title) }}"
                       class="btn btn-info btn-lg text-white"
                       target="_blank">
                        <i class="fab fa-twitter me-2"></i> Share on Twitter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Slick CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

<!-- Add Slick JS -->
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<style>
.post-content {
    line-height: 1.8;
    font-size: 1.1rem;
    color: #2c3e50;
}

.main-slider {
    margin-bottom: 20px;
}

.main-slider .slide {
    margin: 0 10px;
}

.main-slider .slide img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.thumbnail-slider {
    margin: 0 -5px;
}

.thumbnail-slider .thumb {
    margin: 0 5px;
    cursor: pointer;
}

.thumbnail-slider .thumb img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

.thumbnail-slider .thumb.slick-current img {
    opacity: 1;
}

.description-box {
    height: 100%;
    border-left: 4px solid #3498db;
}

.post-content img {
    max-width: 100%;
    height: auto;
    margin: 1.5rem 0;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.post-content p {
    margin-bottom: 1.5rem;
}

.post-content h2,
.post-content h3,
.post-content h4 {
    color: #2c3e50;
    margin: 2rem 0 1rem;
}

.post-content blockquote {
    border-left: 4px solid #3498db;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #7f8c8d;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.text-primary {
    color: #3498db !important;
}

.shadow-lg {
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.shadow-sm {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
}

/* Slick Navigation Arrows */
.slick-prev,
.slick-next {
    z-index: 1;
    width: 40px;
    height: 40px;
}

.slick-prev {
    left: 10px;
}

.slick-next {
    right: 10px;
}

.slick-prev:before,
.slick-next:before {
    font-size: 40px;
    color: #3498db;
}
</style>

<script>
$(document).ready(function(){
    $('.main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: '.thumbnail-slider'
    });

    $('.thumbnail-slider').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.main-slider',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
    });
});
</script>
@endsection

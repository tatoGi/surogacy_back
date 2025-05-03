@extends('website.master')
@section('content')
<div class="container py-5">
    <div class="row">

        @foreach($posts as $post)
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm hover-card">

                    @if(isset($post->files) && count($post->files) > 0)
                        <div class="card-img-wrapper">
                            <img src="{{ asset('uploads/img/thumb/' . $post->files[0]->file) }}"
                                 class="card-img-top"
                                 alt="{{ $post->translate(app()->getlocale())->title }}">
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex align-items-center text-muted mb-3">
                            <small>
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ $post->created_at->format('M d, Y') }}
                            </small>
                        </div>
                        <h3 class="card-title h4 mb-3">
                            <a href="/{{ $post->getfullslug() }}" class="text-decoration-none text-primary">
                                {{ $post->translate(app()->getlocale())->title }}
                            </a>
                        </h3>
                        <p class="card-text text-muted mb-4">
                            {{ $post->translate(app()->getlocale())->desc }}
                        </p>
                        <a href="/{{ $post->getfullslug() }}" class="btn btn-outline-primary">
                            Read More <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $posts->links() }}
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.card-img-wrapper {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.card-img-top {
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.hover-card:hover .card-img-top {
    transform: scale(1.05);
}

.card-body {
    padding: 1.5rem;
}

.card-title a {
    color: #2c3e50;
    transition: color 0.3s ease;
}

.card-title a:hover {
    color: #3498db;
}

.btn {
    transition: all 0.3s ease;
    border-radius: 8px;
    padding: 0.5rem 1.5rem;
}

.btn:hover {
    transform: translateX(5px);
}

.text-primary {
    color: #3498db !important;
}

/* Pagination Styling */
.pagination {
    margin-top: 2rem;
}

.pagination .page-item .page-link {
    color: #3498db;
    border: none;
    margin: 0 5px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.pagination .page-item.active .page-link {
    background-color: #3498db;
    color: white;
}

.pagination .page-item .page-link:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
}
</style>
@endsection

@extends('website.master')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Search Results</h1>

            <!-- Search Form -->
            <div class="search-form-container mb-5">
                <form action="{{ route('search') }}" method="GET" class="search-form">
                    <input type="text" name="que" class="form-control" placeholder="Search..." value="{{ $searchText ?? '' }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Search Results -->
            @if(isset($posts) && count($posts) > 0)
                <div class="search-results">
                    <h2 class="h4 mb-4">Found {{ count($posts) }} results for "{{ $searchText }}"</h2>

                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <h3 class="card-title h5">
                                            <a href="{{ $post['slug'] }}" class="text-decoration-none text-dark">
                                                {{ $post['title'] }}
                                            </a>
                                        </h3>
                                        <p class="card-text text-muted">
                                            {{ $post['desc'] }}
                                        </p>
                                        <a href="{{ $post['slug'] }}" class="btn btn-outline-primary btn-sm">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <h2 class="h4 mb-3">No results found</h2>
                    <p class="text-muted">Try different keywords or check your spelling.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.search-form-container {
    max-width: 600px;
    margin: 0 auto;
}

.search-form {
    display: flex;
    gap: 10px;
}

.search-form .form-control {
    border-radius: 25px;
    padding: 12px 20px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.search-form .form-control:focus {
    border-color: #E19393;
    box-shadow: 0 0 0 0.2rem rgba(225, 147, 147, 0.25);
}

.search-form .btn {
    border-radius: 25px;
    padding: 12px 25px;
    background-color: #E19393;
    border: none;
    transition: all 0.3s ease;
}

.search-form .btn:hover {
    background-color: #d97c7c;
    transform: translateY(-2px);
}

.card {
    transition: transform 0.3s ease;
    border: none;
    border-radius: 10px;
}

.card:hover {
    transform: translateY(-5px);
}

.card-title a:hover {
    color: #E19393 !important;
}

.btn-outline-primary {
    color: #E19393;
    border-color: #E19393;
}

.btn-outline-primary:hover {
    background-color: #E19393;
    border-color: #E19393;
    color: white;
}
</style>
@endsection

@extends('website.master')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">{{ __('website.Surrogate_People') }}</h1>
        <p class="lead text-muted">{{ __('website.Find_Your_Perfect_Match') }}</p>
    </div>

    <div class="row g-4">
        @foreach($surrogatePeople as $person)
            <div class="col-md-4">
                <div class="card h-100 shadow-lg border-0 rounded-3 hover-shadow transition">
                    @if($person->images->isNotEmpty())
                        <div class="position-relative">
                            <img src="{{ Storage::url($person->images->first()->image_path) }}"
                                 class="card-img-top rounded-top-3"
                                 alt="{{ $person->title }}"
                                 style="height: 350px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    {{ $person->age }} {{ __('website.Years') }}
                                </span>
                            </div>
                            @auth('company')
                                @if(isset($person) && $person->is_active)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <button class="btn btn-light rounded-circle favorite-btn" data-person-id="{{ $person->id }}">
                                            <i class="fas fa-star {{ $person->companies->contains(auth('company')->id()) ? 'text-warning' : 'text-muted' }}"></i>
                                        </button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endif
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-4 text-primary">{{ $person->title }}</h5>
                        <div class="card-text d-flex flex-column gap-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div class="info-content">
                                    <span class="text-muted small d-block">{{ __('website.Name') }}</span>
                                    <span class="fw-medium">{{ $person->name }} {{ $person->surname }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper me-3">
                                    <i class="fas fa-globe text-primary"></i>
                                </div>
                                <div class="info-content">
                                    <span class="text-muted small d-block">{{ __('website.Nationality') }}</span>
                                    <span class="fw-medium">{{ $person->nationality }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper me-3">
                                    <i class="fas fa-heart text-primary"></i>
                                </div>
                                <div class="info-content">
                                    <span class="text-muted small d-block">{{ __('website.Marital_Status') }}</span>
                                    <span class="fw-medium">{{ $person->marital_status }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper me-3">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div class="info-content">
                                    <span class="text-muted small d-block">{{ __('website.Race') }}</span>
                                    <span class="fw-medium">{{ $person->race }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper me-3">
                                    <i class="fas fa-star text-primary"></i>
                                </div>
                                <div class="info-content">
                                    <span class="text-muted small d-block">{{ __('website.Donation_Experience') }}</span>
                                    <span class="fw-medium">{!! $person->donation_experience !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 p-4">
                        <a href="/{{ $person->getFullSlug() }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">
                            {{ __('website.View_Details') }}
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($surrogatePeople->isEmpty())
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">{{ __('website.No_Surrogate_People_Found') }}</h3>
                <p class="text-muted">{{ __('website.Try_Adjusting_Your_Search') }}</p>
            </div>
        </div>
    @endif

    <div class="d-flex justify-content-center mt-5">
        {{ $surrogatePeople->links('website.components.pagination') }}
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.transition {
    transition: all 0.3s ease;
}
.empty-state {
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 1rem;
}
.favorite-btn {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.favorite-btn:hover {
    transform: scale(1.1);
}
.icon-wrapper {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(var(--bs-primary-rgb), 0.1);
    border-radius: 8px;
}
.info-content {
    flex: 1;
}
.card {
    border: none;
    background: #fff;
}
.card-body {
    padding: 1.5rem;
}
</style>

@auth('company')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const favoriteButtons = document.querySelectorAll('.favorite-btn');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const personId = this.dataset.personId;
            const icon = this.querySelector('i');
            const button = this;

            // Disable button while processing
            button.disabled = true;

            // Get current locale from the URL
            const url = `/{{ app()->getLocale() }}/surrogate-people/${personId}/toggle-favorite`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(async response => {
                const text = await response.text();
                console.log('Response status:', response.status);
                console.log('Response headers:', Object.fromEntries(response.headers.entries()));
                console.log('Response text:', text);

                if (!response.ok) {
                    if (response.status === 401) {
                        throw new Error('Please log in to add favorites');
                    } else if (response.status === 419) {
                        throw new Error('Session expired. Please refresh the page and try again.');
                    } else {
                        throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                    }
                }

                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                    throw new Error(`Invalid JSON response: ${text}`);
                }
            })
            .then(data => {
                console.log('Success data:', data);
                if (data.is_favorite) {
                    icon.classList.remove('text-muted');
                    icon.classList.add('text-warning');
                } else {
                    icon.classList.remove('text-warning');
                    icon.classList.add('text-muted');
                }
            })
            .catch(error => {
                console.error('Full error details:', error);
                console.error('Error stack:', error.stack);
                alert(`Error: ${error.message}\n\nCheck browser console for more details.`);
            })
            .finally(() => {
                // Re-enable button after processing
                button.disabled = false;
            });
        });
    });
});
</script>
@endauth
@endsection

@extends('website.master')
@section('content')

 <section class="contact-hero">
    <div class="container text-center">
        <h1>{{ __('admin.contact_button') }}</h1>
        <p class="lead">{{ __('admin.contact Us Text') }}</p>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('message'))
                <div class="alert alert-success alert-dismissible fade show text-center mb-4" role="alert" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 1rem; border-radius: 0.25rem; position: relative;">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);"></button>
                </div>
                @endif
                <div class="contact-form-wrapper">
                    <form id="contactForm" class="contact-form">
                        @csrf
                        <div class="mb-4">
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('admin.First_Name') }}" required>
                        </div>
                        <div class="mb-4">
                            <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('admin.Email') }}" required>
                        </div>
                        <div class="mb-4">
                            <select class="form-control" name="inquiry_type" id="inquiryType" required>
                                <option value="">{{ __('admin.Select') }}</option>
                                <option value="surrogate">{{ __('admin.Become_a_Surrogate') }}</option>
                                <option value="parent">{{ __('admin.Become_an_Intended_Parent') }}</option>
                                <option value="donor">{{ __('admin.donor') }}</option>
                                <option value="other">{{ __('admin.other') }}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <textarea class="form-control" name="message" id="message" rows="5" placeholder="{{ __('admin.Type-your-message') }}" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">{{ __('admin.Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: '/' + '{{ app()->getLocale() }}' + '/submission',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    const toastMagic = new ToastMagic();
                    toastMagic.success('Success', response.message);
                    $('#contactForm')[0].reset();
                } else {
                    let errorMessage = '';
                    if (response.errors) {
                        Object.keys(response.errors).forEach(key => {
                            errorMessage += response.errors[key].join('\n') + '\n';
                        });
                    } else if (response.message) {
                        errorMessage = response.message;
                    } else {
                        errorMessage = 'An unknown error occurred';
                    }
                    const toastMagic = new ToastMagic();
                    toastMagic.error('Error', errorMessage);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                let errorMessage = '';

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        Object.keys(xhr.responseJSON.errors).forEach(key => {
                            errorMessage += xhr.responseJSON.errors[key].join('\n') + '\n';
                        });
                    } else if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                } else if (xhr.status === 422) {
                    errorMessage = 'Validation failed. Please check your input.';
                } else if (xhr.status === 419) {
                    errorMessage = 'CSRF token mismatch. Please refresh the page and try again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again later.';
                } else {
                    errorMessage = 'An error occurred while submitting the form.';
                }

                const toastMagic = new ToastMagic();
                toastMagic.error('Error', errorMessage);
            }
        });
    });
});
</script>

<!-- Social Media Section -->
<section class="social-media-section py-5">
    <div class="container text-center">
        <h2>{{ __('admin.Footer_Social_Media') }}</h2>
        <p class="lead mb-4">{{ __('admin.Footer_Follow_on_Social_Media') }}</p>
        <div class="social-links">
            <a href="#" class="social-link facebook">
                <i class="fab fa-facebook-f"></i>
                <span>{{ __('admin.facebook') }}</span>
            </a>
            <a href="#" class="social-link instagram">
                <i class="fab fa-instagram"></i>
                <span>{{ __('admin.instagram') }}</span>
            </a>
            <a href="#" class="social-link tiktok">
                <i class="fab fa-tiktok"></i>
                <span>TikTok</span>
            </a>
        </div>
    </div>
</section>

@endsection

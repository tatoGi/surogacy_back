@extends('website.master')

@section('content')
    <!-- Banner Section -->
    @include('website.components.mainBanner')

    <!-- About Us Section -->
    <section class="about-us py-5 fade-in">
        <div class="container text-center">

            <h2 class="about-title mb-4">{{ $about_us->post->translate(app()->getLocale())->title }}</h2>
            <p class="about-description">
                {!! $about_us->post->translate(app()->getLocale())->text !!}
            </p>
            <div class="about-images d-flex justify-content-center flex-wrap gap-4 mt-4">
                @foreach($about_us->post->files as $file)
                    <a href="{{ asset('uploads/img/' . $file->file) }}" data-fancybox="about-gallery" data-caption="About Us Image">
                        <img src="{{ asset('uploads/img/' . $file->file) }}" alt="About Us Image" class="img-fluid rounded" style="width: 300px; height: 200px; object-fit: cover;">
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-info py-5 my-5 fade-in">
        <div class="container text-center">

            <h2 class="contact-title mb-4">{{ $contact_us->post->translate(app()->getLocale())->title }}</h2>
            <p class="contact-description">
                {!! $contact_us->post->translate(app()->getLocale())->desc !!}
            </p>
            <div class="row mt-4">
                <div class="col-md-4">
                    <i class="fas fa-phone-alt fa-2x mb-3 text-primary"></i>
                    <h5>{{ __('admin.Phone') }}</h5>
                    <p>{{ $contact_us->post->phone }}</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-envelope fa-2x mb-3 text-primary"></i>
                    <h5>{{ __('admin.Email') }}</h5>
                    <p>{{ $contact_us->post->email }}</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-map-marker-alt fa-2x mb-3 text-primary"></i>
                    <h5>{{ __('admin.Address') }}</h5>
                    <p>{{ $contact_us->post->address }}</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Surrogate Modal -->
    <div class="modal fade" id="surrogateModal" tabindex="-1" aria-labelledby="surrogateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="surrogateModalLabel">{{ __('admin.Become_a_Surrogate') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="surrogateForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surrogateFirstName" class="form-label">{{ __('admin.First_Name') }}</label>
                                <input type="text" class="form-control" id="surrogateFirstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surrogateLastName" class="form-label">{{ __('admin.Last_Name') }}</label>
                                <input type="text" class="form-control" id="surrogateLastName" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surrogateEmail" class="form-label">{{ __('admin.Email') }}</label>
                                <input type="email" class="form-control" id="surrogateEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surrogatePhone" class="form-label">{{ __('admin.Phone') }}</label>
                                <input type="tel" class="form-control" id="surrogatePhone" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surrogateAge" class="form-label">{{ __('admin.Age') }}</label>
                                <input type="number" class="form-control" id="surrogateAge" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surrogateLocation" class="form-label">{{ __('admin.Location') }}</label>
                                <input type="text" class="form-control" id="surrogateLocation" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="surrogateMessage" class="form-label">{{ __('admin.Tell_us_about_yourself') }}</label>
                            <textarea class="form-control" id="surrogateMessage" rows="4" required></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="surrogateAgreement" required>
                            <label class="form-check-label" for="surrogateAgreement">{{ __('admin.I_agree_to_the_terms_and_conditions') }}</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.Close') }}</button>
                    <button type="button" class="btn btn-danger" id="submitSurrogateForm">{{ __('admin.Submit') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Parent Modal -->
    <div class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="parentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="parentModalLabel">{{ __('admin.Become_an_Intended_Parent') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="parentForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="parentFirstName" class="form-label">{{ __('admin.First_Name') }}</label>
                                <input type="text" class="form-control" id="parentFirstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="parentLastName" class="form-label">{{ __('admin.Last_Name') }}</label>
                                <input type="text" class="form-control" id="parentLastName" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="parentEmail" class="form-label">{{ __('admin.Email') }}</label>
                                <input type="email" class="form-control" id="parentEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="parentPhone" class="form-label">{{ __('admin.Phone') }}</label>
                                <input type="tel" class="form-control" id="parentPhone" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="parentLocation" class="form-label">{{ __('admin.Location') }}</label>
                                <input type="text" class="form-control" id="parentLocation" required>
                            </div>
                            <div class="col-md-6">
                                <label for="parentType" class="form-label">{{ __('admin.Type_of_Parent') }}</label>
                                <select class="form-select" id="parentType" required>
                                    <option value="">{{ __('admin.Select') }}</option>
                                    <option value="single">{{ __('admin.Single_Parent') }}</option>
                                    <option value="couple">{{ __('admin.Couple') }}</option>
                                    <option value="lgbtq">{{ __('admin.LGBTQ') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="parentMessage" class="form-label">{{ __('admin.Tell_us_about_your_journey') }}</label>
                            <textarea class="form-control" id="parentMessage" rows="4" required></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="parentAgreement" required>
                            <label class="form-check-label" for="parentAgreement">{{ __('admin.I_agree_to_the_terms_and_conditions') }}</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.Close') }}</button>
                    <button type="button" class="btn btn-primary" id="submitParentForm">{{ __('admin.Submit') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Handle form submissions
            document.getElementById('submitSurrogateForm').addEventListener('click', function() {
                const form = document.getElementById('surrogateForm');
                if (form.checkValidity()) {
                    const formData = {
                        first_name: document.getElementById('surrogateFirstName').value,
                        last_name: document.getElementById('surrogateLastName').value,
                        email: document.getElementById('surrogateEmail').value,
                        phone: document.getElementById('surrogatePhone').value,
                        age: document.getElementById('surrogateAge').value,
                        location: document.getElementById('surrogateLocation').value,
                        message: document.getElementById('surrogateMessage').value,
                        terms_accepted: document.getElementById('surrogateAgreement').checked
                    };

                    $.ajax({
                        url: '/' + '{{ app()->getLocale() }}' + '/submit-surrogate-form',
                        method: 'POST',
                        data: JSON.stringify(formData),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                ToastMagic.success({
                                    title: 'Success',
                                    text: response.message,
                                    position: 'top-right',
                                    timer: 3000
                                });
                                bootstrap.Modal.getInstance(document.getElementById('surrogateModal')).hide();
                                form.reset();
                            } else {
                                let errorMessage = '';
                                if (response.errors) {
                                    // Handle validation errors
                                    Object.keys(response.errors).forEach(key => {
                                        errorMessage += response.errors[key].join('\n') + '\n';
                                    });
                                } else if (response.message) {
                                    errorMessage = response.message;
                                } else {
                                    errorMessage = 'An unknown error occurred';
                                }
                                ToastMagic.error({
                                    title: 'Error',
                                    text: errorMessage,
                                    position: 'top-right',
                                    timer: 5000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            let errorMessage = '';

                            if (xhr.responseJSON) {
                                if (xhr.responseJSON.errors) {
                                    // Handle validation errors
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

                            ToastMagic.error({
                                title: 'Error',
                                text: errorMessage,
                                position: 'top-right',
                                timer: 5000
                            });
                        }
                    });
                } else {
                    form.reportValidity();
                }
            });

            document.getElementById('submitParentForm').addEventListener('click', function() {
                const form = document.getElementById('parentForm');
                if (form.checkValidity()) {
                    const formData = {
                        first_name: document.getElementById('parentFirstName').value,
                        last_name: document.getElementById('parentLastName').value,
                        email: document.getElementById('parentEmail').value,
                        phone: document.getElementById('parentPhone').value,
                        location: document.getElementById('parentLocation').value,
                        parent_type: document.getElementById('parentType').value,
                        message: document.getElementById('parentMessage').value,
                        terms_accepted: document.getElementById('parentAgreement').checked
                    };

                    $.ajax({
                        url: '/' + '{{ app()->getLocale() }}' + '/submit-parent-form',
                        method: 'POST',
                        data: JSON.stringify(formData),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                ToastMagic.success({
                                    title: 'Success',
                                    text: response.message,
                                    position: 'top-right',
                                    timer: 3000
                                });
                                bootstrap.Modal.getInstance(document.getElementById('parentModal')).hide();
                                form.reset();
                            } else {
                                let errorMessage = '';
                                if (response.errors) {
                                    // Handle validation errors
                                    Object.keys(response.errors).forEach(key => {
                                        errorMessage += response.errors[key].join('\n') + '\n';
                                    });
                                } else if (response.message) {
                                    errorMessage = response.message;
                                } else {
                                    errorMessage = 'An unknown error occurred';
                                }
                                ToastMagic.error({
                                    title: 'Error',
                                    text: errorMessage,
                                    position: 'top-right',
                                    timer: 5000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            let errorMessage = '';

                            if (xhr.responseJSON) {
                                if (xhr.responseJSON.errors) {
                                    // Handle validation errors
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

                            ToastMagic.error({
                                title: 'Error',
                                text: errorMessage,
                                position: 'top-right',
                                timer: 5000
                            });
                        }
                    });
                } else {
                    form.reportValidity();
                }
            });

            // Function to check if element is in viewport
            function isInViewport(element) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.bottom >= 0
                );
            }

            // Function to handle fade elements
            function handleFadeElements() {
                const fadeElements = document.querySelectorAll(".fade-in, .slide-in-top, .slide-in-left, .slide-in-right");
                fadeElements.forEach((el, index) => {
                    if (isInViewport(el)) {
                        setTimeout(() => {
                            el.classList.add("visible");
                        }, index * 100); // Reduced delay for faster animation
                    }
                });
            }

            // Initial check
            handleFadeElements();

            // Check on scroll
            window.addEventListener('scroll', handleFadeElements);
        });
    </script>

@endsection
@section('scripts')
@parent
<script>
    $(document).ready(function () {
        // Any additional jQuery code can go here
    });
</script>
@endsection

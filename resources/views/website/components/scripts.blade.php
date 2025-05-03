<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
{!! ToastMagic::scripts() !!}
<script>
    // Set up CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // Initialize Fancybox
        $("[data-fancybox]").fancybox({
            buttons: [
                "zoom",
                "slideShow",
                "thumbs",
                "close"
            ],
            loop: true,
            transitionEffect: "circular",
            transitionDuration: 800,
            caption: function(instance, item) {
                return $(this).find('img').attr('alt');
            },
            afterLoad: function(instance, current) {
                current.$content.css({
                    'display': 'flex',
                    'align-items': 'center',
                    'justify-content': 'center',
                    'text-align': 'center'
                });
            }
        });

        // Handle form submissions
        const submitSurrogateForm = document.getElementById('submitSurrogateForm');
        if (submitSurrogateForm) {
            submitSurrogateForm.addEventListener('click', function() {
                const form = document.getElementById('surrogateForm');
                if (form && form.checkValidity()) {
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
                        success: function(response) {
                            if (response.success) {
                                const toastMagic = new ToastMagic();
                                toastMagic.success('Success', response.message);
                                const modal = document.getElementById('surrogateModal');
                                if (modal) {
                                    bootstrap.Modal.getInstance(modal).hide();
                                }
                                form.reset();
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
                } else if (form) {
                    form.reportValidity();
                }
            });
        }

        const submitParentForm = document.getElementById('submitParentForm');
        if (submitParentForm) {
            submitParentForm.addEventListener('click', function() {
                const form = document.getElementById('parentForm');
                if (form && form.checkValidity()) {
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
                        success: function(response) {
                            if (response.success) {
                                const toastMagic = new ToastMagic();
                                toastMagic.success('Success', response.message);
                                const modal = document.getElementById('parentModal');
                                if (modal) {
                                    bootstrap.Modal.getInstance(modal).hide();
                                }
                                form.reset();
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
                } else if (form) {
                    form.reportValidity();
                }
            });
        }

        // Function to check if element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.bottom >= 0
            );
        }

        // Function to handle fade-in elements
        function handleFadeElements() {
            const fadeElements = document.querySelectorAll(".fade-in");
            fadeElements.forEach((el) => {
                if (isInViewport(el)) {
                    el.style.opacity = "1";
                    el.style.visibility = "visible";
                    el.style.transform = "translateY(0)";
                }
            });
        }

        // Initial check
        handleFadeElements();

        // Check on scroll
        window.addEventListener('scroll', handleFadeElements);

        // Burger menu functionality
        const burgerMenu = document.querySelector('.burger-menu');
        const navigation = document.querySelector('.navigation');

        if (burgerMenu && navigation) {
            const overlay = document.createElement('div');
            overlay.className = 'overlay';
            document.body.appendChild(overlay);

            // Toggle menu
            burgerMenu.addEventListener('click', function() {
                if (window.innerWidth <= 991) {
                    this.classList.toggle('active');
                    navigation.classList.toggle('active');
                    overlay.classList.toggle('active');
                    document.body.style.overflow = navigation.classList.contains('active') ? 'hidden' : '';
                }
            });

            // Close menu when clicking overlay
            overlay.addEventListener('click', function() {
                if (window.innerWidth <= 991) {
                    burgerMenu.classList.remove('active');
                    navigation.classList.remove('active');
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Handle submenu toggles
            const menuItemsWithChildren = document.querySelectorAll('.menu-item-has-children > a');
            menuItemsWithChildren.forEach(item => {
                item.addEventListener('click', function(e) {
                    if (window.innerWidth <= 991) {
                        e.preventDefault();
                        const parent = this.parentElement;
                        const subMenu = parent.querySelector('.sub-menu');

                        if (parent && subMenu) {
                            parent.classList.toggle('active');
                            subMenu.classList.toggle('active');
                        }
                    }
                });
            });

            // Close menu when clicking a link
            const navLinks = document.querySelectorAll('.navigation .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 991) {
                        burgerMenu.classList.remove('active');
                        navigation.classList.remove('active');
                        overlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    burgerMenu.classList.remove('active');
                    navigation.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }
    });
</script>

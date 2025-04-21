@extends('website.master')

@section('main')
    <!-- Banner Section -->
    <section class="banner fade-in">
        <div class="container text-center">
            <h1 class="banner-title">Helping families, one blessing at a time.</h1>
            <div class="banner-images d-flex justify-content-center flex-wrap position-relative">
                <button class="btn btn-danger banner-left-button slide-in-left" data-bs-toggle="modal" data-bs-target="#surrogateModal">I WANT TO BECOME A SURROGATE</button>
                <div class="banner-image slide-in-top">
                    <a href="./assets/img/banner1.jpg" data-fancybox="banner-gallery" data-caption="Banner Image 1">
                        <img src="./assets/img/banner1.jpg" alt="Banner Image 1" class="img-fluid">
                    </a>
                </div>
                <div class="banner-image slide-in-top">
                    <a href="./assets/img/banner2.jpg" data-fancybox="banner-gallery" data-caption="Banner Image 2">
                        <img src="./assets/img/banner2.jpg" alt="Banner Image 2" class="img-fluid">
                    </a>
                </div>
                <div class="banner-image slide-in-top">
                    <a href="./assets/img/banner3.jpg" data-fancybox="banner-gallery" data-caption="Banner Image 3">
                        <img src="./assets/img/banner3.jpg" alt="Banner Image 3" class="img-fluid">
                    </a>
                </div>
                <div class="banner-image slide-in-top">
                    <a href="./assets/img/banner3.jpg" data-fancybox="banner-gallery" data-caption="Banner Image 3">
                        <img src="./assets/img/banner3.jpg" alt="Banner Image 3" class="img-fluid">
                    </a>
                </div>
                <div class="banner-image slide-in-top">
                    <a href="./assets/img/banner2.jpg" data-fancybox="banner-gallery" data-caption="Banner Image 2">
                        <img src="./assets/img/banner2.jpg" alt="Banner Image 2" class="img-fluid">
                    </a>
                </div>
                <div class="banner-image slide-in-top">
                    <a href="./assets/img/banner1.jpg" data-fancybox="banner-gallery" data-caption="Banner Image 1">
                        <img src="./assets/img/banner1.jpg" alt="Banner Image 1" class="img-fluid">
                    </a>
                </div>
                <button class="btn btn-primary banner-right-button slide-in-right" data-bs-toggle="modal" data-bs-target="#parentModal">I'M AN INTENDED PARENT</button>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-us py-5 fade-in">
        <div class="container text-center">
            <h2 class="about-title mb-4">About Us</h2>
            <p class="about-description">
                At SurrogateFirst, we are dedicated to helping families grow through the gift of surrogacy. 
                Our mission is to provide compassionate support and expert guidance to both surrogates and intended parents, 
                ensuring a smooth and fulfilling journey for everyone involved.
            </p>
            <div class="about-images d-flex justify-content-center flex-wrap gap-4 mt-4">
                <a href="./assets/img/banner1.jpg" data-fancybox="about-gallery" data-caption="About Us Image 1">
                    <img src="./assets/img/banner1.jpg" alt="About Us Image 1" class="img-fluid rounded" style="width: 300px; height: 200px; object-fit: cover;">
                </a>
                <a href="./assets/img/banner2.jpg" data-fancybox="about-gallery" data-caption="About Us Image 2">
                    <img src="./assets/img/banner2.jpg" alt="About Us Image 2" class="img-fluid rounded" style="width: 300px; height: 200px; object-fit: cover;">
                </a>
                <a href="./assets/img/banner3.jpg" data-fancybox="about-gallery" data-caption="About Us Image 3">
                    <img src="./assets/img/banner3.jpg" alt="About Us Image 3" class="img-fluid rounded" style="width: 300px; height: 200px; object-fit: cover;">
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-info py-5 my-5 fade-in">
        <div class="container text-center">
            <h2 class="contact-title mb-4">Contact Us</h2>
            <p class="contact-description">
                Have questions or need assistance? We're here to help. Reach out to us through any of the following methods:
            </p>
            <div class="row mt-4">
                <div class="col-md-4">
                    <i class="fas fa-phone-alt fa-2x mb-3 text-primary"></i>
                    <h5>Phone</h5>
                    <p>+1 (123) 456-7890</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-envelope fa-2x mb-3 text-primary"></i>
                    <h5>Email</h5>
                    <p>info@surrogatefirst.com</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-map-marker-alt fa-2x mb-3 text-primary"></i>
                    <h5>Address</h5>
                    <p>123 Surrogacy Lane, Family City, USA</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="./assets/img/logo.jpg" alt="Surrogate First Logo" class="img-fluid" style="height: 80px;">
                    <p class="footer-tagline">Helping families one blessing at a time.</p>
                </div>
                <div class="col-md-3">
                    <h5>For Surrogates</h5>
                    <ul class="footer-links">
                        <li><a href="#">How to become a surrogate?</a></li>
                        <li><a href="#">Do I qualify?</a></li>
                        <li><a href="#">How will I be compensated?</a></li>
                        <li><a href="#">SF Wellness Program</a></li>
                        <li><a href="#">SF Postpartum Program</a></li>
                        <li><a href="#">Why SurrogateFirst?</a></li>
                        <li><a href="#">The Surrogates' Academy – FAQ</a></li>
                        <li><a href="#">Repeat Surrogates</a></li>
                        <li><a href="#">Start Your Application Now</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>For Intended Parents</h5>
                    <ul class="footer-links">
                        <li><a href="#">What's the process of surrogacy?</a></li>
                        <li><a href="#">Why work with SurrogateFirst?</a></li>
                        <li><a href="#">How much does surrogacy cost?</a></li>
                        <li><a href="#">The Parents' Academy – FAQ</a></li>
                        <li><a href="#">Start the process</a></li>
                    </ul>
                    <h5>About Us</h5>
                    <ul class="footer-links">
                        <li><a href="#">More about us</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Learning Center</h5>
                    <ul class="footer-links">
                        <li><a href="#">Press Articles</a></li>
                        <li><a href="#">Surrogacy Reports</a></li>
                        <li><a href="#">Surrogacy Blogs</a></li>
                        <li><a href="#">Webinars</a></li>
                        <li><a href="#">Podcasts</a></li>
                        <li><a href="#">Live Events</a></li>
                    </ul>
                    <h5>Get in touch</h5>
                    <ul class="footer-links">
                        <li><a href="#">Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center mt-4">
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>
                <p class="mt-3"> All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Surrogate Modal -->
    <div class="modal fade" id="surrogateModal" tabindex="-1" aria-labelledby="surrogateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="surrogateModalLabel">Become a Surrogate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="surrogateForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surrogateFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="surrogateFirstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surrogateLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="surrogateLastName" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surrogateEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="surrogateEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surrogatePhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="surrogatePhone" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="surrogateAge" class="form-label">Age</label>
                                <input type="number" class="form-control" id="surrogateAge" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surrogateLocation" class="form-label">Location</label>
                                <input type="text" class="form-control" id="surrogateLocation" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="surrogateMessage" class="form-label">Tell us about yourself</label>
                            <textarea class="form-control" id="surrogateMessage" rows="4" required></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="surrogateAgreement" required>
                            <label class="form-check-label" for="surrogateAgreement">I agree to the terms and conditions</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="submitSurrogateForm">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Parent Modal -->
    <div class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="parentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="parentModalLabel">Become an Intended Parent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="parentForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="parentFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="parentFirstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="parentLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="parentLastName" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="parentEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="parentEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="parentPhone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="parentPhone" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="parentLocation" class="form-label">Location</label>
                                <input type="text" class="form-control" id="parentLocation" required>
                            </div>
                            <div class="col-md-6">
                                <label for="parentType" class="form-label">Type of Parent</label>
                                <select class="form-select" id="parentType" required>
                                    <option value="">Select...</option>
                                    <option value="single">Single Parent</option>
                                    <option value="couple">Couple</option>
                                    <option value="lgbtq">LGBTQ+</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="parentMessage" class="form-label">Tell us about your journey</label>
                            <textarea class="form-control" id="parentMessage" rows="4" required></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="parentAgreement" required>
                            <label class="form-check-label" for="parentAgreement">I agree to the terms and conditions</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitParentForm">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Fancybox
        Fancybox.bind("[data-fancybox]", {
            // Custom options
            Thumbs: {
                type: "classic",
            },
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                        "flipX",
                        "flipY",
                    ],
                    right: ["slideshow", "thumbs", "close"],
                },
            },
            Images: {
                zoom: true,
            },
            Carousel: {
                transition: "slide",
            },
        });

        // Handle form submissions
        document.getElementById('submitSurrogateForm').addEventListener('click', function() {
            const form = document.getElementById('surrogateForm');
            if (form.checkValidity()) {
                // Here you would typically send the form data to your server
                alert('Thank you for your interest in becoming a surrogate! We will contact you soon.');
                bootstrap.Modal.getInstance(document.getElementById('surrogateModal')).hide();
            } else {
                form.reportValidity();
            }
        });

        document.getElementById('submitParentForm').addEventListener('click', function() {
            const form = document.getElementById('parentForm');
            if (form.checkValidity()) {
                // Here you would typically send the form data to your server
                alert('Thank you for your interest in becoming an intended parent! We will contact you soon.');
                bootstrap.Modal.getInstance(document.getElementById('parentModal')).hide();
            } else {
                form.reportValidity();
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            const fadeElements = document.querySelectorAll(".fade-in, .slide-in-top, .slide-in-left, .slide-in-right");
            fadeElements.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add("visible");
                }, index * 200); // Staggered effect
            });
        });
    </script>

@endsection
@section('scripts')
@parent
<script>
    < script >
        $(document).ready(function () {
            $("[data-fancybox^='gallery']").fancybox({
                loop: true,
                buttons: [
                    "zoom",
                    "slideShow",
                    "thumbs",
                    "close"
                ],
                transitionEffect: "circular",
                transitionDuration: 800,
                caption: function (instance, item) {
                    return $(this).find('img').attr('alt');
                },
                afterLoad: function (instance, current) {
                    current.$content.css({
                        'display': 'flex',
                        'align-items': 'center',
                        'justify-content': 'center',
                        'text-align': 'center'
                    });
                }
            });
        });

</script>

</script>
@endsection

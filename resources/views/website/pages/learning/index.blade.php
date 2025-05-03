@extends('website.master')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Surrogacy Learning Center</h1>

            <!-- Introduction Section -->
            <div class="intro-section mb-5">
                <h2 class="h3 mb-4">Welcome to Your Surrogacy Journey</h2>
                <p class="lead">Whether you're considering becoming a surrogate or an intended parent, our comprehensive learning center provides all the information you need to make informed decisions about your surrogacy journey.</p>
            </div>

            <!-- Main Content Grid -->
            <div class="row g-4">
                <!-- For Intended Parents -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title h4 mb-4">For Intended Parents</h3>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <h4 class="h5">Understanding Surrogacy</h4>
                                    <p>Learn about different types of surrogacy and what's right for you</p>
                                </li>
                                <li class="mb-3">
                                    <h4 class="h5">Legal Considerations</h4>
                                    <p>Important legal aspects and requirements</p>
                                </li>
                                <li class="mb-3">
                                    <h4 class="h5">Financial Planning</h4>
                                    <p>Understanding costs and financial aspects</p>
                                </li>
                                <li>
                                    <h4 class="h5">Medical Process</h4>
                                    <p>Overview of the medical journey</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- For Surrogates -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title h4 mb-4">For Surrogates</h3>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <h4 class="h5">Becoming a Surrogate</h4>
                                    <p>Requirements and qualifications</p>
                                </li>
                                <li class="mb-3">
                                    <h4 class="h5">Health & Wellness</h4>
                                    <p>Medical requirements and care</p>
                                </li>
                                <li class="mb-3">
                                    <h4 class="h5">Support & Resources</h4>
                                    <p>Available support systems and resources</p>
                                </li>
                                <li>
                                    <h4 class="h5">Compensation</h4>
                                    <p>Understanding compensation and benefits</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Additional Resources -->
                <div class="col-12 mt-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title h4 mb-4">Additional Resources</h3>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="resource-item">
                                        <h5>FAQs</h5>
                                        <p>Common questions and answers</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="resource-item">
                                        <h5>Success Stories</h5>
                                        <p>Real experiences from our community</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="resource-item">
                                        <h5>Support Groups</h5>
                                        <p>Connect with others on similar journeys</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-5">
                <h3 class="h4 mb-4">Ready to Start Your Journey?</h3>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-primary">Contact Us</a>
                    <a href="#" class="btn btn-outline-primary">Schedule Consultation</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s;
    border: none;
    border-radius: 10px;
}

.card:hover {
    transform: translateY(-5px);
}

.resource-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    height: 100%;
}

.btn {
    padding: 10px 25px;
    border-radius: 25px;
}
</style>
@endsection

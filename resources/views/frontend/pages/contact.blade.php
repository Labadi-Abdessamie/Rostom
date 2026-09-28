@extends('frontend.master')

@section('title')
    {{ $website->name }} || Contact Us
@endsection

@section('content')
    <!-- Breadcrumb -->
    <section id="wsus__breadcrumb" class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="text-white fw-bold mb-1">Contact Us</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}" class="text-white-50">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="wsus__contact" class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);">
        <div class="container">
            <div class="row g-5">
                <!-- Info Cards -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f0f4ff);">
                        <div class="card-body p-5">
                            <h3 class="fw-bold mb-4" style="color: #1e293b;">Get in Touch</h3>

                            <div class="d-flex align-items-start mb-4">
                                <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 56px; height: 56px; background: linear-gradient(135deg, #6366f1, #4f46e5);">
                                    <i class="fal fa-envelope text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1" style="color: #334155;">Email</h6>
                                    <a href="mailto:support@tiarshop.com" class="text-decoration-none fw-medium" style="color: #6366f1;">support@tiarshop.com</a>
                                    <p class="text-muted small mb-0">We reply within 24 hours</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start mb-4">
                                <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981, #059669);">
                                    <i class="fas fa-phone text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1" style="color: #334155;">Phone</h6>
                                    <a href="tel:+213559456837" class="text-decoration-none fw-medium" style="color: #10b981;">+213 559 45 68 37</a>
                                    <p class="text-muted small mb-0">Sun – Thu, 9am – 6pm</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 56px; height: 56px; background: linear-gradient(135deg, #f59e0b, #d97706);">
                                    <i class="fas fa-map-marker text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1" style="color: #334155;">Address</h6>
                                    <p class="mb-0" style="color: #475569;">Tiaret -- Algeria</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-xl rounded-4 overflow-hidden h-100">
                        <div class="p-5" style="background: linear-gradient(145deg, #ffffff, #f8fafc);">
                            <h3 class="fw-bold mb-1" style="color: #1e293b;">Send Us a Message</h3>
                            <p class="text-muted mb-4">We'll get back to you as soon as possible.</p>

                            <form action="{{ route('frontend.send_mail') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-semibold small text-muted">Your Name</label>
                                        <input name="name" type="text" id="name" class="form-control form-control-lg rounded-3 border-0 shadow-sm" placeholder="John Doe" required style="background: #f8fafc;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
                                        <input name="email" type="email" id="email" class="form-control form-control-lg rounded-3 border-0 shadow-sm" placeholder="john@example.com" required style="background: #f8fafc;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold small text-muted">Phone</label>
                                        <input name="phone" type="text" id="phone" class="form-control form-control-lg rounded-3 border-0 shadow-sm" placeholder="+213 559 45 68 37" required style="background: #f8fafc;">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label fw-semibold small text-muted">Subject</label>
                                        <input name="subject" type="text" id="subject" class="form-control form-control-lg rounded-3 border-0 shadow-sm" placeholder="How can we help?" required style="background: #f8fafc;">
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label fw-semibold small text-muted">Message</label>
                                        <textarea name="message" id="message" rows="5" class="form-control rounded-3 border-0 shadow-sm" placeholder="Tell us more..." required style="background: #f8fafc; resize: none;"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-lg rounded-pill px-5 fw-bold shadow-lg" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; border: none;">
                                            Send Message <i class="fal fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.empty')
@section('title')
    @lang('Authentication')
@endsection

@section('content')
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6 bg-primary d-flex justify-content-center align-content-center">
                                    <img class="img-fluid" src="{{ URL::asset('assets/images/auth/auth.jpeg') }}"
                                        alt="">
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <h5 class="text-primary">Forgot Password?</h5>
                                        <p class="text-muted">Reset password with Du Network</p>

                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif

                                        <div class="mt-2 text-center">
                                            <img src="{{ URL::asset('assets/images/logo/logo.png') }}" alt=""
                                                width="100px">
                                        </div>

                                        <div class="alert border-0 alert-warning text-center mt-2 mb-2 mx-2" role="alert">
                                            Enter your email and instructions will be sent to you!
                                        </div>
                                        @if ($errors->any())
                                            <!-- Error Alert -->
                                            <div class="alert alert-danger alert-border-left alert-dismissible fade show"
                                                role="alert">
                                                <i class="ri-notification-off-line me-3 align-middle"></i>
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }} <br>
                                                @endforeach
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (session('message'))
                                            <!-- Success Alert -->
                                            <div class="alert alert-success alert-border-left alert-dismissible fade show"
                                                role="alert">
                                                <i class="ri-notification-off-line me-3 align-middle"></i>
                                                {{ session('message') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if (session('error'))
                                            <!-- Error Alert -->
                                            <div class="alert alert-danger alert-border-left alert-dismissible fade show"
                                                role="alert">
                                                <i class="ri-notification-off-line me-3 align-middle"></i>
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <div class="p-2">
                                            <form method="POST" action="{{ route('password.reset') }}">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control bg-mu" id="email"
                                                        name="email" placeholder="Enter email address">

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Send Reset
                                                        Link</button>
                                                </div>
                                            </form><!-- end form -->
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Wait, I remember my password... <a
                                                    href="auth-signin-cover.html"
                                                    class="fw-semibold text-primary text-decoration-underline"> Click here
                                                </a> </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
    </div>
@endsection

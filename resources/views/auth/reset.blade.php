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

                                <div class="col-md-8 col-lg-6 col-xl-5">
                                    <div class="card mt-4">

                                        <div class="card-body p-4">
                                            <div class="text-center mt-2">
                                                <h5 class="text-primary">Forgot Password?</h5>
                                                <p class="text-muted">Reset password with Du Solutions</p>
                                            </div>

                                            <div class="mt-2 text-center">
                                                <img src="{{ URL::asset('assets/images/logo/logo.png') }}" alt=""
                                                    width="100px">
                                            </div>

                                            <div class="p-2">
                                                <form class="form-horizontal" method="POST" action="{{ route('password.update') }}">
                                                    @csrf
                                                    <input type="hidden" name="token" value="{{ $token }}">
                                                    <div class="mb-3">
                                                        <label for="useremail" class="form-label">Email</label>
                                                        <input type="email" class="form-control bg-mu @error('email') is-invalid @enderror" id="useremail" name="email" placeholder="Enter email" value="{{ $email ?? old('email') }}" id="email">
                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="userpassword">Password</label>
                                                        <input type="password" class="form-control bg-mu @error('password') is-invalid @enderror" name="password" id="userpassword" placeholder="Enter password">
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="userpassword">Confirm Password</label>
                                                        <input id="password-confirm" type="password" name="password_confirmation" class="form-control bg-mu" placeholder="Enter confirm password">
                                                    </div>

                                                    <div class="text-end">
                                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                                    </div>

                                                </form><!-- end form -->
                                            </div>
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->

                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Wait, I remember my password... <a href="auth-signin-basic"
                                                class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
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

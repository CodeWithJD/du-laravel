@extends('layouts.empty')
@section('title')
    @lang('Register')
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
                                        <div>
                                            <h5 class="text-primary">Register Account</h5>
                                            <p class="text-muted">Get your Du Network account now.</p>
                                        </div>
                                        {{-- error shoe here --}}
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="mt-4">
                                            <form class="needs-validation" method="POST" novalidate
                                                action="{{ route('register.post') }}">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Full Name</label>
                                                    <input type="text" class="form-control bg-body" id="name"
                                                        placeholder="Enter full name" name="name" required>
                                                    <div class="invalid-feedback">
                                                        Please enter name
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" class="form-control bg-body" id="useremail"
                                                        placeholder="Enter email address" name="email" required>
                                                    <div class="invalid-feedback">
                                                        Please enter email
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="mobile" class="form-label">Mobile Number</label>
                                                    <input type="text" class="form-control bg-body" id="mobile"
                                                        placeholder="Enter mobile number with +123" name="mobile_number"
                                                        pattern="^\+(?:[0-9] ?){6,14}[0-9]$" required>
                                                    <div class="invalid-feedback">
                                                        Please enter a valid mobile number starting with +
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="invite_code" class="form-label">Referral Code</label>
                                                    @if ($referralCode)
                                                        <input type="text" class="form-control bg-body"
                                                            id="invite_code" value="{{ $referralCode }}"
                                                            name="invite_code" disabled>
                                                    @else
                                                        <input type="text" class="form-control bg-body"
                                                            id="invite_code" placeholder="Enter referral code if you have"
                                                            name="invite_code">
                                                    @endif
                                                    <div class="invalid-feedback">
                                                        invalid referral code
                                                    </div>
                                                </div>


                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password"
                                                            class="form-control bg-body pe-5 password-input"
                                                            onpaste="return false" placeholder="Enter password"
                                                            id="password-input" aria-describedby="passwordInput"
                                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="password"
                                                            required>
                                                        <button
                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                            type="button" id="password-addon"><i
                                                                class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            Please enter password
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to
                                                        the Du Network <a href="#"
                                                            class="text-primary text-decoration-underline fst-normal fw-medium">Terms
                                                            of Use</a></p>
                                                </div>

                                                <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                    <h5 class="fs-13">Password must contain:</h5>
                                                    <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8
                                                            characters</b></p>
                                                    <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter
                                                        (a-z)</p>
                                                    <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b>
                                                        letter (A-Z)</p>
                                                    <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b>
                                                        (0-9)</p>
                                                </div>

                                                <div class="mt-4">
                                                    <button type="submit" class="btn btn-primary"
                                                        onclick="enableField()">Submit</button>
                                                </div>
                                                {{--
                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                                    </div>

                                                     <div>
                                                        <button type="button"
                                                            class="btn btn-primary btn-icon waves-effect waves-light"><i
                                                                class="ri-facebook-fill fs-16"></i></button>
                                                        <button type="button"
                                                            class="btn btn-danger btn-icon waves-effect waves-light"><i
                                                                class="ri-google-fill fs-16"></i></button>
                                                        <button type="button"
                                                            class="btn btn-dark btn-icon waves-effect waves-light"><i
                                                                class="ri-github-fill fs-16"></i></button>
                                                        <button type="button"
                                                            class="btn btn-info btn-icon waves-effect waves-light"><i
                                                                class="ri-twitter-fill fs-16"></i></button>
                                                    </div> --}}
                                        </div>
                                        </form>
                                    </div>

                                    <div class="my-3 text-center">
                                        <p class="mb-0">Already have an account ? <a href="{{ route('login') }}"
                                                class="fw-semibold text-primary text-decoration-underline"> Signin</a>
                                        </p>
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

@section('script')
    <script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
    <script src="{{ URL::asset('assets/js/password-create.js') }}"></script>
    <script>
        function enableField() {
            document.getElementById("invite_code").disabled = false;
        }
    </script>
@endsection

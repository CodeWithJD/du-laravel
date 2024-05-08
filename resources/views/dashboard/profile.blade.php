@extends('layouts.dashboard')
@section('title')
    @lang('Profile')
@endsection
@section('page')
    @lang('Personal Details')
@endsection

@section('content')
    <div class="container-fluid my-5">
        <div class="">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i> Password change
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Full Name</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-mu" value="{{ $user->name }}"
                                                    id="nameInput">
                                                <button class="btn btn-primary" type="button"
                                                    id="updateButton">Update</button>
                                            </div>
                                            <span id="updateMessage"></span>
                                            <div class="loader" style="display: none;">Updating...</div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">
                                                Mobile Number
                                                @if ($userDetails->mobile_verified == 1)
                                                    <span class="text-success fw-bold">Verified</span>
                                                @else
                                                    <span class="text-danger fw-bold">Not Verified</span>
                                                @endif
                                            </label>
                                            <input type="text" class="form-control" value=" {{ $user->phone }} "
                                                disabled>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label">Country</label>
                                            <input type="text" class="form-control" id="countryInput"
                                                placeholder="Country" value="Pakistan" disabled />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastnameInput" class="form-label">Invite Code</label>
                                            <input type="text" class="form-control" value="{{ $user->invite_code }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">
                                                Email Address
                                                @if ($userDetails->email_verified == 1)
                                                    <span class="text-success fw-bold">Verified</span>
                                                @else
                                                    <span class="text-danger fw-bold">Not Verified</span>
                                                @endif
                                            </label>
                                            <input type="email" class="form-control" placeholder="Enter your email"
                                                value=" {{ $user->email }}" disabled>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="JoiningdatInput" class="form-label">Joining Date</label>
                                            <input type="text" class="form-control" value=" {{ $user->created_at }} "
                                                disabled />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="upLine" class="form-label">Up Line</label>
                                            <input type="text" class="form-control" value=" {{ $referrerEmail }} "
                                                disabled />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="accountStatus" class="form-label">Account Status</label>
                                            <input type="text" class="form-control"
                                                value=" {{ $userDetails->account_status }} " disabled />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="upLine" class="form-label">Last login</label>
                                            <input type="text" class="form-control"
                                                value=" {{ $userDetails->last_login }} " disabled />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="upLine" class="form-label">Last login IP</label>
                                            <input type="text" class="form-control"
                                                value=" {{ $userDetails->last_login_ip }} " disabled />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-start">
                                            <button type="submit" class="btn btn-primary">Updates</button>
                                            <button type="button" class="btn btn-soft-success">Cancel</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <div class="alert alert-success alert-border-left alert-dismissible fade show" id="passwordUpdateMessage" role="alert" style="display: none;">
                                <i class="ri-notification-off-line me-3 align-middle"></i>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="oldPasswordInput" class="form-label">Old Password</label>
                                        <input type="password" id="oldPasswordInput" class="form-control bg-mu">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="newPasswordInput" class="form-label">New Password</label>
                                        <input type="password" id="newPasswordInput" class="form-control bg-mu">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="confirmPasswordInput" class="form-label">Confirm Password</label>
                                        <input type="password" id="confirmPasswordInput" class="form-control bg-mu">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" id="updatePasswordButton"
                                            class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
@endsection
@section('script-bottom')
    <script>
        $(document).ready(function() {
            $('#updateButton').click(function() {
                $(this).prop('disabled', true);
                $('.loader').show();
                var name = $('#nameInput').val();
                $.ajax({
                    url: '/profile/update-name',
                    method: 'POST',
                    data: {
                        name: name,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#updateMessage').text(response.message).removeClass('text-danger')
                            .addClass('text-success');
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Failed to update name.';
                        if (errors && errors.name) {
                            errorMessage = errors.name.join(" ");
                        }
                        $('#updateMessage').text(errorMessage).removeClass('text-success')
                            .addClass('text-danger');
                    },
                    complete: function() {
                        $('#updateButton').prop('disabled', false);
                        $('.loader').hide();
                    }
                });
            });
        });

        $(document).ready(function() {
    $('#updatePasswordButton').click(function() {
        var oldPassword = $('#oldPasswordInput').val();
        var newPassword = $('#newPasswordInput').val();
        var confirmPassword = $('#confirmPasswordInput').val();

        if (newPassword !== confirmPassword) {
            $('#passwordUpdateMessage').text('New password and confirm password do not match.')
                .removeClass('alert-success').addClass('alert-danger').show();
            return;
        }

        $.ajax({
            url: '/profile/update-password',
            type: 'POST',
            data: {
                old_password: oldPassword,
                new_password: newPassword,
                new_password_confirmation: confirmPassword,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#passwordUpdateMessage').text(response.message)
                    .removeClass('alert-danger').addClass('alert-success').show();
            },
            error: function(xhr) {
                $('#passwordUpdateMessage').text(xhr.responseJSON.message || 'Error updating password.')
                    .removeClass('alert-success').addClass('alert-danger').show();
            }
        });
    });
});
    </script>
@endsection

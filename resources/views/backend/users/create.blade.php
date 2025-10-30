@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Add User
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users')}}">Users</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">

                <form action="{{ route('users.store') }}" method="POST" id="createUserForm">
                    @csrf

                    <div class="card">
                        <div class="header">
                            <h2><strong>Create</strong> User</h2>
                        </div>

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" name="fname" class="form-control" pattern="[A-Za-z\s]+"  value="{{ old('fname') }}" placeholder="First Name" required>
                                        @error('fname') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" name="lname" class="form-control" pattern="[A-Za-z\s]+"  value="{{ old('lname') }}" placeholder="Last Name" required>
                                        @error('lname') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group position-relative">
                                        <label for="username">UserName</label>
                                        <input type="text" id="username" name="username" class="form-control" pattern="[A-Za-z\s]+"  value="{{ old('username') }}" placeholder="Enter Username" required>
                                        <small id="username-feedback" class="form-text"></small>
                                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group position-relative">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter Email" required>
                                        <small id="email-feedback" class="form-text"></small>
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="text-muted">Default password is 12345678</span>
                                        <input type="password" name="password" class="form-control" value="12345678" minlength="8" required>
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="text-muted">Confirm Password</span>
                                        <input type="password" name="confirm_password" class="form-control" value="12345678" minlength="8" required>
                                        @error('confirm_password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" id="submitBtn" class="btn btn-primary btn-round">Submit</button>
                                <a href="{{ route('users') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    const usernameField = $('#username');
    const emailField = $('#email');
    const submitBtn = $('#submitBtn');
    const usernameFeedback = $('#username-feedback');
    const emailFeedback = $('#email-feedback');

    let usernameValid = true;
    let emailValid = true;

    // Function to control the submit button
    function toggleSubmit() {
        if (usernameValid && emailValid) {
            submitBtn.prop('disabled', false);
        } else {
            submitBtn.prop('disabled', true);
        }
    }

    // Check username availability
    usernameField.on('blur keyup', function() {
        const username = $(this).val().trim();
        if (username.length > 0) {
            $.get('{{ route('check.username') }}', { username: username }, function(data) {
                if (data.exists) {
                    usernameFeedback.text('This username is already taken.').removeClass('text-success').addClass('text-danger');
                    usernameValid = false;
                } else {
                    usernameFeedback.text('Username is available.').removeClass('text-danger').addClass('text-success');
                    usernameValid = true;
                }
                toggleSubmit();
            });
        } else {
            usernameFeedback.text('');
            usernameValid = true;
            toggleSubmit();
        }
    });

    // Check email availability
    emailField.on('blur keyup', function() {
        const email = $(this).val().trim();
        if (email.length > 0) {
            $.get('{{ route('check.email') }}', { email: email }, function(data) {
                if (data.exists) {
                    emailFeedback.text('This email is already registered.').removeClass('text-success').addClass('text-danger');
                    emailValid = false;
                } else {
                    emailFeedback.text('Email is available.').removeClass('text-danger').addClass('text-success');
                    emailValid = true;
                }
                toggleSubmit();
            });
        } else {
            emailFeedback.text('');
            emailValid = true;
            toggleSubmit();
        }
    });
});
</script>
@endpush

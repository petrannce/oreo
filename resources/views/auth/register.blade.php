@extends('layouts.backend.auth')

@section('content')

<div class="container">
    <div class="col-md-12 content-center">
        <div class="card-plain">
            <form class="form" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="header">
                    <div class="logo-container">
                        <img src="{{asset('assets/images/logo.svg')}}" alt="">
                    </div>
                    <h5>Sign Up</h5>
                    <span>Register a new membership</span>
                </div>
                <div class="content">
                    <div class="input-group">
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Full Name"
                            required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-account-circle"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter Email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-email"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password"/>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-lock"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                            class="form-control" required autocomplete="new-password"/>
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-lock"></i>
                        </span>
                    </div>
                </div>
                <div class="checkbox">
                    <input id="terms" type="checkbox">
                    <label for="terms">
                        I read and agree to the <a href="javascript:void(0);">terms of usage</a>
                    </label>
                </div>
                <div class="footer text-center">
                    <a href="{{route(name: 'register')}}"
                        class="btn btn-primary btn-round btn-block  waves-effect waves-light">SIGN
                        UP</a>
                    <h5><a class="link" href="{{route(name: 'login')}}">You already have a membership?</a></h5>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
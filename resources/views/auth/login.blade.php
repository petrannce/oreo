@extends('layouts.backend.auth')

@section('content')
<div class="container">
    <div class="col-md-12 content-center">
        <div class="card-plain">

            <div class="header">
                <div class="logo-container">
                    <img src="{{asset('assets/images/logo.svg')}}" alt="">
                </div>
                <h5>Log in</h5>
            </div>
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="content">
                    <div class="input-group">
                        <input type="text" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email Address"
                            required>
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
                            class="form-control @error('password') is-invalid @enderror" required />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-lock"></i>
                        </span>
                    </div>
                </div>
                <div class="footer text-center">
                    <a href="{{route(name: 'login')}}" class="btn btn-primary btn-round btn-block ">SIGN IN</a>
                    <h5><a href="{{ route('password.request') }}" class="link">Forgot Password?</a></h5>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
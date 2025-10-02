@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Edit User
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users')}}">Users</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="card">
                        <div class="header">
                            <h2><strong>Edit</strong> User </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form action="{{route('users.update', $user->id)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="fname" value="{{$user->fname}}" class="form-control"
                                                placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="lname" value="{{$user->lname}}" class="form-control"
                                                placeholder="Last Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="username" value="{{$user->username}}" class="form-control"
                                                placeholder=" Enter Your Username">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Enter Your Email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span>The default password is 12345678</span>
                                        <div class="form-group">
                                            <input type="text" name="password" value="12345678" class="form-control"
                                                placeholder="Password" minlength="8" value="12345678">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span>The default confirmed password is 12345678</span>
                                        <div class="form-group">
                                            <input type="text" name="confirm_password" class="form-control"
                                                placeholder="Confirm Password" minlength="8" value="12345678">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                        <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
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
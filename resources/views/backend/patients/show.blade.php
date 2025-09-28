@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>View Patient
                        <small>Welcome to Oreo</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}index.html}"><i class="zmdi zmdi-home"></i>
                                Oreo</a></li>
                        <li class="breadcrumb-item"><a href="{{route('patients')}}">Patient</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="card">
                        <div class="header">
                            <h2><strong>View</strong> Patient </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="id">ID</label>
                                        <input type="text" name="id" value="{{$patient->id}}" class="form-control"
                                            placeholder=" Enter Your ID">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" name="fname" value="{{$patient->user->fname}}" class="form-control"
                                            placeholder="First Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" name="lname" value="{{$patient->user->lname}}" class="form-control"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" value="{{$patient->user->email}}" class="form-control"
                                            placeholder="Enter Your Email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" name="Phone_number" value="{{$patient->user->phone_number ?? 'No Phone Number' }}"
                                            class="form-control" placeholder=" Enter Your Phone Number">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" value="{{$patient->user->address ?? 'No Address'}}" class="form-control"
                                            placeholder=" Enter Your Address">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" value="{{$patient->user->city ?? 'No City'}}" class="form-control"
                                            placeholder=" Enter Your City">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" name="country" value="{{$patient->user->country ?? 'No Country'}}" class="form-control"
                                            placeholder=" Enter Your Country">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <input type="text" name="gender" value="{{$patient->user->gender ?? 'No Gender'}}" class="form-control"
                                            placeholder=" Enter Your Gender">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="text" name="dob" value="{{$patient->dob}}" class="form-control"
                                            placeholder=" Enter Your Date of Birth">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
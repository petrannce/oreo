@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Edit Patient
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('patients')}}">Patient</a></li>
                    <li class="breadcrumb-item active">Edit Patient</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle"
                                    data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i
                                        class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
                                    <li><a href="javascript:void(0);">Edit</a></li>
                                    <li><a href="javascript:void(0);">Delete</a></li>
                                    <li><a href="javascript:void(0);">Report</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="{{route('patients.update', $patient)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="fname" value="{{$patient->fname}}" placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="lname" value="{{$patient->lname}}" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="email" value="{{$patient->email}}" placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone_number"value="{{$patient->phone_number}}"
                                            placeholder="Phone Number" min="10" required>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="address" value="{{$patient->address}}" placeholder="Address" required>
                                    </div>
                                </div>

                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="city" value="{{$patient->city}}" placeholder="City" required>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="country" value="{{$patient->country}}" placeholder="Country" required>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <select class="form-control show-tick" name="gender" required>
                                        <option value="">- Gender -</option>
                                        <option value="{{ $patient->gender == 'Male' ? 'selected' : '' }}">Male</option>
                                        <option value="{{ $patient->gender == 'Female' ? 'selected' : '' }}">Female</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="zmdi zmdi-calendar"></i>
                                        </span>
                                        <input type="date" class="form-control" name="dob" value="{{$patient->dob}}"
                                            placeholder="Enter date of birth">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
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
@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Add Doctors
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <button class="btn btn-white btn-icon btn-round d-none d-md-inline-block float-right m-l-10"
                    type="button">
                    <i class="zmdi zmdi-plus"></i>
                </button>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('doctors')}}">Doctors</a></li>
                    <li class="breadcrumb-item active">Add Doctors</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Basic</strong> Information <small>Description text here...</small> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>

                    <form action="{{route('doctors.store')}}" method="POST">
                        @csrf

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control"
                                            placeholder="Enter Your Email" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="speciality" class="form-control"
                                            placeholder="Speciality" required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <select class="form-control show-tick" name="department" required>
                                        <option value="">- Department -</option>
                                        @foreach ($departments as $department)
                                        <option value="{{$department->name}}">{{$department->name}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control show-tick" name="employee_type" required>
                                        <option value="">- Employee Type -</option>
                                        <option value="permanent">Permanent</option>
                                        <option value="contract">Contract</option>
                                        <option value="volunteer">Volunteer</option>
                                        <option value="consultant">Consultant</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea rows="4" name="description" class="form-control no-resize"
                                            placeholder="Please type what you want..."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                    <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Doctor's</strong> Account Information <small>Description text here...</small> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="User Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Doctor</strong> Social Media Info <small>Description text here...</small> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-facebook"></i></span>
                                    <input type="text" class="form-control" placeholder="Facebook">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-twitter"></i></span>
                                    <input type="text" class="form-control" placeholder="Twitter">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-google-plus"></i></span>
                                    <input type="text" class="form-control" placeholder="Google Plus">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-linkedin"></i></span>
                                    <input type="text" class="form-control" placeholder="LinkedIN">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-behance"></i></span>
                                    <input type="text" class="form-control" placeholder="Behance">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-dribbble"></i></span>
                                    <input type="text" class="form-control" placeholder="dribbble">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p> <b>With Search Bar</b> </p>
                                <select class="form-control z-index show-tick" data-live-search="true">
                                    <option>Hot Dog, Fries and a Soda</option>
                                    <option>Burger, Shake and a Smile</option>
                                    <option>Sugar, Spice and all things nice</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
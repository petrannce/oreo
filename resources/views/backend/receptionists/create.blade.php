@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Add Receptionist
                        <small>Welcome to Oreo</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                        <li class="breadcrumb-item"><a href="{{route('receptionists')}}">Receptionists</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Add</strong> Receptionist </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form action="{{route('receptionists.store')}}" method="POST">
                                @csrf

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Full Name" class="form-label">Full Name</label>
                                            <select class="form-control show-tick" name="user_id" id="user_id">
                                                <option value="" selected disabled>Select User</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->fname}} {{$user->lname}} -
                                                        {{$user->email}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="department" class="form-label">Department</label>
                                            <select class="form-control show-tick" name="department">
                                                <option value="" selected disabled>Select Department</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{$department->name}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Employee Code" class="form-label">Employee Code</label>
                                            <input type="text" name="employee_code" class="form-control"
                                                value="{{ old('employee_code') }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="hire_date" class="form-label">Hire Date</label>
                                            <input type="date" name="hire_date" class="form-control"
                                                placeholder=" Enter Your Hire Date">
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
@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Edit Patient
                        <small>Welcome to Oreo</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                        <li class="breadcrumb-item"><a href="{{route('patients')}}">Patients</a></li>
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
                            <h2><strong>Edit</strong> Patient </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form action="{{route('patients.update', $patient->id)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Full Name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $patient->user->fname }} {{ $patient->user->lname }}"
                                                readonly>
                                            <input type="hidden" name="user_id" class="form-control"
                                                value="{{ $patient->user->id }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Medical Record Number" class="form-label">Medical Record Number</label>
                                            <input type="text" name="medical_record_number" class="form-control"
                                                value="{{ $patient->medical_record_number }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Date Of Birth" class="form-label">Date Of Birth</label>
                                            <input type="text" name="dob" class="form-control"
                                                value=" {{ $patient->dob }} ">
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
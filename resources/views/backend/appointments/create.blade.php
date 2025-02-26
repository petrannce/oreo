@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Book Appointment
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('appointments')}}">Appointment</a></li>
                    <li class="breadcrumb-item active">Book Appointment</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form action="{{route('appointments.store')}}" method="post">
                    @csrf

                    <div class="card">
                        <div class="header">
                            <h2><strong>Book</strong> Appointment</h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <select name="patient_id" class="form-control show-tick">
                                        <option value="">- Select Patient -</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{$patient->id}}">{{$patient->fname}} {{$patient->lname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input name="booked_by" type="text" class="form-control"
                                            value="{{auth()->user()->fname}} {{auth()->user()->lname}}" placeholder="Booked By">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="zmdi zmdi-calendar"></i>
                                        </span>
                                        <input name="date" type="date" class="form-control datetimepicker"
                                            min="{{date('Y-m-d')}}" placeholder="Please choose a date">
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="zmdi zmdi-calendar"></i>
                                        </span>
                                        <input name="time" type="time" class="form-control timepicker"
                                            placeholder="Please choose a time...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <select name="service" class="form-control show-tick">
                                        <option value="">- Select Service -</option>
                                        @foreach ($services as $service)

                                            <option value="{{$service->name}}">{{$service->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <select name="doctor_id" class="form-control show-tick">
                                        <option value="">- Select Doctor -</option>
                                       @foreach ($doctors as $doctor)

                                       <option value="{{$doctor->id}}">{{$doctor->fname}} {{$doctor->lname}}</option>
                                       
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12" align="center">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                    <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
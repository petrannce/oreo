@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Edit Appointment
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('appointments')}}">Appointment</a></li>
                    <li class="breadcrumb-item active">Edit Appointment</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Edit</strong> Appointment</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="{{route('appointments.update', $appointment->id)}}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <input type="text" name="patient_id" class="form-control" value="{{$appointment->id}}" placeholder="Patient Name" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input name="booked_by" type="text" class="form-control"
                                            value="{{auth()->user()->fname}} {{auth()->user()->lname}}"
                                            placeholder="Booked By" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="zmdi zmdi-calendar"></i>
                                        </span>
                                        <input name="date" type="date" class="form-control datetimepicker" value="{{$appointment->date}}"
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
                                        <input name="time" type="time" class="form-control timepicker" value="{{$appointment->time}}"
                                            placeholder="Please choose a time...">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <select name="service" class="form-control show-tick" value="{{$appointment->service}}">
                                        @foreach ($services as $service)
                                            <option value="{{$service->name}}">{{$service->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <select name="doctor_id" class="form-control show-tick">
                                        <option value="">{{$appointment->doctor_fname}}</option>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
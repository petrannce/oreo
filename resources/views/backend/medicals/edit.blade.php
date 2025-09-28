@extends('layouts.backend.header')

@section('content')

<section class="content blog-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Edit Record
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('medicals')}}">Medical</a></li>
                    <li class="breadcrumb-item active">Edit Record</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <form action="{{route('medicals.update', $medical_record->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="body">

                            <div class="mb-3">
                                <label for="patient_id" class="form-label">Patient</label>
                                <input type="text" class="form-control" name="patient_id" value="{{$medical_record->patient_id}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="doctor" class="form-label">Doctor</label>
                                <input name="doctor_id" type="hidden" value="{{ auth()->id() }}">
                                <input type="text" class="form-control" value="{{auth()->user()->fname}} {{auth()->user()->lname}}"  readonly/>
                            </div>
                            <div class="mb-3">
                                <label for="record_date" class="form-label">Record Date</label>
                                <input type="date" class="form-control" name="record_date"
                                    placeholder="Enter Record Date" value="{{$medical_record->record_date}}" min="{{date('Y-m-d')}}" readonly/>
                            </div>

                            <div class="mb-3">
                                <label for="record_dianose" class="form-label">Diagnosis</label>
                                <textarea rows="3" class="form-control no-resize" name="diagnosis"
                                    placeholder="Please type your diagnosis...">{{$medical_record->diagnosis}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="prescription" class="form-label">Prescription</label>
                                <textarea rows="3" class="form-control no-resize" name="prescription"
                                    placeholder="Please type your prescription...">{{$medical_record->prescription}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="record_dianose" class="form-label">Notes</label>
                                <textarea rows="3" class="form-control no-resize" name="notes"
                                    placeholder="Please type your notes...">{{$medical_record->notes}}</textarea>
                            </div>
                        </div>

                        <div class="mb-3" align="center">
                            <button type="submit" class="btn btn-primary btn-round">Submit</button>
                            <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
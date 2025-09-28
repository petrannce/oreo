@extends('layouts.backend.header')

@section('content')

<section class="content blog-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>New Record
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('medicals')}}">Medical</a></li>
                    <li class="breadcrumb-item active">New Record</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <form action="{{route('medicals.store')}}" method="post">
                        @csrf

                        <div class="body">

                            <div class="mb-3">
                                <label for="patient_id" class="form-label">Patient</label>
                                <select class="form-control show-tick" name="patient_id">
                                    <option value="">-- Select Patient --</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{$patient->user->id}}">{{$patient->user->fname}} {{$patient->user->lname}}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="doctor" class="form-label">Doctor</label>
                                <input name="doctor_id" type="hidden" value="{{ auth()->id() }}">
                                <input type="text" class="form-control" value="{{auth()->user()->fname}} {{auth()->user()->lname}}"  readonly/>
                            </div>
                            <div class="mb-3">
                                <label for="record_date" class="form-label">Record Date</label>
                                <input type="date" class="form-control" name="record_date"
                                    placeholder="Enter Record Date" min="{{date('Y-m-d')}}" />
                            </div>

                            <div class="mb-3">
                                <label for="record_dianose" class="form-label">Diagnosis</label>
                                <textarea rows="3" class="form-control no-resize" name="diagnosis"
                                    placeholder="Please type your diagnosis..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="prescription" class="form-label">Prescription</label>
                                <textarea rows="3" class="form-control no-resize" name="prescription"
                                    placeholder="Please type your prescription..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea rows="3" class="form-control no-resize" name="notes"
                                    placeholder="Please type your notes..."></textarea>
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
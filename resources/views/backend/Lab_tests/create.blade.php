@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>Lab Tests <small>Create a new lab test record</small></h2>
    </div>

    <div class="container-fluid">
        <div class="row clearfix justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="header bg-primary text-white px-4 py-3 rounded-top">
                        <h5 class="mb-0"><i class="zmdi zmdi-flask"></i> Create Lab Test</h5>
                    </div>

                    <div class="body px-4 py-4">
                        <form action="{{ route('lab_tests.store') }}" method="POST">
                            @csrf

                            {{-- Basic Information --}}
                            <h6 class="font-weight-bold text-uppercase mb-3 text-muted">Basic Information</h6>
                            <div class="row">

                                {{-- Patient --}}
                                <div class="col-md-4 mb-3">
                                    <label>Patient <span class="text-danger">*</span></label>
                                    @if(isset($selectedAppointment))
                                        <input type="text" class="form-control" readonly
                                               value="{{ $selectedAppointment->patient->fname }} {{ $selectedAppointment->patient->lname }}">
                                        <input type="hidden" name="patient_id" value="{{ $selectedAppointment->patient_id }}">
                                    @else
                                        <select name="patient_id" class="form-control" required>
                                            <option value="">-- Select Patient --</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->fname }} {{ $patient->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('patient_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Doctor --}}
                                <div class="col-md-4 mb-3">
                                    <label>Doctor <span class="text-danger">*</span></label>
                                    @if(isset($selectedAppointment))
                                        <input type="text" class="form-control" readonly
                                               value="{{ $selectedAppointment->doctor->fname }} {{ $selectedAppointment->doctor->lname }}">
                                        <input type="hidden" name="doctor_id" value="{{ $selectedAppointment->doctor_id }}">
                                    @else
                                        <select name="doctor_id" class="form-control" required>
                                            <option value="">-- Select Doctor --</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                    {{ $doctor->fname }} {{ $doctor->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('doctor_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Lab Technician --}}
                                <div class="col-md-4 mb-3">
                                    <label>Lab Technician</label>
                                    @if(auth()->user()->role === 'lab_technician')
                                        <input type="text" class="form-control" readonly
                                               value="{{ auth()->user()->fname }} {{ auth()->user()->lname }}">
                                        <input type="hidden" name="lab_technician_id" value="{{ auth()->id() }}">
                                    @else
                                        <select name="lab_technician_id" class="form-control">
                                            <option value="">-- Assign Later --</option>
                                            @foreach($lab_technicians as $tech)
                                                <option value="{{ $tech->id }}" {{ old('lab_technician_id') == $tech->id ? 'selected' : '' }}>
                                                    {{ $tech->fname }} {{ $tech->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            {{-- Test Details --}}
                            <h6 class="font-weight-bold text-uppercase mb-3 text-muted">Test Details</h6>
                            <div class="row">
                                {{-- Appointment --}}
                                <div class="col-md-6 mb-3">
                                    <label>Linked Appointment</label>
                                    @if(isset($selectedAppointment))
                                        <input type="text" class="form-control" readonly
                                               value="#{{ $selectedAppointment->id }} — {{ \Carbon\Carbon::parse($selectedAppointment->date)->format('d M Y') }}">
                                        <input type="hidden" name="appointment_id" value="{{ $selectedAppointment->id }}">
                                    @else
                                        <select name="appointment_id" class="form-control">
                                            <option value="">-- None --</option>
                                            @foreach($appointments as $appt)
                                                <option value="{{ $appt->id }}" {{ old('appointment_id') == $appt->id ? 'selected' : '' }}>
                                                    #{{ $appt->id }} — {{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                {{-- Test Name --}}
                                <div class="col-md-6 mb-3">
                                    <label>Test Name <span class="text-danger">*</span></label>
                                    <input type="text" name="test_name" class="form-control" value="{{ old('test_name') }}" required>
                                    @error('test_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Results --}}
                                <div class="col-md-12 mb-3">
                                    <label>Results</label>
                                    <textarea name="results" class="form-control" rows="4" required>{{ old('results') }}</textarea>
                                </div>
                            </div>

                            <hr>

                            {{-- Status --}}
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="requested" {{ old('status') == 'requested' ? 'selected' : '' }}>Requested</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="mt-3 text-right">
                                <a href="{{ route('lab_tests') }}" class="btn btn-secondary mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Test</button>
                            </div>
                        </form>

                        {{-- DEBUG (remove when working) --}}
                        {{-- @if(isset($selectedAppointment))
                            <pre>{{ json_encode($selectedAppointment->only(['id','patient_id','doctor_id']), JSON_PRETTY_PRINT) }}</pre>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

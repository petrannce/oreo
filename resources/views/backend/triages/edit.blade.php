@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>Edit Triage <small>Welcome to Hospital System</small></h2>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <form action="{{ route('triages.update', $triage->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row clearfix">
                                {{-- Patient --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Patient</label>
                                        <input type="text" class="form-control"
                                            value="{{ $triage->patient->fname }} {{ $triage->patient->lname }}" readonly>
                                    </div>
                                </div>

                                {{-- Appointment --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Appointment</label>
                                        <input type="text" class="form-control"
                                            value="#{{ $triage->appointment->id }} - {{ $triage->appointment->date }}" readonly>
                                    </div>
                                </div>

                                {{-- Nurse --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nurse</label>
                                        <select name="nurse_id" class="form-control show-tick">
                                            <option value="">-- Assign Later --</option>
                                            @foreach($nurses as $nurse)
                                                <option value="{{ $nurse->id }}" {{ $triage->nurse_id == $nurse->id ? 'selected' : '' }}>
                                                    {{ $nurse->fname }} {{ $nurse->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Temperature --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Temperature (°C)</label>
                                        <input type="number" step="0.01" name="temperature" class="form-control" value="{{ $triage->temperature }}">
                                    </div>
                                </div>

                                {{-- Heart Rate --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Heart Rate</label>
                                        <input type="text" name="heart_rate" class="form-control" value="{{ $triage->heart_rate }}">
                                    </div>
                                </div>

                                {{-- Blood Pressure --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Blood Pressure</label>
                                        <input type="text" name="blood_pressure" class="form-control" value="{{ $triage->blood_pressure }}">
                                    </div>
                                </div>

                                {{-- Weight --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Weight (kg)</label>
                                        <input type="number" step="0.01" name="weight" class="form-control" value="{{ $triage->weight }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Notes --}}
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea name="notes" class="form-control" rows="4">{{ $triage->notes }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-round">Update</button>
                            <a href="{{ route('triages') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

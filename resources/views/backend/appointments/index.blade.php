@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Appointments
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">
                            <i class="zmdi zmdi-home"></i> Oreo
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('appointments') }}">Appointments</a></li>
                    <li class="breadcrumb-item active">All Appointments</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between align-items-center">
                        <h2><strong>All Appointments</strong></h2>
                        @role('admin|receptionist')
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-lg">
                            <i class="zmdi zmdi-plus"></i> Create Appointment
                        </a>
                        @endrole
                    </div>

                    {{-- Success and Error Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Filters --}}
                    @include('layouts.partials.filter', [
                        'filterRoute' => route('appointments'),
                        'reportRoute' => route('reports.generate'),
                        'extraFilters' => [],
                        'type' => 'appointments',
                    ])

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient</th>
                                        <th>Date</th>
                                        <th>Service</th>
                                        <th>Doctor</th>
                                        <th>Status</th>
                                        <th>Current Stage</th>
                                        <th>Move to Next Stage</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $appointment->patient->fname }} {{ $appointment->patient->lname }}</td>
                                            <td>{{ $appointment->date }}</td>
                                            <td>{{ $appointment->service->name }}</td>
                                            <td>{{ $appointment->doctor->fname }} {{ $appointment->doctor->lname }}</td>

                                            {{-- Status --}}
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-sm btn-rounded dropdown-toggle
                                                        @if($appointment->status == 'approved') btn-success
                                                        @elseif($appointment->status == 'pending') btn-primary
                                                        @elseif($appointment->status == 'cancelled') btn-info
                                                        @else btn-danger @endif"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        {{ ucfirst($appointment->status) }}
                                                    </a>

                                                    @role('admin|doctor')
                                                    <div class="dropdown-menu">
                                                        @foreach(['approved', 'pending', 'cancelled', 'rejected'] as $status)
                                                            <a class="dropdown-item"
                                                               href="{{ route('appointment.updateStatus', ['id' => $appointment->id, 'status' => $status]) }}">
                                                               {{ ucfirst($status) }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                    @endrole
                                                </div>
                                            </td>

                                            {{-- Current Process Stage --}}
                                            <td>
                                                <span class="badge badge-pill badge-{{ 
                                                    match($appointment->process_stage) {
                                                        'reception' => 'primary',
                                                        'triage' => 'info',
                                                        'doctor_consult' => 'success',
                                                        'lab' => 'warning',
                                                        'pharmacy' => 'secondary',
                                                        'billing' => 'dark',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger',
                                                        default => 'light'
                                                    }
                                                }}">
                                                    {{ ucfirst(str_replace('_', ' ', $appointment->process_stage)) }}
                                                </span>
                                            </td>

                                            {{-- Next Stage Dropdown --}}
                                            <td>
    <div class="dropdown">
        <button class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown">
            Move Stage
        </button>
        <div class="dropdown-menu">
            @foreach(['reception','triage','doctor_consult','lab','pharmacy','billing','completed'] as $stage)
                @if($stage !== $appointment->process_stage && in_array($stage, $allowedStages))
                    <a class="dropdown-item"
                       href="{{ route('appointment.updateStage', ['id' => $appointment->id, 'stage' => $stage]) }}">
                       Move to {{ ucfirst(str_replace('_', ' ', $stage)) }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</td>

                                            {{-- Actions --}}
                                            <td>
                                                @role('admin|nurse')
    <a href="{{ route('triages.create', ['appointment_id' => $appointment->id]) }}" class="btn btn-sm btn-success">
        Create Triage
    </a>
@endrole
                                                @role('admin|receptionist')
                                                <button type="button" class="btn btn-icon btn-neutral btn-icon-mini" onclick="editAppointment({{ $appointment->id }})">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>

                                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="return confirm('Are you sure you want to delete this appointment?');">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </form>
                                                @endrole
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- End body -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    function editAppointment(id) {
        window.location.href = "{{ url('admin/appointment') }}/" + id + "/edit";
    }
</script>

@endsection



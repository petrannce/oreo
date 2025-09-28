@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Appointment
                        <small class="text-muted">Welcome to Oreo</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{route('appointments')}}">Appointments</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>All Appointments</strong> </h2>
                            @role('admin|receptionist')
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a class="btn btn-primary btn-lg" href="{{route('appointments.create')}}"
                                        role="button">Create Appointment</a>
                                </li>
                            </ul>
                            @endrole
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>*</th>
                                            <th>Patient ID</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                            <th>Doctor</th>
                                            <th>Status</th>
                                            <th>Medical Records</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($appointments as $appointment)

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $appointment->patient->fname }} {{ $appointment->patient->lname }}</td>
                                                <td>{{ $appointment->date }}</td>
                                                <td>{{ $appointment->time }}</td>
                                                <td>{{ $appointment->service->name }}</td>
                                                <td>{{ $appointment->doctor->fname }} {{ $appointment->doctor->lname }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" 
                                                        class="btn btn-sm btn-rounded dropdown-toggle
                                                            @if($appointment->status == 'approved') btn-success
                                                            @elseif($appointment->status == 'pending') btn-primary
                                                            @elseif($appointment->status == 'cancelled') btn-info
                                                            @else
                                                            btn-danger
                                                            @endif"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                            {{ ucfirst($appointment->status) }}
                                                        </a>
                                                        @role('admin|doctor')
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                                href="{{ route('appointment.updateStatus', ['id' => $appointment->id, 'status' => 'approved']) }}">
                                                                <i class="text-success"></i> Approved
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('appointment.updateStatus', ['id' => $appointment->id, 'status' => 'pending']) }}">
                                                                <i class="text-primary"></i> Pending
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('appointment.updateStatus', ['id' => $appointment->id, 'status' => 'cancelled']) }}">
                                                                <i class="text-info"></i> Cancelled
                                                            </a>
                                                        </div>
                                                        @endrole
                                                    </div>
                                                </td>
                                                <td><button class="btn btn-primary"><a
                                                            href="{{ route('medicals') }}">Medical</a></button></td>
                                                <td>
                                                    <!-- View Button -->
                                                    <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="viewAppointment({{ $appointment->id }})">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </button>

                                                    @role('admin|receptionist')

                                                    <!-- Edit Button -->
                                                    <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="editAppointment({{ $appointment->id }})">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('appointments.destroy', $appointment->id) }}"
                                                        method="POST" style="display:inline;">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

<script>

    function viewAppointment(appointmentId) {
        window.location.href = `/admin/appointments/${appointmentId}`;
    }

</script>

<script>

    function editAppointment(appointmentId) {
        window.location.href = `/admin/appointment/${appointmentId}/edit`;
    }

</script>
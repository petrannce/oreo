@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Appointments
                        <small class="text-muted">Welcome to Oreo Smart Health System</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">
                                <i class="zmdi zmdi-home"></i> Oreo
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
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

                        {{-- Flash Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if(session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @endif
                        @if(session('billing_message'))
                            <div class="alert alert-warning">{{ session('billing_message') }}</div>
                        @endif

                        <div class="body">
                            <div class="table-responsive">
                                @php
                                    $validStages = ['reception', 'triage', 'doctor_consult', 'lab', 'pharmacy', 'billing', 'completed'];
                                    $rolePermissions = [
                                        'receptionist' => ['reception', 'triage', 'cancelled'],
                                        'nurse' => ['triage', 'doctor_consult'],
                                        'doctor' => ['doctor_consult', 'lab', 'pharmacy'],
                                        'lab_technician' => ['lab','doctor_consult'],
                                        'pharmacist' => ['pharmacy','billing'],
                                        'accountant' => ['billing', 'completed'],
                                        'admin' => ['reception', 'triage', 'doctor_consult', 'lab', 'pharmacy', 'billing', 'completed', 'cancelled'],
                                    ];
                                @endphp

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
                                            <th>Move Stage</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($appointments as $appointment)
                                                                        @php
                                                                            $stage = $appointment->process_stage;
                                                                            $role = auth()->user()->role;
                                                                            $allowedStages = $rolePermissions[$role] ?? [];
                                                                            $isFinalStage = in_array($stage, ['completed', 'cancelled']) ||
                                                                                (!empty($allowedStages) && end($allowedStages) === $stage);
                                                                            // NEW: check if any lab_tests exist for this appointment (performed tests)
                                                                            $hasPerformedLabTests = $appointment->labTests()->exists();
                                                                        @endphp

                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $appointment->patient->fname }} {{ $appointment->patient->lname }}</td>
                                                                            <td>{{ $appointment->date }}</td>
                                                                            <td>{{ $appointment->service->name }}</td>
                                                                            <td>{{ $appointment->doctor->fname }} {{ $appointment->doctor->lname }}</td>

                                                                            {{-- Appointment Status --}}
                                                                            <td>
                                                                                <div class="dropdown">
                                                                                    <a href="#" class="btn btn-sm btn-rounded dropdown-toggle
                                                                                            @if($appointment->status == 'approved') btn-success
                                                                                            @elseif($appointment->status == 'pending') btn-primary
                                                                                            @elseif($appointment->status == 'cancelled') btn-info
                                                                                            @else btn-danger @endif" data-toggle="dropdown">
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

                                                                            {{-- Current Stage --}}
                                                                            <td>
                                                                                <span class="badge badge-pill badge-{{ 
                                                                                        match ($appointment->process_stage) {
                                                'reception' => 'warning',
                                                'triage' => 'info',
                                                'doctor_consult' => 'success',
                                                'lab' => 'secondary',
                                                'pharmacy' => 'primary',
                                                'billing' => 'dark',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',                                                default => 'light'
                                            }
                                                                                    }}">
                                                                                    {{ ucfirst(str_replace('_', ' ', $appointment->process_stage)) }}
                                                                                </span>
                                                                            </td>

                                                                            {{-- Move Stage --}}
                                                                            <td>
                                                                                @if(!$isFinalStage)
                                                                                    <div class="dropdown">
                                                                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                                            data-toggle="dropdown">
                                                                                            Move Stage
                                                                                        </button>
                                                                                        <div class="dropdown-menu">
                                                                                            @foreach($validStages as $nextStage)
                                                                                                @if($nextStage !== $stage && in_array($nextStage, $allowedStages))
                                                                                                    <a class="dropdown-item"
                                                                                                        href="{{ route('appointment.updateStage', ['id' => $appointment->id, 'stage' => $nextStage]) }}">
                                                                                                        Move to {{ ucfirst(str_replace('_', ' ', $nextStage)) }}
                                                                                                    </a>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    <span class="text-muted small">Final Stage</span>
                                                                                @endif
                                                                            </td>

                                                                            {{-- Actions --}}
                                                                            <td>
                                                                                {{-- TRIAGE --}}
                                                                                @if($stage === 'triage' && auth()->user()->hasAnyRole(['nurse', 'admin']))
                                                                                    @if($appointment->triage)
                                                                                        <a href="{{ route('triages.show', $appointment->triage->id) }}"
                                                                                            class="btn btn-sm btn-success">
                                                                                            <i class="zmdi zmdi-check"></i> Triage Created
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ route('triages.create', ['appointment_id' => $appointment->id]) }}"
                                                                                            class="btn btn-sm btn-info">
                                                                                            <i class="zmdi zmdi-assignment"></i> Create Triage
                                                                                        </a>
                                                                                    @endif
                                                                                @endif

                                                                                {{-- DOCTOR CONSULT --}}
                                                                                @if($stage === 'doctor_consult' && auth()->user()->hasAnyRole(['doctor', 'admin']))
                                                                                    @if($appointment->medicalReport)
                                                                                        <a href="{{ route('medicals.show', $appointment->medicalReport->id) }}"
                                                                                            class="btn btn-sm btn-success">
                                                                                            <i class="zmdi zmdi-check"></i> Consultation Done
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ route('medicals.create', ['appointment_id' => $appointment->id]) }}"
                                                                                            class="btn btn-sm btn-primary">
                                                                                            <i class="zmdi zmdi-file-text"></i> Create Report
                                                                                        </a>
                                                                                    @endif
                                                                                @endif

                                                                                {{-- LAB --}}
                                                                                @if($stage === 'lab' && auth()->user()->hasAnyRole(['lab_technician', 'doctor', 'admin']))
                                                                                    @if($hasPerformedLabTests)
                                                                                        {{-- LINK: showByAppointment route (uses appointment id) --}}
                                                                                        <a href="{{ route('lab_tests.show', $appointment->id) }}"
                                                                                            class="btn btn-sm btn-success">
                                                                                            <i class="zmdi zmdi-flask"></i> View Results
                                                                                        </a>
                                                                                        {{-- Back to doctor_consult button --}}
                                                                                        <a href="{{ route('appointment.updateStage', ['id' => $appointment->id, 'stage' => 'doctor_consult']) }}"
                                                                                            class="btn btn-sm btn-outline-primary">
                                                                                            <i class="zmdi zmdi-rotate-left"></i> Back to Doctor Consult
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ route('lab_tests.create', ['appointment_id' => $appointment->id]) }}"
                                                                                            class="btn btn-sm btn-warning">
                                                                                            <i class="zmdi zmdi-flask"></i> Record Lab
                                                                                        </a>
                                                                                    @endif
                                                                                @endif

                                                                                {{-- PHARMACY --}}
                                                                                @if($stage === 'pharmacy' && auth()->user()->hasAnyRole(['pharmacist', 'admin']))
                                                                                    @if($appointment->pharmacyOrder)
                                                                                        <a href="{{ route('pharmacy_orders.edit', $appointment->pharmacyOrder->id) }}"
                                                                                            class="btn btn-sm btn-success">
                                                                                            <i class="zmdi zmdi-check"></i> Dispensed
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ route('pharmacy_orders.create', ['appointment_id' => $appointment->id]) }}"
                                                                                            class="btn btn-sm btn-secondary">
                                                                                            <i class="zmdi zmdi-local-pharmacy"></i> Dispense
                                                                                        </a>
                                                                                    @endif
                                                                                @endif

                                                                                {{-- BILLING --}}
                                                                                @if($stage === 'billing' && auth()->user()->hasAnyRole(['accountant', 'admin']))
                                                                                    @if($appointment->billing)
                                                                                        {{-- ✅ Bill already exists --}}
                                                                                        <div class="btn-group" role="group">
                                                                                            {{-- 1️⃣ View / Edit Billing Items --}}
                                                                                            <a href="{{ route('billings.edit', $appointment->billing->id) }}"
                                                                                                class="btn btn-sm btn-info">
                                                                                                <i class="zmdi zmdi-edit"></i> Update Bill
                                                                                            </a>

                                                                                            {{-- 2️⃣ View Final Receipt (only when status = paid) --}}
                                                                                            @if($appointment->billing->status === 'paid')
                                                                                                <a href="{{ route('billings.receipt', $appointment->billing->id) }}"
                                                                                                    class="btn btn-sm btn-success">
                                                                                                    <i class="zmdi zmdi-receipt"></i> View Final Bill
                                                                                                </a>
                                                                                            @else
                                                                                                <a href="{{ route('billings.show', $appointment->billing->id) }}"
                                                                                                    class="btn btn-sm btn-secondary">
                                                                                                    <i class="zmdi zmdi-money"></i> View Bill
                                                                                                </a>
                                                                                            @endif
                                                                                        </div>
                                                                                    @else
                                                                                        {{-- 🧾 No Bill yet --}}
                                                                                        <a href="{{ route('billings.create', ['appointment_id' => $appointment->id]) }}"
                                                                                            class="btn btn-sm btn-dark">
                                                                                            <i class="zmdi zmdi-money"></i> Generate Bill
                                                                                        </a>
                                                                                    @endif
                                                                                @endif


                                                                                {{-- Edit/Delete --}}
                                                                                @role('admin|receptionist')
                                                                                <button type="button" class="btn btn-icon btn-neutral btn-icon-mini"
                                                                                    onclick="editAppointment({{ $appointment->id }})">
                                                                                    <i class="zmdi zmdi-edit"></i>
                                                                                </button>
                                                                                <form action="{{ route('appointments.destroy', $appointment->id) }}"
                                                                                    method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                                                        onclick="return confirm('Are you sure you want to delete this appointment?');">
                                                                                        <i class="zmdi zmdi-delete text-danger"></i>
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

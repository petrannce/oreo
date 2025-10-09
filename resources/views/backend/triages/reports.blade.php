@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>Triages <small class="text-muted">Hospital System</small></h2>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>All Triages</strong></h2>
                    </div>
                    @include('layouts.partials.filter',[
                            'filterRoute' => route('triages'),
                            'reportRoute' => route('reports.generate'),
                            'extraFilters' => [],
                            'type' => 'triages',
                            ])

                            @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient</th>
                                        <th>Appointment</th>
                                        <th>Nurse</th>
                                        <th>Temperature</th>
                                        <th>Heart Rate</th>
                                        <th>Blood Pressure</th>
                                        <th>Weight</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($triages as $triage)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $triage->patient->fname }} {{ $triage->patient->lname }}</td>
                                        <td>#{{ $triage->appointment->id }}</td>
                                        <td>{{ $triage->nurse?->fname ?? 'Unassigned' }}</td>
                                        <td>{{ $triage->temperature ?? '-' }}</td>
                                        <td>{{ $triage->heart_rate ?? '-' }}</td>
                                        <td>{{ $triage->blood_pressure ?? '-' }}</td>
                                        <td>{{ $triage->weight ?? '-' }}</td>
                                        <td>{{ Str::limit($triage->notes, 30) }}</td>
                                        <td>
                                            <a href="{{ route('triages.edit', $triage->id) }}" class="btn btn-icon btn-neutral btn-icon-mini">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <form action="{{ route('triages.destroy', $triage->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                    onclick="return confirm('Delete this triage?');">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </form>
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

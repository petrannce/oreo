@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Medicals
                        <small class="text-muted">Welcome to Oreo</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{route('medicals')}}">Medicals</a></li>
                        <li class="breadcrumb-item active">Medicals</li>
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
                            <h2><strong>All Medicals</strong> </h2>
                            @role('admin|doctor')
                            <ul class="header-dropdown">
                                <li class="remove">
                            </ul>
                            @endrole
                        </div>

                        @include('layouts.partials.filter',[
                            'filterRoute' => route('medicals'),
                            'reportRoute' => route('reports.generate'),
                            'extraFilters' => [],
                            'type' => 'medicals',
                            ])

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>*</th>
                                            <th>Patient Names</th>
                                            <th>Record Date</th>
                                            <th>Diagnosis</th>
                                            <th>Doctor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($medical_records as $medical_record)

                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    <a href="{{ route('patients.show', $medical_record->patient_id) }}">
                                                        {{ $medical_record->patient->fname }} 
                                                        {{ $medical_record->patient->lname }}
                                                    </a>
                                                </td>
                                                <td>{{$medical_record->record_date}}</td>
                                                <td>{{str_limit($medical_record->diagnosis, 30)}}</td>
                                                <td>{{$medical_record->doctor->fname}} {{ $medical_record->doctor->lname }}</td>
                                                <td>
                                                    <!-- View Button -->
                                                    <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="viewMedical({{ $medical_record->id }})">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </button>

                                                    @role('admin|doctor')

                                                    <!-- Edit Button -->
                                                    <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="editMedical({{ $medical_record->id }})">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    @role('admin')
                                                    <!-- Delete Button -->
                                                    <form action="{{ route('medicals.destroy', $medical_record->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                            onclick="return confirm('Are you sure you want to delete this medical record?');">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </form>
                                                    @endrole
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
    function editMedical(medicalId) {
        window.location.href = `/admin/medical-records/${medicalId}/edit`;
    }

</script>

<script>
    function viewMedical(medicalId) {
        window.location.href = `/admin/medical-records/${medicalId}`;
    }
</script>
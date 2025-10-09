@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Lab Technician
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('lab_technicians')}}">Lab Technician    </a></li>
                    <li class="breadcrumb-item active">Lab Technician</li>
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
                        <h2><strong>All Lab Technicians</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('lab_technicians.create')}}"
                                    role="button">Create Lab Technician</a>
                            </li>
                        </ul>
                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Full Name</th>
                                        <th>License Number</th>
                                        <th>Deparment</th>
                                        <th>Employee Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($lab_technicians as $lab_technician)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$lab_technician->user->fname}} {{$lab_technician->user->lname}}</td>
                                            <td>{{$lab_technician->license_number  }}</td>
                                            <td>{{$lab_technician->department}}</td>
                                            <td>{{$lab_technician->employee_code  }}</td>
                                            <td>{{$lab_technician->user->profile?->status ?? 'No Status'}}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                    onclick="editLab_technician({{ $lab_technician->id }})">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('lab_technicians.destroy', $lab_technician->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="return confirm('Are you sure you want to delete this lab_technician?');">
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

<script>
    function editLab_technician(lab_technicianId) {
        window.location.href = `/admin/lab_technicians/${lab_technicianId}/edit`;
    }
</script>
@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Nurses
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('nurses')}}">Nurses</a></li>
                    <li class="breadcrumb-item active">Nurses</li>
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
                        <h2><strong>All Nurses</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('nurses.create')}}"
                                    role="button">Create Nurse</a>
                            </li>
                        </ul>
                    </div>

                    @include('layouts.partials.filter',[
                            'filterRoute' => route('nurses'),
                            'reportRoute' => route('reports.generate'),
                            'extraFilters' => [],
                            'type' => 'nurses',
                            ])

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

                                    @foreach($nurses as $nurse)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$nurse->user->fname}} {{$nurse->user->lname}}</td>
                                            <td>{{$nurse->license_number  }}</td>
                                            <td>{{$nurse->department}}</td>
                                            <td>{{$nurse->employee_code  }}</td>
                                            <td>{{$nurse->user->profile?->status ?? 'No Status'}}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                    onclick="editNurse({{ $nurse->id }})">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('nurses.destroy', $nurse->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="return confirm('Are you sure you want to delete this nurse?');">
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
    function editNurse(nurseId) {
        window.location.href = `/admin/nurses/${nurseId}/edit`;
    }
</script>
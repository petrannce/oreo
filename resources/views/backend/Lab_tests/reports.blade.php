@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>Lab Tests <small class="text-muted">Hospital System</small></h2>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>All Lab Tests</strong></h2>
                        @role('admin|lab_technician')
                        <ul class="header-dropdown">
                        </ul>
                        @endrole
                    </div>
                    @include('layouts.partials.filter',[
                            'filterRoute' => route('lab_tests'),
                            'reportRoute' => route('reports.generate'),
                            'extraFilters' => [],
                            'type' => 'lab_tests',
                            ])

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Lab Technician</th>
                                        <th>Test Name</th>
                                        <th>Status</th>
                                        <th>Results</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lab_tests as $lab_test)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lab_test->patient->fname }} {{ $lab_test->patient->lname }}</td>
                                        <td>{{ $lab_test->doctor->fname }} {{ $lab_test->doctor->lname }}</td>
                                        <td>{{ $lab_test->lab_technician->fname }} {{ $lab_test->lab_technician->lname }}</td>
                                        <td>{{ $lab_test->test_name }}</td>
                                        <td>{{ ucfirst($lab_test->status) }}</td>
                                        <td>{{ $lab_test->results ? Str::limit($lab_test->results, 30) : 'Pending' }}</td>
                                        <td>
                                            <a href="{{ route('lab_tests.edit', $lab_test->id) }}" class="btn btn-icon btn-neutral btn-icon-mini">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <form action="{{ route('lab_tests.destroy', $lab_test->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                    onclick="return confirm('Delete this lab test?');">
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

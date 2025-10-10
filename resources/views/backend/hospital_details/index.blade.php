@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Hospital Details
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('hospital_services')}}">Hospital Details</a></li>
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
                        <h2><strong>All Hospital Details</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('hospital_details.create')}}"
                                    role="button">Create Hospital Detail</a>
                            </li>
                        </ul>
                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Website</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($hospital_details as $hospital_detail)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$hospital_detail->name}}</td>
                                            <td>{{$hospital_detail->address}}</td>
                                            <td>{{$hospital_detail->phone_number}}</td>
                                            <td>{{$hospital_detail->email}}</td>
                                            <td>{{ $hospital_detail->website }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                    onclick="editHospitalDetail({{ $hospital_detail->id }})">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('hospital_details.destroy', $hospital_detail->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="return confirm('Are you sure you want to delete this hospital service?');">
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
    function editHospitalDetail(hospitalDetailId) {
        window.location.href = `/admin/hospital_details/${hospitalDetailId}/edit`;
    }

</script>
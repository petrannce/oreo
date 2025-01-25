@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Patients
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('patients')}}">Patients</a></li>
                    <li class="breadcrumb-item active">Patients</li>
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
                        <h2><strong>All Patients</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('patient.create')}}"
                                    role="button">Create Patient</a>
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
                                        <th>Email</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($patients as $patient)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$patient->fname}} {{$patient->lname}}</td>
                                            <td>{{$patient->email}}</td>
                                            <td>{{$patient->age}}</td>
                                            <td>{{$patient->gender}}</td>
                                            <td>
                                                <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                        class="zmdi zmdi-edit"></i></button>
                                                <!-- <a href="{{route('patients.edit', $patient->id)}}"></a> -->
                                                <a href="javascript:void(0);" data-id="{{$patient->id}}"
                                                    onclick="deleteElement(this)"
                                                    class="btn btn-icon btn-neutral btn-icon-mini">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </a>

                                                <!-- <a href="{{route('patients.destroy', $patient->id)}}"></a> -->
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteElement(button) {
        if (!button || !button.getAttribute('data-id')) {
            console.error("Button or data-id is missing.");
            return;
        }

        const patientId = button.getAttribute('data-id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/patients/${patientId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error("Failed to delete");
                    })
                    .then(data => {
                        Swal.fire("Deleted!", data.message, "success");
                        button.closest('tr').remove();
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire("Error!", "Something went wrong.", "error");
                    });
            }
        });
    }

</script>
@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Services
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('services')}}">Services</a></li>
                    <li class="breadcrumb-item active">Services</li>
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
                        <h2><strong>All Services</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('services.create')}}" role="button">Create
                                    Service</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Service Title</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($services as $service)

                                        <tr id="service-{{$service->id}}">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{str_limit($service->name, 25)}}</td>
                                            <td>{{$service->image}}</td>
                                            <td>{{str_limit($service->description, 30)}}</td>
                                            <td>
                                                <button class="btn btn-icon btn-neutral btn-icon-mini" onclick="{handleEdit}"><i
                                                        class="zmdi zmdi-edit"></i></button>
                                                <button class="btn btn-icon btn-neutral btn-icon-mini delete-btn" onclick="{deleteElement(this)}"><i
                                                        class="zmdi zmdi-delete" data-id="{{$service->id}}"></i></button>
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
    
  document.addEventListener("DOMContentLoaded", function () {
    // Attach event listeners to all delete buttons
    const buttons = document.querySelectorAll(".delete-btn");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            const serviceId = this.getAttribute("data-id");

            // Confirm deletion
            if (confirm("Are you sure you want to delete this service?")) {
                fetch(`/delete/${serviceId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json"
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Remove the record from the DOM
                        const recordElement = document.getElementById(`service-${serviceId}`);
                        recordElement.remove();
                        alert("Service deleted successfully.");
                    } else {
                        alert("Failed to delete the service. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });
});

</script>
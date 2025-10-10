@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Add Hospital Services
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('hospital_services')}}">Hospital Services</a></li>
                    <li class="breadcrumb-item active">Add</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form action="{{route('hospital_services.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="header">
                            <h2><strong>Add</strong> Hospital Services </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" name="category" class="form-control"
                                            placeholder="Category">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" class="form-control"
                                            placeholder="Price">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea rows="4" name="description" class="form-control no-resize"
                                            placeholder="Please type what you want..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                    <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
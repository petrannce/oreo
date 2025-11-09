@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Edit Hospital Details
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('hospital_details')}}">Hospital Details</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form action="{{route('hospital_details.update', $hospital_detail->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="header">
                            <h2><strong>Add</strong> Hospital Details </h2>
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
                                        <label for="name">Hospital Name</label>
                                        <input type="text" name="name" class="form-control"
                                            Value="{{ $hospital_detail->name }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="address">Hospital Address</label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ $hospital_detail->address }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="phone_number">Hospital Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control"
                                            value="{{ $hospital_detail->phone_number }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Hospital Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $hospital_detail->email }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="website">Hospital Website</label>
                                        <input type="text" name="website" class="form-control"
                                            value="{{ $hospital_detail->website }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="logo">Hospital Logo</label>
                                        <input type="file" name="logo" class="form-control" value="{{ $hospital_detail->logo }}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="image">Hospital Image</label>
                                        <input type="file" name="image" class="form-control" value="{{ $hospital_detail->image }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                    <button type="{{route('hospital_details')}}" class="btn btn-default btn-round btn-simple">Cancel</button>
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
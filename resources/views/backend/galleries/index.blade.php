@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Galleries
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('galleries')}}">Galleries</a></li>
                    <li class="breadcrumb-item active">Galleries</li>
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
                        <h2><strong>All Galleries</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('faqs.create')}}" role="button">Create
                                Gallery</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($galleries as $gallery)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$gallery->title}}</td>
                                            <td>{{$gallery->image}}</td>
                                            <td>
                                                <!-- <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                        class="zmdi zmdi-edit"></i></button> -->
                                                <a href="{{route('galleries.edit', $gallery->id)}}"
                                                    class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                        class="zmdi zmdi-edit"></i></a>
                                                <!-- <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                        class="zmdi zmdi-delete"></i></button> -->
                                                <a href="{{route('galleries.destroy', $gallery->id)}}"
                                                    class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                        class="zmdi zmdi-delete"></i></a>
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
@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Receptionists
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('receptionists')}}">Receptionists</a></li>
                    <li class="breadcrumb-item active">Receptionists</li>
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
                        <h2><strong>All Receptionists</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('receptionists.create')}}" role="button">Create Receptionist</a>
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
                                        <th>Phone Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($receptionists as $receptionist)

                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$receptionist->fname}} {{$receptionist->lname}}</td>
                                        <td>{{$receptionist->email}}</td>
                                        <td>{{$receptionist->profile->phone ?? 'No Phone Number'}}</td>
                                        <td>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-edit"></i></button>
                                                    <!-- <a href="{{route('users.edit', $user->id)}}"></a> -->
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-delete"></i></button>
                                                    <!-- <a href="{{route('users.destroy', $user->id)}}"></a> -->
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
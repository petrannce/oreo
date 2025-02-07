@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Users
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users')}}">Users</a></li>
                    <li class="breadcrumb-item active">Users</li>
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
                        <h2><strong>All Users</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('users.create')}}" role="button">Create User</a>
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
                                        <th>Role</th>
                                        <th>Phone Number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($users as $user)

                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$user->fname}} {{$user->lname}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role}}</td>
                                        <td>{{$user->profile->phone_number ?? 'No Phone Number'}}</td>
                                        <td>{{$user->profile->status ?? 'No Status'}}</td>
                                        <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                    onclick="editUsers({{ $user->id }})">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="return confirm('Are you sure you want to delete this user?');">
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
    function editUsers(usersId) {
        window.location.href = `/admin/users/${usersId}/edit`;
    }
</script>

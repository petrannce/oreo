@extends('layouts.backend.header')

@section('content')
<section class="content profile-page">
    <div class="block-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="font-weight-bold mb-0">My Profile</h2>
                <small class="text-muted">Manage your personal details, account, and security</small>
            </div>
            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <a href="{{ route('admin') }}" class="btn btn-outline-primary btn-round">
                    <i class="zmdi zmdi-home"></i> Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">

            {{-- LEFT SIDEBAR --}}
            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="body text-center p-4">
                        <div class="position-relative d-inline-block">
                            <img src="{{ $user->profile->image ? asset('storage/'.$user->profile->image) : asset('assets/images/profile_av.jpg') }}"
                                alt="Profile Picture"
                                class="rounded-circle img-fluid shadow-sm"
                                style="width:130px; height:130px; object-fit:cover;">
                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tab" value="image">
                                <label for="profile_image" class="btn btn-sm btn-light btn-round mt-2">
                                    <i class="zmdi zmdi-camera"></i> Change Photo
                                </label>
                                <input type="file" name="image" id="profile_image" class="d-none" onchange="this.form.submit()">
                            </form>
                        </div>

                        <h4 class="mt-3 mb-1 font-weight-bold">{{ $user->fname }} {{ $user->lname }}</h4>
                        <p class="text-muted mb-1">{{ ucfirst($user->role) }}</p>
                        <p class="small text-secondary">
                            {{ $user->profile->city ?? 'N/A' }}, {{ $user->profile->country ?? 'N/A' }}
                        </p>

                        <hr>
                        <p class="mb-2"><i class="zmdi zmdi-email text-primary"></i> {{ $user->email }}</p>
                        <p class="mb-0"><i class="zmdi zmdi-phone text-primary"></i> {{ $user->profile->phone_number ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="card mt-4 border-0 shadow-sm rounded-lg">
                    <div class="body">
                        <h6 class="font-weight-bold mb-3">Profile Summary</h6>
                        <p class="text-muted mb-0">
                            Keep your contact details and preferences up-to-date for seamless communication.
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT MAIN CONTENT --}}
            <div class="col-lg-8 col-md-12">
                <div class="card border-0 shadow-sm rounded-lg">
                    <ul class="nav nav-tabs p-3 pb-0">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personalInfo">
                                <i class="zmdi zmdi-account"></i> Personal Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#accountSettings">
                                <i class="zmdi zmdi-lock"></i> Account Settings
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-4">
                        {{-- PERSONAL INFO TAB --}}
                        <div class="tab-pane fade show active" id="personalInfo">
                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tab" value="profile">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>First Name</label>
                                        <input type="text" name="fname" class="form-control" value="{{ $user->fname }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control" value="{{ $user->lname }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" value="{{ $user->username }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control" value="{{ $user->profile->phone_number ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="">Select</option>
                                            <option value="male" {{ ($user->profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ ($user->profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control" value="{{ $user->profile->city ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Country</label>
                                        <input type="text" name="country" class="form-control" value="{{ $user->profile->country ?? '' }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Address</label>
                                        <textarea name="address" rows="3" class="form-control">{{ $user->profile->address ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button class="btn btn-primary btn-round"><i class="zmdi zmdi-save"></i> Save Changes</button>
                                </div>
                            </form>
                        </div>

                        {{-- PASSWORD TAB --}}
                        <div class="tab-pane fade" id="accountSettings">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tab" value="password">

                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" class="form-control" placeholder="Enter current password">
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password">
                                </div>

                                <div class="text-right">
                                    <button class="btn btn-info btn-round"><i class="zmdi zmdi-lock"></i> Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- RECENT ACTIVITY --}}
                <div class="card mt-4 border-0 shadow-sm rounded-lg">
                    <div class="header px-4 pt-4">
                        <h6 class="font-weight-bold mb-0"><i class="zmdi zmdi-time text-primary"></i> Recent Activity</h6>
                    </div>
                    <div class="body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="zmdi zmdi-edit text-success"></i> Profile information updated
                                <span class="float-right text-muted small">2 hours ago</span>
                            </li>
                            <li class="mb-3">
                                <i class="zmdi zmdi-lock-outline text-warning"></i> Password changed successfully
                                <span class="float-right text-muted small">1 day ago</span>
                            </li>
                            <li>
                                <i class="zmdi zmdi-account text-info"></i> Logged in from new device
                                <span class="float-right text-muted small">3 days ago</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

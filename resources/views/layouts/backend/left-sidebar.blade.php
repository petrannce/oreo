<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" href="#dashboard"><i
                    class="zmdi zmdi-home m-r-5"></i>Oreo</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane stretchRight active" id="dashboard">
            <div class="menu">
                <ul class="list">
                    @if(Auth::check())
                        <li>
                            <div class="user-info">
                                <div class="image"><a href="profile.html"><img
                                            src="{{asset('../assets/images/profile_av.jpg')}}" alt="User"></a></div>
                                <div class="detail">
                                    <h4>{{Auth::user()->fname}} {{Auth::user()->lname}}</h4>
                                    <small>{{Auth::user()->username}}</small> | <small>{{Auth::user()->role}}</small>
                                </div>
                            </div>
                        </li>
                    @endif
                    <li class="header">DASHBOARD</li>

                    @role('admin')
                    <li class="{{ Request::route()->getName() == 'admin' ? 'active' : 'inactive' }}">
                        <a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i>
                            <span> Admin Dashboard</span></a>
                    </li>
                    @endrole

                    @role('admin|doctor')
                    <li class="{{ Request::route()->getName() == 'dashboard.doctors' ? 'active' : 'inactive' }}">
                        <a href="{{route('dashboard.doctors')}}"><i class="zmdi zmdi-accounts-alt"></i>
                            <span> Doctors Dashboard</span></a>
                    </li>
                    @endrole

                    @role('admin|receptionist')
                    <li class="{{ Request::route()->getName() == 'dashboard.receptionists' ? 'active' : 'inactive' }}">
                        <a href="{{route('dashboard.receptionists')}}"><i class="zmdi zmdi-female"></i>
                            <span>Receptionist</span></a>
                    </li>
                    @endrole

                                       @role('admin|patient')
                    <li class="{{ Request::route()->getName() == 'dashboard.patients' ? 'active' : 'inactive' }}">
                        <a href="{{route('dashboard.patients')}}"><i class="zmdi zmdi-female"></i>
                            <span>Patients</span></a>
                    </li>
                    @endrole

                    <li class="header">MAIN</li>

                    <li><a class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Appointment</span> </a>
                        <ul class="ml-menu">
                            <li
                                class="{{ Request::route()->getName() == 'appointments' ? 'active' : 'inactive' }}">
                                <a href="{{route('appointments')}}">All Appointments</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'appointments.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('appointments.create')}}">Add Appointment</a>
                            </li>
                        </ul>
                    </li>

                    @role('admin|doctor')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-calendar-check"></i><span>Services</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'services.index' ? 'active' : 'inactive' }}">
                                <a href=" {{route('services.index')}}">All Services</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'services.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('services.create')}}">Add Service</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-add"></i><span>Doctors</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'doctors.index' ? 'active' : 'inactive' }}">
                                <a href="{{route('doctors.index')}}">All Doctors</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'doctors.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('doctors.create')}}">Add Doctor</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'doctors.profile' ? 'active' : 'inactive' }}">
                                <a href="{{route('doctors.profile', Auth::user()->id)}}">Doctor Profile</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-add"></i><span>Medical Records</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'medicals' ? 'active' : 'inactive' }}">
                                <a href="{{route('medicals')}}">All Records</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'doctors.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('medicals.create')}}">Add Record</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin|receptionist')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-o"></i><span>Patients</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'patients' ? 'active' : 'inactive' }}">
                                <a href="{{route('patients')}}">All Patients</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'patient.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('patient.create')}}">Add Patient</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'patient-profile' ? 'active' : 'inactive' }}">
                                <a href="{{route('patients.show', Auth::user()->id) }}">Patient Profile</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-o"></i><span>Receptionists</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'receptionists' ? 'active' : 'inactive' }}">
                                <a href="{{route('receptionists')}}">All Receptionists</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'receptionist.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('receptionists.create')}}">Add Receptionist</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-label-alt"></i><span>Departments</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'departments' ? 'active' : 'inactive' }}">
                                <a href="{{route('departments')}}">All Departments</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'departments.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('departments.create')}}">Add Department</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-label-alt"></i><span>Resources</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'resources' ? 'active' : 'inactive' }}">
                                <a href="{{route('resources')}}">All Resources</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'resources.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('resources.create')}}">Add Resource</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li class="header">EXTRA COMPONENTS</li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-blogger"></i><span>Blog</span></a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'blogs' ? 'active' : 'inactive' }}">
                                <a href="{{route('blogs')}}">All Blogs</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'blogs.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('blogs.create')}}">New Post</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-blogger"></i><span>Tag</span></a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'tags' ? 'active' : 'inactive' }}">
                                <a href="{{route('tags')}}">All Tags</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'tags.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('tags.create')}}">New Tag</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::route()->getName() == 'faqs' ? 'active' : 'inactive' }}">
                        <a href="{{route('faqs')}}"><i class="zmdi zmdi-home"></i><span>FAQ</span></a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'galleries.index' ? 'active' : 'inactive' }}">
                        <a href="{{route('galleries.index')}}"><i class="zmdi zmdi-home"></i><span>Galleries</span>
                        </a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'subscribers' ? 'active' : 'inactive' }}">
                        <a href="{{route('subscribers')}}"><i class="zmdi zmdi-home"></i><span>Subscribers</span>
                        </a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'users' ? 'active' : 'inactive' }}">
                        <a href="{{route('users')}}"><i class="zmdi zmdi-home"></i><span>Users</span>
                        </a>
                    </li>
                    @endrole
                </ul>
            </div>
        </div>
    </div>
</aside>
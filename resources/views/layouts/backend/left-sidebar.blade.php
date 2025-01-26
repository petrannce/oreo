<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#dashboard"><i
                    class="zmdi zmdi-home m-r-5"></i>Oreo</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#user">Doctor</a></li>
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
                                    <small>{{Auth::user()->username}}</small>
                                </div>
                            </div>
                        </li>
                    @else
                        <li>
                            <div class="user-info">
                                <div class="image"><a href="profile.html"><img
                                            src="{{asset('../assets/images/profile_av.jpg')}}" alt="User"></a></div>
                                <div class="detail">
                                    <h4>Dr. Charlotte</h4>
                                    <small>Neurologist</small>
                                </div>
                            </div>
                        </li>
                    @endif
                    <li class="header">DASHBOARD</li>

                    <li class="active open">
                        <a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i>
                        <span> Admin Dashboard</span></a></li>

                    <li>
                        <a href="{{route('dashboard.doctors')}}"><i class="zmdi zmdi-accounts-alt"></i>
                        <span> Doctors Dashboard</span></a>
                    </li>

                    <li>
                        <a href="{{route('dashboard.receptionists')}}"><i class="zmdi zmdi-female"></i>
                        <span>Receptionist</span></a>
                    </li>

                    <li>
                        <a href="{{route('dashboard.patients')}}"><i class="zmdi zmdi-female"></i>
                        <span>Patients</span></a>
                    </li>

                    <li class="header">MAIN</li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-calendar-check"></i><span>Appointment</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('appointments.index')}}">All Appointments</a></li>
                            <li><a href="{{route('appointments.create')}}">Add Appointment</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-calendar-check"></i><span>Services</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('services.index')}}">All Services</a></li>
                            <li><a href="{{route('services.create')}}">Add Service</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-add"></i><span>Doctors</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('doctors.index')}}">All Doctors</a></li>
                            <li><a href="{{route('doctors.create')}}">Add Doctor</a></li>
                            <li><a href="{{route('doctors.profile', Auth::user()->id)}}">Doctor Profile</a></li>
                            <li><a href="events.html">Doctor Schedule</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-o"></i><span>Patients</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('patients')}}">All Patients</a></li>
                            <li><a href="{{route('patient.create')}}">Add Patient</a></li>
                            <li><a href="patient-profile.html">Patient Profile</a></li>
                            <li><a href="patient-invoice.html">Invoice</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-label-alt"></i><span>Departments</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('departments')}}">All Departments</a></li>
                            <li><a href="{{route('departments.create')}}">Add Department</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-label-alt"></i><span>Resources</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('resources')}}">All Resources</a></li>
                            <li><a href="{{route('resources.create')}}">Add Resource</a></li>
                        </ul>
                    </li>
                    <li class="header">EXTRA COMPONENTS</li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-blogger"></i><span>Blog</span></a>
                        <ul class="ml-menu">
                            <li><a href="blog-dashboard.html">Blog Dashboard</a></li>
                            <li><a href="{{route('blogs')}}">All Blogs</a></li>
                            <li><a href="{{route('blogs.create')}}">New Post</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-blogger"></i><span>Tag</span></a>
                        <ul class="ml-menu">
                            <li><a href="{{route('tags')}}">All Tags</a></li>
                            <li><a href="{{route('tags.create')}}">New Tag</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('faqs')}}"><i class="zmdi zmdi-home"></i><span>FAQ</span></a></li>
                    <li><a href="{{route('galleries.index')}}"><i class="zmdi zmdi-home"></i><span>Galleries</span></a>
                    </li>
                    <li><a href="{{route('subscribers')}}"><i class="zmdi zmdi-home"></i><span>Subscribers</span></a>
                    </li>
                    <li><a href="{{route('users')}}"><i class="zmdi zmdi-home"></i><span>Users</span></a></li>

                </ul>
            </div>
        </div>
        <div class="tab-pane stretchLeft" id="user">
            <div class="menu">
                <ul class="list">
                    <li>
                        <div class="user-info m-b-20 p-b-15">
                            <div class="image"><a href="profile.html"><img src="../assets/images/profile_av.jpg"
                                        alt="User"></a></div>
                            <div class="detail">
                                <h4>Dr. Charlotte</h4>
                                <small>Neurologist</small>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a title="facebook" href="#"><i class="zmdi zmdi-facebook"></i></a>
                                    <a title="twitter" href="#"><i class="zmdi zmdi-twitter"></i></a>
                                    <a title="instagram" href="#"><i class="zmdi zmdi-instagram"></i></a>
                                </div>
                                <div class="col-4 p-r-0">
                                    <h5 class="m-b-5">18</h5>
                                    <small>Exp</small>
                                </div>
                                <div class="col-4">
                                    <h5 class="m-b-5">125</h5>
                                    <small>Awards</small>
                                </div>
                                <div class="col-4 p-l-0">
                                    <h5 class="m-b-5">148</h5>
                                    <small>Clients</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <small class="text-muted">Location: </small>
                        <p>795 Folsom Ave, Suite 600 San Francisco, CADGE 94107</p>
                        <hr>
                        <small class="text-muted">Email address: </small>
                        <p>Charlotte@example.com</p>
                        <hr>
                        <small class="text-muted">Phone: </small>
                        <p>+ 202-555-0191</p>
                        <hr>
                        <small class="text-muted">Website: </small>
                        <p>dr.charlotte.com/ </p>
                        <hr>
                        <ul class="list-unstyled">
                            <li>
                                <div>Colorectal Surgery</div>
                                <div class="progress m-b-20">
                                    <div class="progress-bar l-blue " role="progressbar" aria-valuenow="89"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 89%"> <span
                                            class="sr-only">62% Complete</span> </div>
                                </div>
                            </li>
                            <li>
                                <div>Endocrinology</div>
                                <div class="progress m-b-20">
                                    <div class="progress-bar l-green " role="progressbar" aria-valuenow="56"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 56%"> <span
                                            class="sr-only">87% Complete</span> </div>
                                </div>
                            </li>
                            <li>
                                <div>Dermatology</div>
                                <div class="progress m-b-20">
                                    <div class="progress-bar l-amber" role="progressbar" aria-valuenow="78"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 78%"> <span
                                            class="sr-only">32% Complete</span> </div>
                                </div>
                            </li>
                            <li>
                                <div>Neurophysiology</div>
                                <div class="progress m-b-20">
                                    <div class="progress-bar l-blush" role="progressbar" aria-valuenow="43"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 43%"> <span
                                            class="sr-only">56% Complete</span> </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
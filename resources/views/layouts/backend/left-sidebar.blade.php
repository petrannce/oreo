<aside id="leftsidebar" class="sidebar">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" href="#dashboard"><i class="zmdi zmdi-home m-r-5"></i>Oreo</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane stretchRight active" id="dashboard">
            <div class="menu">
                <ul class="list">
                    @if(Auth::check())
                        <li>
                            <div class="user-info d-flex align-items-center">
                                <div class="image">
                                    <a href="{{ route('users.show', Auth::user()->id) }}">
                                        @php
                                            $user = Auth::user();
                                            $profileImage = $user->profile->image ?? null;
                                            $role = $user->role;

                                            // Determine image path
                                            if ($profileImage) {
                                                $imagePath = asset('storage/' . $profileImage);
                                            } else {
                                                switch ($role) {
                                                    case 'doctor':
                                                        $imagePath = asset('assets/images/profile_av.jpg');
                                                        break;
                                                    case 'patient':
                                                        $imagePath = asset('assets/images/patient.webp');
                                                        break;
                                                    case 'receptionist':
                                                        $imagePath = asset('assets/images/receptionist.png');
                                                        break;
                                                    case 'admin':
                                                        $imagePath = asset('assets/images/admin.webp');
                                                        break;
                                                    default:
                                                        $imagePath = asset('assets/images/login.jpg');
                                                        break;
                                                }
                                            }
                                        @endphp

                                        <img src="{{ $imagePath }}" alt="{{ ucfirst($role) }}" class="rounded-circle"
                                            style="width:45px; height:45px; object-fit:cover;">
                                    </a>
                                </div>

                                <div class="detail ml-3">
                                    <h4 class="mb-0">{{ $user->fname }} {{ $user->lname }}</h4>
                                    <small>{{ '@' . $user->username }}</small> |
                                    <small class="text-muted">{{ ucfirst($user->role) }}</small>
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
                        <a href="{{route('dashboard.receptionists')}}"><i class="zmdi zmdi-accounts"></i>
                            <span>Receptionist</span></a>
                    </li>
                    @endrole

                    @role('admin|patient')
                    <li class="{{ Request::route()->getName() == 'dashboard.patients' ? 'active' : 'inactive' }}">
                        <a href="{{route('dashboard.patients')}}"><i class="zmdi zmdi-file-plus"></i>
                            <span>Patients</span></a>
                    </li>
                    @endrole

                    @role('admin|nurse')
                    <li class="{{ Request::route()->getName() == 'dashboard.nurses' ? 'active' : 'inactive' }}">
                        <a href="{{route('dashboard.nurses')}}"><i class="zmdi zmdi-account-add"></i>
                            <span>Nurses</span></a>
                    </li>
                    @endrole

                    @role('admin|lab_technician')
                    <li
                        class="{{ Request::route()->getName() == 'dashboard.lab_technicians' ? 'active' : 'inactive' }}">
                        <a href="{{route('dashboard.lab_technicians')}}"><i class="zmdi zmdi-female"></i>
                            <span>Lab Technicians</span></a>
                    </li>
                    @endrole

                    @role('admin|pharmacist')
                    <li class="{{ Request::route()->getName() == 'dashboard.pharmacists' ? 'active' : 'inactive' }}">
                        <a href="{{route('dashboard.pharmacist')}}"><i class="zmdi zmdi-local-pharmacy"></i>
                            <span>Pharmacists</span></a>
                    </li>
                    @endrole

                    <li class="header">MAIN</li>

                    <li><a class="menu-toggle"><i class="zmdi zmdi-calendar"></i><span>Appointment</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'appointments' ? 'active' : 'inactive' }}">
                                <a href="{{route('appointments')}}">All Appointments</a>
                            </li>
                            @role('admin|receptionist')
                            <li
                                class="{{ Request::route()->getName() == 'appointments.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('appointments.create')}}">Add Appointment</a>
                            </li>
                            @endrole
                        </ul>
                    </li>

                    @role('admin|receptionist')

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-circle"></i><span>Patients</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'patients' ? 'active' : 'inactive' }}">
                                <a href="{{route('patients')}}">All Patients</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'patient.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('patients.create')}}">Add Patient</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin|nurse|doctor')
                    <li><a class="menu-toggle"><i class="zmdi zmdi-hospital"></i><span>Triages</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'triages' ? 'active' : 'inactive' }}">
                                <a href="{{route('triages')}}">All Triages</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-local-offer"></i><span>Services</span> </a>
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

                    @role('admin|doctor')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-file-text"></i><span>Medical Records</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'medicals' ? 'active' : 'inactive' }}">
                                <a href="{{route('medicals')}}">All Records</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin|doctor|lab_technician')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-eyedropper"></i><span>Lab
                                Tests</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'lab_tests' ? 'active' : 'inactive' }}">
                                <a href="{{route('lab_tests')}}">All Lab Tests</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-accounts-list-alt"></i><span>Departments</span> </a>
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
                                class="zmdi zmdi-folder"></i><span>Resources</span> </a>
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

                    @role('admin|pharmacist|accountant')
                    <li class="header">Billing Department</li>

                    @role('admin|pharmacist')
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-local-hospital"></i><span>Medicines</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'medicines' ? 'active' : 'inactive' }}">
                                <a href="{{route('medicines')}}">All Medicines</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'pharmacy_orders.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('medicines.create')}}">Add Medicine</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-assignment"></i><span>Pharmacy Order</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'pharmacy_orders' ? 'active' : 'inactive' }}">
                                <a href="{{route('pharmacy_orders')}}">All Pharmacy Orders</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'pharmacy_orders.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('pharmacy_orders.create')}}">Add Pharmacy Order</a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-collection-text"></i><span>Pharmacy Items</span> </a>
                        <ul class="ml-menu">
                            <li
                                class="{{ Request::route()->getName() == 'pharmacy_orders_items' ? 'active' : 'inactive' }}">
                                <a href="{{route('pharmacy_orders_items')}}">All Pharmacy Orders</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'pharmacy_orders.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('pharmacy_orders_items.create')}}">Add Pharmacy Order</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @role('admin|accountant')
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-money-box"></i><span>Billing</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'billings' ? 'active' : 'inactive' }}">
                                <a href="{{route('billings')}}">All Billings</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'billings.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('billings.create')}}">Add Billing</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    @endrole

                    @role('admin|pharmacist|lab_technician|doctor|nurse|receptionist')
                    <li class="header">All Reports</li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-o"></i><span>Reports</span> </a>
                        <ul class="ml-menu">

                            @role('admin|nurse|doctor|receptionist')

                            <li
                                class="{{ Request::route()->getName() == 'appointments.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('appointments.report')}}">All Appointments</a>
                            </li>

                            @endrole

                            @role('admin|pharmacist')

                            <li class="{{ Request::route()->getName() == 'billings.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('billings.report')}}">All Billings</a>
                            </li>

                            @endrole

                            @role('admin|doctor|lab_technician')

                            <li class="{{ Request::route()->getName() == 'lab_tests.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('lab_tests.report')}}">All Lab Tests</a>
                            </li>

                            <li class="{{ Request::route()->getName() == 'medicals.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('medicals.report')}}">All Medical Records</a>
                            </li>

                            @endrole

                            @role('admin|receptionist|nurse|doctor')

                            <li class="{{ Request::route()->getName() == 'patients.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('patients.report')}}">All Patients</a>
                            </li>

                            @endrole

                            @role('admin|pharmacist')

                            <li class="{{ Request::route()->getName() == 'medicines.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('medicines.report')}}">All Medicines</a>
                            </li>

                            @endrole

                            @role('admin|pharmacist|doctor')
                            <li
                                class="{{ Request::route()->getName() == 'pharmacy_orders.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('pharmacy_orders.report')}}">All Pharmacy Orders</a>
                            </li>

                            <li
                                class="{{ Request::route()->getName() == 'pharmacy_orders_items.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('pharmacy_orders_items.report')}}">All Pharmacy Items</a>
                            </li>

                            @endrole

                            @role('admin|doctor|lab_technician')

                            <li class="{{ Request::route()->getName() == 'triages.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('triages.report')}}">All Triages</a>
                            </li>
                            @endrole

                            @role('admin')
                            <li
                                class="{{ Request::route()->getName() == 'receptionists.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('receptionists.report')}}">All Receptionists</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'doctors.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('doctors.report')}}">All Doctors</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'nurses.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('nurses.report')}}">All Nurses</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'lab_technicians.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('lab_technicians.report')}}">All Lab technicians</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'doctors.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('departments.report')}}">All Departments</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'users.report' ? 'active' : 'inactive' }}">
                                <a href="{{route('users.report')}}">All Users</a>
                            </li>
                            @endrole

                        </ul>
                    </li>
                    @endrole

                    @role('admin')
                    <li class="header">Users</li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-hospital-alt"></i><span>Nurses</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'nurses' ? 'active' : 'inactive' }}">
                                <a href="{{route('nurses')}}">All Nurses</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'nurses.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('nurses.create')}}">Add Nurses</a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-box"></i><span>Doctors</span> </a>
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

                    @role('admin|receptionist')

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-circle"></i><span>Patients</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'patients' ? 'active' : 'inactive' }}">
                                <a href="{{route('patients')}}">All Patients</a>
                            </li>
                            <li class="{{ Request::route()->getName() == 'patient.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('patients.create')}}">Add Patient</a>
                            </li>
                        </ul>
                    </li>
                    @endrole

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-account-o"></i><span>Receptionists</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'receptionists' ? 'active' : 'inactive' }}">
                                <a href="{{route('receptionists')}}">All Receptionists</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'receptionist.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('receptionists.create')}}">Add Receptionist</a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-label-heart"></i><span>Lab
                                Technicians</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'lab_technicians' ? 'active' : 'inactive' }}">
                                <a href="{{route('lab_technicians')}}">Lab Technicians</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'lab_technicians.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('lab_technicians.create')}}">Add Lab Technician</a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-local-pharmacy"></i><span>Pharmacist</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'pharmacists' ? 'active' : 'inactive' }}">
                                <a href="{{route('pharmacists')}}">Pharmacist</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'pharmacists.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('pharmacists.create')}}">Add Pharmacist</a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-hospital"></i><span>Hospital
                                Services</span> </a>
                        <ul class="ml-menu">
                            <li
                                class="{{ Request::route()->getName() == 'hospital_services' ? 'active' : 'inactive' }}">
                                <a href="{{route('hospital_services')}}">Hospital Services</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'hospital_services.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('hospital_services.create')}}">Add Hospital Service</a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i
                                class="zmdi zmdi-city-alt"></i><span>Hospital
                                Details</span> </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::route()->getName() == 'hospital_details' ? 'active' : 'inactive' }}">
                                <a href="{{route('hospital_details')}}">Hospital Details</a>
                            </li>
                            <li
                                class="{{ Request::route()->getName() == 'hospital_details.create' ? 'active' : 'inactive' }}">
                                <a href="{{route('hospital_details.create')}}">Add Hospital Detail</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::route()->getName() == 'users' ? 'active' : 'inactive' }}">
                        <a href="{{route('users')}}"><i class="zmdi zmdi-accounts"></i><span>Users</span>
                        </a>
                    </li>

                    <li class="header">EXTRA COMPONENTS</li>

                    <li>
                        <a href="javascript:void(0);" class="menu-toggle"><i
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
                                class="zmdi zmdi-label-alt"></i><span>Tag</span></a>
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
                        <a href="{{route('faqs')}}"><i class="zmdi zmdi-help-outline"></i><span>FAQ</span></a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'galleries.index' ? 'active' : 'inactive' }}">
                        <a href="{{route('galleries.index')}}"><i class="zmdi zmdi-image"></i><span>Galleries</span>
                        </a>
                    </li>
                    <li class="{{ Request::route()->getName() == 'admin.subscribers' ? 'active' : 'inactive' }}">
                        <a href="{{route('admin.subscribers')}}"><i class="zmdi zmdi-accounts-list"></i><span>Subscribers</span>
                        </a>
                    </li>
                    @endrole

                </ul>
            </div>
        </div>
    </div>
</aside>
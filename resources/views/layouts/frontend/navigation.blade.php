<div class="main_header">
    <section id="top-nav">
        <div class="container">
            <div class="top">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="left">
                            <ul class="list-unstyled m-b-0">
                                <li><a href="#" class="btn btn-link"><i
                                            class="zmdi zmdi-email m-r-5"></i>info@okwach.com</a>
                                    <a href="#" class="btn btn-link"><i class="zmdi zmdi-phone m-r-5"></i>+
                                        254-728-745303</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="text-right d-none d-md-block">
                            <ul class="list-unstyled m-b-0">

                                <!-- Check if user is logged in -->

                                @if(Auth::check())

                                <!-- Check if user has role -->

                                    @if (Auth::user()->role == 'admin')
                                        <li>
                                            <a href="{{ route('admin') }}" class="btn btn-link" target="_blank">Admin Dashboard</a>
                                    @elseif(Auth::user()->role == 'doctor')
                                            <a href="{{ route('dashboard.doctors') }}" class="btn btn-link" target="_blank">Doctor's Dashboard</a>
                                    @elseif(Auth::user()->role == 'patient')
                                            <a href="{{ route('dashboard.patients') }}" class="btn btn-link" target="_blank">Patient's Dashboard</a>
                                    @elseif(Auth::user()->role == 'receptionist')
                                            <a href="{{ route('dashboard.receptionists') }}" class="btn btn-link" target="_blank">Receptionist's Dashboard</a>
                                    @endif

                                    <span>|</span>

                                    <!-- Logout -->

                                        <a href="{{ route('logout') }}" class="btn btn-link"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                @else

                                <!-- Sign in and Sign up -->

                                    <li>
                                        <a href="{{ route('login') }}" class="btn btn-link">Sign in</a>
                                        <a href="{{ route('register') }}" class="btn btn-link">Sign up</a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <header id="header">
        <div class="container">
            <div class="head">
                <div class="row">
                    <div class="col-lg-5 col-sm-5">
                        <div class="left">
                            <a href="{{route('home')}}" class="navbar-brand"><img src="{{asset('images/logo.svg')}}"
                                    alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-7">
                        <div class="text-right d-none d-md-block">
                            <p class="col-white m-b-0 p-t-5"><i class="zmdi zmdi-time"></i> Mon - Sat: 9:00 - 18:00
                                Sunday CLOSED </p>
                            <p class="col-white m-b-0"><i class="zmdi zmdi-pin"></i> 1422 1st St. Santa Rosa CA
                                94559. United States </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="navbar" data-aos="fade-down">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarMenu" aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMenu">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="{{route('services')}}">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('department')}}">Departments</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('doctors')}}">Doctors</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('blog')}}">Blog</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="pageMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('about')}}">About Us</a>
                                <a class="dropdown-item" href="{{route('faq')}}">FAQs</a>
                                <a class="dropdown-item" href="{{route('gallery')}}">Galary</a>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Contact Us</a></li>
                        <li class="nav-item d-md-none d-lg-none d-xl-none"><a class="nav-link"
                                href="javascript:void(0);">Sign in</a></li>
                        <li class="nav-item d-md-none d-lg-none d-xl-none"><a class="nav-link"
                                href="javascript:void(0);">Sign up</a></li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 d-none d-lg-inline-block">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
            </nav>
        </div>
    </div>
</div>
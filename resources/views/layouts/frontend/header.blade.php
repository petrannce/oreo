<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>:: Oreo Hospital :: Home</title>
    <link rel="icon" href="favicon.ico">
    <!-- start linking -->
    <link rel="stylesheet" href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/aos/aos.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/gallery.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- end linking -->
</head>

<body>

    <div id="loading" class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('images/loader.svg')}}" width="48" height="48"
                    alt="Oreo"></div>
            <p>Please wait...</p>
        </div>
    </div>

    <div class="wrapper">
        <!-- start loading -->
        @include('layouts.frontend.navigation')

        @yield('content')

        <!-- start footer -->
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form" data-aos="fade-up" data-aos-duration="3000">

                            <form action="{{route('subscriber.store')}}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group m-b-0">
                                            <input type="text" name="name" placeholder="your name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group m-b-0">
                                            <input type="text" name="email" placeholder="your email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <button type="submit"
                                            class="btn btn-primary btn-round btn-block margin-0">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-up">
                    <div class="col-lg-4 col-md-12">
                        <div class="fcard about">
                            <h5 class="title">About Hospitals</h5>
                            <p>The relentless service of Hospitals in the past 25 years taken health care to the most
                                modern
                                levels in the region catering to urban & rural.</p>
                            <p>A Health Care Provider of Western Approach, Hospitals is the most trusted multispecialty
                                hospital.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="fcard links">
                            <h5 class="title">Usefull Links</h5>
                            <div class="row">
                                <div class="col-6">
                                    <ul class="list-unstyled">
                                        <li><a href="{{route('about')}}">About Us</a></li>
                                        <li><a href="javascript:void(0);">Consultants</a></li>
                                        <li><a href="javascript:void(0);">Working Hours</a></li>
                                        <li><a href="javascript:void(0);">Procedures</a></li>
                                        <li><a href="javascript:void(0);">Special Offers</a></li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-unstyled">
                                        <li><a href="{{route('services')}}">Services</a></li>
                                        <li><a href="javascript:void(0);">Healthy Foods</a></li>
                                        <li><a href="javascript:void(0);">Latest News</a></li>
                                        <li><a href="javascript:void(0);">Certificates</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="fcard contact links">
                            <h5 class="title">Contact Details</h5>
                            <ul class="list-unstyled">
                                <li><i class="zmdi zmdi-pin"></i>Park Drive, Varick Str NY 10012, USA</li>
                                <li><i class="zmdi zmdi-email"></i>Getwell@Hospitals.com</li>
                                <li><i class="zmdi zmdi-phone"></i>(123) 0200 12345 & 7890</li>
                                <li><i class="zmdi zmdi-time"></i>Mon-Friday: 9am to 18pm</li>
                                <li><i class="zmdi zmdi-time"></i>Sat-Sunday: 10am to 16pm</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <small>Copyright &copy; {{date('Y')}} Oreo Theme by <a href="http://thememakker.com/"
                                    target="_blank">ThemeMakker</a>
                            </small>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="up"><a href="#header"><i class="zmdi zmdi-caret-up-circle"></i></a></div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="social float-md-right"><a href="#"><i class="zmdi zmdi-facebook m-r-10"></i></a>
                                <a href="#"><i class="zmdi zmdi-twitter m-r-10"></i></a> <a href="#"><i
                                        class="zmdi zmdi-dribbble m-r-10"></i></a> <a href="#"><i
                                        class="zmdi zmdi-behance m-r-10"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- start screpting -->
    <script src="{{asset('bundles/libscripts.bundle.js')}}"></script>

    <!-- my js -->
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/countto.js')}}"></script>

    <!-- JVectorMap Plugin Js -->
    <script src="{{asset('bundles/jvectormap.bundle.js')}}"></script>
    <script src="{{asset('js/jvectormap.js')}}"></script>

    <script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('js/lightbox.js')}}"></script>

</body>

</html>
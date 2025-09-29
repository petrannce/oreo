<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>:: Oreo Hospital | Dashboard ::</title>

    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/plugins/dropzone/dropzone.css')}}">
    <link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
        rel="stylesheet" />
    <link href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link rel="stylesheet" href="{{asset("assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css")}}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/blog.css')}}">

</head>

<body class="theme-cyan">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('images/loader.svg')}}" width="48"
                    height="48" alt="Oreo"></div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- Top Bar -->
    <nav class="navbar p-l-5 p-r-5">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="{{route('admin')}}"><img src="{{asset('images/loader.svg')}}"
                            width="30" alt="Oreo"><span class="m-l-10">Oreo</span></a>
                </div>
            </li>
            <li><a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a>
            </li>
            <li class="d-none d-md-inline-block">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-addon">
                        <i class="zmdi zmdi-search"></i>
                    </span>
                </div>
            </li>
            <li class="float-right">
                <a href="{{route('logout')}}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mega-menu"
                    data-close="true">
                    <i class="zmdi zmdi-power"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a href="javascript:void(0);" class="js-right-sidebar" data-close="true">
                    <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
                </a>
            </li>
        </ul>
    </nav>

    @include('layouts.backend.left-sidebar')

    @include('layouts.backend.right-sidebar')

    <!-- Chat-launcher -->
    <div class="chat-launcher"></div>
    <div class="chat-wrapper">
        <div class="card">
            <div class="header">
                <ul class="list-unstyled team-info margin-0">
                    <li class="m-r-15">
                        <h2>Dr. Team</h2>
                    </li>
                    <li>
                        <img src="../assets/images/xs/avatar2.jpg" alt="Avatar">
                    </li>
                    <li>
                        <img src="../assets/images/xs/avatar3.jpg" alt="Avatar">
                    </li>
                    <li>
                        <img src="../assets/images/xs/avatar4.jpg" alt="Avatar">
                    </li>
                    <li>
                        <img src="../assets/images/xs/avatar6.jpg" alt="Avatar">
                    </li>
                    <li>
                        <a href="javascript:void(0);" title="Add Member"><i class="zmdi zmdi-plus-circle"></i></a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="chat-widget">
                    <ul class="chat-scroll-list clearfix">
                        <li class="left float-left">
                            <img src="../assets/images/xs/avatar3.jpg" class="rounded-circle" alt="">
                            <div class="chat-info">
                                <a class="name" href="#">Alexander</a>
                                <span class="datetime">6:12</span>
                                <span class="message">Hello, John </span>
                            </div>
                        </li>
                        <li class="right">
                            <div class="chat-info"><span class="datetime">6:15</span> <span class="message">Hi,
                                    Alexander<br> How are you!</span> </div>
                        </li>
                        <li class="right">
                            <div class="chat-info"><span class="datetime">6:16</span> <span class="message">There are
                                    many variations of passages of Lorem Ipsum available</span> </div>
                        </li>
                        <li class="left float-left"> <img src="../assets/images/xs/avatar2.jpg" class="rounded-circle"
                                alt="">
                            <div class="chat-info"> <a class="name" href="#">Elizabeth</a> <span
                                    class="datetime">6:25</span> <span class="message">Hi, Alexander,<br> John <br> What
                                    are you doing?</span> </div>
                        </li>
                        <li class="left float-left"> <img src="../assets/images/xs/avatar1.jpg" class="rounded-circle"
                                alt="">
                            <div class="chat-info"> <a class="name" href="#">Michael</a> <span
                                    class="datetime">6:28</span> <span class="message">I would love to join the
                                    team.</span> </div>
                        </li>
                        <li class="right">
                            <div class="chat-info"><span class="datetime">7:02</span> <span class="message">Hello,
                                    <br>Michael</span> </div>
                        </li>
                    </ul>
                </div>
                <div class="input-group p-t-15">
                    <input type="text" class="form-control" placeholder="Enter text here...">
                    <span class="input-group-addon">
                        <i class="zmdi zmdi-mail-send"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    @yield('content')

    <!-- Jquery Core Js -->
    <script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script>
    <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script>
    <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="{{asset('assets/bundles/morrisscripts.bundle.js')}}"></script><!-- Morris Plugin Js -->
    <script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{asset('assets/bundles/knob.bundle.js')}}"></script> <!-- Jquery Knob, Count To, Sparkline Js -->

    <script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/index.js')}}"></script>

    <script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js -->
    <script
        src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <script src="{{asset('assets/plugins/dropzone/dropzone.js')}}"></script> <!-- Dropzone Plugin Js -->
    <script src="{{asset('assets/plugins/ckeditor/ckeditor.js')}}"></script> <!-- Ckeditor -->
    <script src="{{asset('assets/js/pages/forms/editors.js')}}"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>

    <script>
        $(function () {
            //Datetimepicker plugin
            $('.datetimepicker').bootstrapMaterialDatePicker({
                format: 'YYYY MM DD',
                clearButton: true,
                weekStart: 1,
                time: false
                min: date('Y-M-D')
            });

            $('.timepicker').bootstrapMaterialDatePicker({
                format: 'HH:mm', // Specify time format
                date: false // Disable date selection
            });
        });
    </script>

    <script>
        $.fn.selectpicker.Constructor.DEFAULTS.iconBase = 'zmdi';
        $.fn.selectpicker.Constructor.DEFAULTS.tickIcon = 'zmdi-check';
    </script>
</body>

</html>
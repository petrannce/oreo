@extends('layouts.backend.header')

@section('content')

<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Dashboard
                <small>Welcome to Oreo</small>
                </h2>
            </div>  
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" data-from="0" data-to="{{ $appointments->count() }}" data-speed="2500" data-fresh-interval="700">{{ $appointments->count() }} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                        <p class="text-muted">Appointments</p>
                        <div class="progress">
                            <div class="progress-bar l-blush" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                        </div>
                        <small>Change 15%</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" data-from="0" data-to="{{ $appointments->where('status', 'pending')->count() }}" data-speed="2500" data-fresh-interval="1000">{{ $appointments->where('status', 'pending')->count() }} <i class="zmdi zmdi-trending-up float-right"></i></h3>
                        <p class="text-muted">Pending Appointments</p>
                        <div class="progress">
                            <div class="progress-bar l-green" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                        </div>
                        <small>Change 23%</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="body">
                        <div class="sparkline m-b-10" data-type="bar" data-width="97%" data-height="38px" data-bar-Width="2" data-bar-Spacing="6" data-bar-Color="#555555">2,8,5,3,1,7,9,5,6,4,2,3,1,2,8,5,3,1,7,9,5,6,4,2,3,1</div>
                        <h6 class="text-center m-b-15">Total New Patient</h6>
                        <div id="world-map-markers2" style="height:125px;"></div>
                        <div class="table-responsive m-t-20">
                            <table class="table table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>City</th>                                        
                                        <th>Gender</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach ($patients as $patient)
                                     <tr>
                                        <td>{{$patient->city}}</td>
                                        <td>{{$patient->gender}}<i class="zmdi zmdi-trending-up m-l-10"></i></td>
                                    </tr> 
                                     @endforeach                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-8">
                        <div class="card top_counter">
                            <div class="body">
                                <div class="icon xl-slategray"><i class="zmdi zmdi-account"></i> </div>
                                <div class="content">
                                    <div class="text">New Patient</div>
                                    <h5 class="number">{{ $patients->count() }}</h5>
                                </div>
                            </div>                    
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card top_counter">
                            <div class="body">
                                <div class="icon xl-slategray"><i class="zmdi zmdi-account"></i> </div>
                                <div class="content">
                                    <div class="text">Doctors</div>
                                    <h5 class="number">{{ $doctors->count() }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card visitors-map">
                    <div class="header">
                        <h2><strong>Our</strong> Location <small>Contrary to popular belief, Lorem Ipsum is not simply random text</small></h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right slideUp">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div id="world-map-markers" style="height:280px;"></div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="body">
                                    <ul class="row location_list list-unstyled">
                                        <li class="col-lg-4 col-md-4 col-6">
                                            <div class="body xl-turquoise">
                                                <i class="zmdi zmdi-pin"></i>
                                                <h4 class="number count-to" data-from="0" data-to="453" data-speed="2500" data-fresh-interval="700">453</h4>
                                                <span>America</span>
                                            </div>
                                        </li>
                                        <li class="col-lg-4 col-md-4 col-6">
                                            <div class="body xl-khaki">
                                                <i class="zmdi zmdi-pin"></i>
                                                <h4 class="number count-to" data-from="0" data-to="124" data-speed="2500" data-fresh-interval="700">124</h4>
                                                <span>Australia</span>
                                            </div>
                                        </li>
                                        <li class="col-lg-4 col-md-4 col-6">
                                            <div class="body xl-parpl">
                                                <i class="zmdi zmdi-pin"></i>
                                                <h4 class="number count-to" data-from="0" data-to="215" data-speed="2500" data-fresh-interval="700">215</h4>
                                                <span>Canada</span>
                                            </div>
                                        </li>
                                        <li class="col-lg-4 col-md-4 col-6">
                                            <div class="body xl-salmon">
                                                <i class="zmdi zmdi-pin"></i>
                                                <h4 class="number count-to" data-from="0" data-to="155" data-speed="2500" data-fresh-interval="700">155</h4>
                                                <span>India</span>
                                            </div>
                                        </li>
                                        <li class="col-lg-4 col-md-4 col-6">
                                            <div class="body xl-blue">
                                                <i class="zmdi zmdi-pin"></i>
                                                <h4 class="number count-to" data-from="0" data-to="78" data-speed="2500" data-fresh-interval="700">78</h4>
                                                <span>UK</span>
                                            </div>
                                        </li>
                                        <li class="col-lg-4 col-md-4 col-6">
                                            <div class="body xl-slategray">
                                                <i class="zmdi zmdi-pin"></i>
                                                <h4 class="number count-to" data-from="0" data-to="55" data-speed="2500" data-fresh-interval="700">55</h4>
                                                <span>Other</span>
                                            </div>
                                        </li>                      
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>           
        </div>        
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Heart</strong> Surgeries <small>18% High then last month</small></h2>
                    </div>
                    <div class="body">
                        <div class="sparkline" data-type="line" data-spot-Radius="1" data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                            data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(96, 125, 139)" data-spot-Color="rgb(96, 125, 139, 0.7)"
                            data-offset="90" data-width="100%" data-height="50px" data-line-Width="1" data-line-Color="rgb(96, 125, 139, 0.7)"
                            data-fill-Color="rgba(96, 125, 139, 0.3)"> 6,4,7,8,4,3,2,2,5,6,7,4,1,5,7,9,9,8,7,6 </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Medical</strong> Treatment <small>18% High then last month</small></h2>
                    </div>
                    <div class="body">
                        <div class="sparkline" data-type="line" data-spot-Radius="1" data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                            data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(120, 184, 62)" data-spot-Color="rgb(120, 184, 62, 0.7)"
                            data-offset="90" data-width="100%" data-height="50px" data-line-Width="1" data-line-Color="rgb(120, 184, 62, 0.7)"
                            data-fill-Color="rgba(120, 184, 62, 0.3)"> 6,4,7,6,9,3,3,5,7,4,2,3,7,6 </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>New</strong> Patient <small >18% High then last month</small></h2>                        
                    </div>
                    <div class="body">                        
                        <div class="sparkline" data-type="bar" data-width="97%" data-height="50px" data-bar-Width="4" data-bar-Spacing="10" data-bar-Color="#00ced1">2,8,5,3,1,7,9,5,6,4,2,3,1</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card patient_list">
                    <div class="header">
                        <h2><strong>New</strong> Patient List</h2>                        
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right slideUp">
                                    <li><a href="javascript:void(0);">2017 Year</a></li>
                                    <li><a href="javascript:void(0);">2016 Year</a></li>
                                    <li><a href="javascript:void(0);">2015 Year</a></li>
                                </ul>
                            </li>
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Diseases</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($patients as $patient)

                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$patient->fname}} {{$patient->lname}}</td>
                                        <td>{{$patient->email}}</td>
                                        <td>{{$patient->address}} </td>
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
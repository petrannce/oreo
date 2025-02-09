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
                        <h3 class="number count-to m-b-0" data-from="0" data-to="{{ $appointments->count() }}"
                            data-speed="2500" data-fresh-interval="700">
                            {{ $appointments->count() }} <i class="zmdi zmdi-trending-up float-right"></i>
                        </h3>
                        <p class="text-muted">Appointments</p>
                        <div class="progress">
                            <div class="progress-bar l-blush" role="progressbar" style="width: 68%;"></div>
                        </div>
                        <small>Change 15%</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" data-from="0" data-to="{{ $appointments->count()}}"
                            data-speed="2500" data-fresh-interval="1000">
                            {{  $appointments->count() }} <i class="zmdi zmdi-trending-up float-right"></i>
                        </h3>
                        <p class="text-muted">Pending Appointments</p>
                        <div class="progress">
                            <div class="progress-bar l-green" role="progressbar" style="width: 68%;"></div>
                        </div>
                        <small>Change 23%</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Dr.</strong> Timeline</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="new_timeline">
                            <div class="header">
                                <div class="color-overlay">
                                    <div class="day-number">8</div>
                                    <div class="date-right">
                                        <div class="day-name">Monday</div>
                                        <div class="month">February 2018</div>
                                    </div>
                                </div>
                            </div>
                            <ul>
                                <li>
                                    <div class="bullet pink"></div>
                                    <div class="time">5pm</div>
                                    <div class="desc">
                                        <h3>New Icon</h3>
                                        <h4>Mobile App</h4>
                                    </div>
                                </li>
                                <li>
                                    <div class="bullet green"></div>
                                    <div class="time">3 - 4pm</div>
                                    <div class="desc">
                                        <h3>Design Stand Up</h3>
                                        <h4>Hangouts</h4>
                                        <ul class="list-unstyled team-info margin-0 p-t-5">
                                            <li><img src="http://via.placeholder.com/35x35" alt="Avatar"></li>
                                            <li><img src="http://via.placeholder.com/35x35" alt="Avatar"></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="bullet orange"></div>
                                    <div class="time">12pm</div>
                                    <div class="desc">
                                        <h3>Lunch Break</h3>
                                    </div>
                                </li>
                                <li>
                                    <div class="bullet green"></div>
                                    <div class="time">9 - 11am</div>
                                    <div class="desc">
                                        <h3>Finish Home Screen</h3>
                                        <h4>Web App</h4>
                                    </div>
                                </li>
                            </ul>
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
                        <div class="sparkline" data-type="line" data-spot-Radius="1"
                            data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                            data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(96, 125, 139)"
                            data-spot-Color="rgb(96, 125, 139, 0.7)" data-offset="90" data-width="100%"
                            data-height="50px" data-line-Width="1" data-line-Color="rgb(96, 125, 139, 0.7)"
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
                        <div class="sparkline" data-type="line" data-spot-Radius="1"
                            data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                            data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(120, 184, 62)"
                            data-spot-Color="rgb(120, 184, 62, 0.7)" data-offset="90" data-width="100%"
                            data-height="50px" data-line-Width="1" data-line-Color="rgb(120, 184, 62, 0.7)"
                            data-fill-Color="rgba(120, 184, 62, 0.3)"> 6,4,7,6,9,3,3,5,7,4,2,3,7,6 </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>New</strong> Patient <small>18% High then last month</small></h2>
                    </div>
                    <div class="body">
                        <div class="sparkline" data-type="bar" data-width="97%" data-height="50px" data-bar-Width="4"
                            data-bar-Spacing="10" data-bar-Color="#00ced1">2,8,5,3,1,7,9,5,6,4,2,3,1</div>
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
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle"
                                    data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i
                                        class="zmdi zmdi-more"></i> </a>
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
                                        <th></th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Diseases</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $patient)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$patient->fname}} {{$patient->lname}}</td>
                                            <td>{{$patient->address}}</td>
                                            <td>{{$patient->gender}}</td>
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
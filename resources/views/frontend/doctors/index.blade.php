@extends('layouts.frontend.header')

@section('content')

    <!-- start hero -->
    <section id="hero">
        <div class="inner-banner" style="background-image:url({{asset('images/banner-doctors.jpg')}})">
            <div class="container">
                <h3 class="title">Our <br><big><strong>Specialist</strong></big></h3>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <section class="main-section">

        <!-- Our Team -->
        <div class="our-team doctors-team">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="section-title left col-lg-4" data-aos="fade-right">
                        <h2><span>Meet </span>Our Team</h2>
                    </div>
                    <div class="section-title right col-lg-8" data-aos="fade-left">
                        <p><span class="color-212121">Oreo Hospital</span> The wise man therefore always holds in these
                            matters to this principle of selection: he rejects pleasures to secure.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="5000">
                            <div class="doctor-pic"><img src="{{asset('images/team-member-01.png')}}" alt="Dr. John"></div>
                            <div class="doctor-info">
                                <h4>Dr. John <span>Dentist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="doctors-detail.html">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="4000">
                            <div class="doctor-pic"><img src="{{asset('images/team-member-02.png')}}" alt="Dr. Amelia"></div>
                            <div class="doctor-info">
                                <h4>Dr. Amelia <span>Gynecologist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="doctors-detail.html">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="3000">
                            <div class="doctor-pic"><img src="{{asset('images/team-member-02.png')}}" alt="Dr. Jack"></div>
                            <div class="doctor-info">
                                <h4>Dr. Jack <span>Audiology</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-google-plus"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="doctors-detail.html">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="3000">
                            <div class="doctor-pic"><img src="assets/images/team-member-04.png" alt="Dr. Charlie"></div>
                            <div class="doctor-info">
                                <h4>Dr. Charlie<span>Dentist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="doctors-detail.html">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="5000">
                            <div class="doctor-pic"><img src="assets/images/team-member-05.png" alt="Dr. John"></div>
                            <div class="doctor-info">
                                <h4>Dr. Joseph <span>Dentist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="doctors-detail.html">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="4000">
                            <div class="doctor-pic"><img src="assets/images/team-member-06.png" alt="Dr. Amelia"></div>
                            <div class="doctor-info">
                                <h4>Dr. Sophie <span>Gynecologist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="doctors-detail.html">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="3000">
                            <div class="doctor-pic"><img src="assets/images/team-member-07.png" alt="Dr. Jack"></div>
                            <div class="doctor-info">
                                <h4>Dr. William <span>Audiology</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-google-plus"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="doctors-detail.html">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="3000">
                            <div class="doctor-pic"><img src="assets/images/team-member-08.png" alt="Dr. Charlie"></div>
                            <div class="doctor-info">
                                <h4>Dr. Jessica<span>Dentist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="doctors-detail.html">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Our Team -->

    </section>

@endsection
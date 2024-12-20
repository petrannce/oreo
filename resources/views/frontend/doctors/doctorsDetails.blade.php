@extends('layouts.frontend.header')

@section('content')

    <!-- start hero -->
    <section id="hero">
        <div class="inner-banner" style="background-image:url(assets/images/banner-doctors-detail.jpg)">
            <div class="container">
                <h3 class="title">Neurologist <br><big><strong>Dr. Profile</strong></big></h3>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <section class="main-section">

        <!-- Doctor Profile Section -->
        <div class="about-us-section doctor-detail-cnt">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12 clearfix">
                        <div class="float-left">
                            <h2><span>Dr. </span>Charlotte Deo</h2>
                            <p>Description text here...</p>
                        </div>
                        <div class="float-right">
                            <button class="btn btn-primary btn-round">Make Appointment</button>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-4 col-sm-6 p-r-0">
                        <div class="box-img box-shadow">
                            <img src="assets/images/doctor-detail.png" alt="">
                            <span class="section-line"></span>
                        </div>
                        <div class="opening-hours">
                            <h6><i class="zmdi zmdi-time"></i> Working Hours</h6>
                            <ul class="list-unstyled">
                                <li>
                                    <label><i class="zmdi zmdi-chevron-right"></i> Saturday</label>
                                    <span>10:00 AM - 05:00 PM</span>
                                </li>
                                <li>
                                    <label><i class="zmdi zmdi-chevron-right"></i> Sunday</label>
                                    <span>10:00 AM - 02:00 PM</span>
                                </li>
                                <li>
                                    <label><i class="zmdi zmdi-chevron-right"></i> Monday - Friday</label>
                                    <span>10:00 AM - 07:00 PM</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-6">
                        <div class="page-text">
                            <div class="doctor-detail-map m-b-10">
                                <img src="assets/images/doctor-detail-map.png" alt="">
                            </div>
                            <div class="doctor-cnt">
                                <p>
                                    <span>Location</span><br>
                                    795 Folsom Ave, Suite 600 San Francisco, CADGE 94107
                                </p>
                                <p>Dr. Charlotte Deo Leon is a neurosurgeon in East Patchogue,Contrary to popular
                                    belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical
                                    Latin literature from 45 BC, making it over 2000 years old. He received his medical
                                    degree from Harvard Medical School and has been in practice for 21 years. He is one
                                    of 5 doctors at Brookhaven Memorial Hospital Medical Center and one of 9 at
                                    Southside Hospital who specialize in Neurological Surgery.</p>
                                <p class="m-b-0 ul-title"><span>Speciality</span></p>
                                <ul class="list-unstyled">
                                    <li>Breast Surgery</li>
                                    <li>Colorectal Surgery</li>
                                    <li>Endocrinology</li>
                                    <li>Cosmetic Dermatology</li>
                                    <li>Mole checks and monitoring</li>
                                    <li>Clinical Neurophysiology</li>
                                </ul>
                                <div class="opening-hours">
                                    <h6><i class="zmdi zmdi-time"></i> Reviews</h6>
                                    <ul class="list-unstyled">
                                        <li>
                                            <label><i class="zmdi zmdi-chevron-right"></i> Staff</label>
                                            <span>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                    </span>
                                        </li>
                                        <li>
                                            <label><i class="zmdi zmdi-chevron-right"></i> Punctuality</label>
                                            <span>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                    </span>
                                        </li>
                                        <li>
                                            <label><i class="zmdi zmdi-chevron-right"></i> Helpfulness</label>
                                            <span>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                    </span>
                                        </li>
                                        <li>
                                            <label><i class="zmdi zmdi-chevron-right"></i> Knowledge</label>
                                            <span>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                    </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Doctor Profile Section -->

        <!-- Doctor Detail Fun Fact -->
        <div class="fun-fact doctor-fun-fact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-box text-center">
                            <i class="zmdi zmdi-graduation-cap"></i>
                            <span class="counter timer" data-from="0" data-to="652" data-speed="2500"
                                  data-fresh-interval="700">18</span>
                            <p>Years Of Experience</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-box text-center">
                            <i class="zmdi zmdi-star"></i>
                            <span class="counter timer" data-from="0" data-to="7652" data-speed="2500"
                                  data-fresh-interval="700">7652</span>
                            <p>Awards</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-box text-center">
                            <i class="zmdi zmdi-thumb-up"></i>
                            <span class="counter timer" data-from="0" data-to="52" data-speed="2500"
                                  data-fresh-interval="700">52</span>
                            <p>Total Oparation</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-box text-center">
                            <i class="zmdi zmdi-mood"></i>
                            <span class="counter timer" data-from="0" data-to="7652" data-speed="2500"
                                  data-fresh-interval="700">7652</span>
                            <p>Well Smiley Faces</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Doctor Detail Fun Fact -->

        <!-- Our Team -->
        <div class="our-team doctors-team">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="section-title left col-lg-4">
                        <h2><span>Related </span>Profile</h2>
                        <p>Description text here...</p>
                    </div>
                    <div class="section-title right col-lg-8">
                        <p><span class="color-212121">Oreo Hospital</span> The wise man therefore always holds in these
                            matters to this principle of selection: he rejects pleasures to secure.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center">
                            <div class="doctor-pic"><img src="assets/images/team-member-01.png" alt="Dr. John"></div>
                            <div class="doctor-info">
                                <h4>Dr. John <span>Dentist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center">
                            <div class="doctor-pic"><img src="assets/images/team-member-02.png" alt="Dr. Amelia"></div>
                            <div class="doctor-info">
                                <h4>Dr. Amelia <span>Gynecologist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center">
                            <div class="doctor-pic"><img src="assets/images/team-member-03.png" alt="Dr. Jack"></div>
                            <div class="doctor-info">
                                <h4>Dr. Jack <span>Audiology</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-google-plus"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="team-box text-center">
                            <div class="doctor-pic"><img src="assets/images/team-member-04.png" alt="Dr. Charlie"></div>
                            <div class="doctor-info">
                                <h4>Dr. Charlie<span>Dentist</span></h4>
                                <ul class="clearfix">
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                </ul>
                                <a class="btn btn-simple btn-primary btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Our Team -->

    </section>


@endsection
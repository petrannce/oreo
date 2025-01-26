@extends('layouts.frontend.header')

@section('content')

<!-- start hero -->
<section id="hero">
        <div class="slider" style="background-image:url({{asset('images/slider1.jpg')}})">
            <div class="container">
                <div class="slider_text">
                    <h3 class="title"><span>Welcome to</span> <br>
                        Oreo <strong>Hospital</strong></h3>
                    <p class="sub-title">Contrary to popular belief, Lorem Ipsum is not simply random text.</p><br>
                    <a href="{{route('about')}}" class="btn btn-primary btn-round">View More</a href="{{url('about')}}">
                </div>
                <div class="slider_form row">
                    <p class="col-12">Make an Appointment</p>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <input type="text" value="" placeholder="Enter Name" class="form-control m-b-15">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-6">
                        <div class="form-group">
                            <input type="text" value="" placeholder="Enter Mobile" class="form-control m-b-15">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-6">
                        <div class="form-group">
                            <input type="text" value="" placeholder="Enter Date" class="form-control m-b-15">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-6">
                        <select class="form-control m-b-15">
                            <option selected="selected">Select Doctor</option>
                            <option>Marc Parcival</option>
                            <option>Alen Bailey</option>
                            <option>Basil Andrew</option>
                            <option>Giles Franklin</option>
                            <option>Edgar Denzil</option>
                            <option>Garfield Feris</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6 col-6">
                        <select class="form-control">
                            <option selected="selected">Select Department</option>
                            <option>Cardiology</option>
                            <option>Pulmonology</option>
                            <option>Gynecology</option>
                            <option>Neurology</option>
                            <option>Urology</option>
                            <option>Gastrology</option>
                            <option>Pediatrician</option>
                            <option>Laboratory</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-primary btn-round btn-block m-t-0 m-b-0">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <section class="main-section">

        <!-- Home About Us Section -->
        <div class="about-us-section">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12" data-aos="fade-up">
                        <h2><span>About </span>Us</h2>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-sm-4">
                        <div class="box-img box-shadow" data-aos="fade-up">
                            <img src="{{asset('images/about-img.jpg')}}" alt="">
                            <span class="section-line" data-aos="fade-up"></span>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-8">
                        <div class="common-cnt" data-aos="fade-up">
                            <div class="section-top">
                                <p><strong>Oreo Hospital</strong> It is a long established fact that a reader will be
                                    distracted by the readable content.</p>
                            </div>
                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                                piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard
                                McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of
                                the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and goingered the
                                undoubtable source.</p>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form, by injected humour</p>
                            <p>
                                <a href="{{route('about')}}" class="btn btn-primary btn-simple btn-round margin-0" data-aos="flip-up">View More</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Home About Us Section -->

        <!-- Home About Us Section -->
        <div class="our-best-service xl-slategray section-65-100">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12" data-aos="fade-up">
                        <h2><span>Our </span>Best Services</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="service-box" data-aos="fade-up" data-aos-duration="3000">
                            <div class="service-icon"><img src="{{asset('images/icon-cardio-monitoring.png')}}" alt="Cardio Monitoring"></div>
                            <div class="service-cnt">
                                <div class="service-name">Cardio Monitoring</div>
                                <div class="service-dep">
                                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                                        in a piece[...]</p>
                                    <a href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-box" data-aos="fade-up" data-aos-duration="3000">
                            <div class="service-icon"><img src="{{asset('images/icon-orthodontics.png')}}" alt="Orthodontics">
                            </div>
                            <div class="service-cnt">
                                <div class="service-name">Orthodontics</div>
                                <div class="service-dep">
                                    <p>It has roots in a piece of classical Latin literature from 45 BC, making it over
                                        2000 years old [...]</p>
                                    <a href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-box" data-aos="fade-up"  data-aos-duration="3000">
                            <div class="service-icon"><img src="{{asset('images/icon-traumatology.png')}}" alt="Traumatology">
                            </div>
                            <div class="service-cnt">
                                <div class="service-name">Traumatology</div>
                                <div class="service-dep">
                                    <p>Contrary to popular belief,literature from 45 BC, making it over 2000 years old
                                        [...]</p>
                                    <a href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-box" data-aos="fade-up" data-aos-duration="3000">
                            <div class="service-icon"><img src="{{asset('images/icon-cardiology.png')}}" alt="Cardiology">
                            </div>
                            <div class="service-cnt">
                                <div class="service-name">Cardiology</div>
                                <div class="service-dep">
                                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                                        in a piece[...]</p>
                                    <a href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-box" data-aos="fade-up" data-aos-duration="3000">
                            <div class="service-icon"><img src="{{asset('images/icon-prostheses.png')}}" alt="Prostheses">
                            </div>
                            <div class="service-cnt">
                                <div class="service-name">Prostheses</div>
                                <div class="service-dep">
                                    <p>It has roots in a piece of classical Latin literature from 45 BC, making it over
                                        2000 years old [...]</p>
                                    <a href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-box" data-aos="fade-up" data-aos-duration="3000">
                            <div class="service-icon"><img src="{{asset('images/icon-pulmonary.png')}}" alt="Pulmonary"></div>
                            <div class="service-cnt">
                                <div class="service-name">Pulmonary</div>
                                <div class="service-dep">
                                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                                        in a piece[...]</p>
                                    <a href="javascript:void(0);">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Home About Us Section -->

        <!-- Home Fun Fact -->
        <div class="fun-fact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-box text-center">
                            <i class="zmdi zmdi-account"></i>
                            <span class="counter timer" data-from="0" data-to="652" data-speed="2500"
                                  data-fresh-interval="700">652</span>
                            <p>Happy Clients</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-box text-center">
                            <i class="zmdi zmdi-favorite"></i>
                            <span class="counter timer" data-from="0" data-to="7652" data-speed="2500"
                                  data-fresh-interval="700">7652</span>
                            <p>Heart Transplant</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="fun-fact-box text-center">
                            <i class="zmdi zmdi-thumb-up"></i>
                            <span class="counter timer" data-from="0" data-to="52" data-speed="2500"
                                  data-fresh-interval="700">52</span>
                            <p>Years Of Experience</p>
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
        <!-- Home Fun Fact -->

        <!-- Home Our Team -->
        <div class="our-team">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="section-title left col-lg-4" data-aos="fade-up">
                        <h2><span>Meet </span>Our Team</h2>
                    </div>
                    <div class="section-title right col-lg-8" data-aos="fade-up">
                        <p><span class="color-212121">Oreo Hospital</span> The wise man therefore always holds in these
                            matters to this principle of selection: he rejects pleasures to secure.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="5000">
                            <div class="doctor-pic"><img src="{{asset('images/team-member-01.png')}}" alt="Dr. John"></div>
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
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="4000">
                            <div class="doctor-pic"><img src="{{asset('images/team-member-02.png')}}" alt="Dr. Amelia"></div>
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
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="5000">
                            <div class="doctor-pic"><img src="{{asset('images/team-member-03.png')}}" alt="Dr. Jack"></div>
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
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="team-box text-center" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="3000">
                            <div class="doctor-pic"><img src="{{asset('images/team-member-04.png')}}" alt="Dr. Charlie"></div>
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
        <!-- Home Our Team -->

        <!-- Home Why choose us -->
        <div class="why-choose-us">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12" data-aos="fade-up">
                        <h2><span>Why </span>Choose Us</h2>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-lg-6 col-md-12">
                        <div class="common-cnt">
                            <div class="section-top" data-aos="fade-down">
                                <p>Our goal is to make sure<br>
                                    with advances in <br>
                                    technology</p>
                            </div>
                            <p data-aos="fade-down" data-aos-duration="3000">Professional dental clinic 32roDent offers the whole range of dentistry services:
                                treatment of caries, gum diseases, tooth whitening, implantation, dentures (crowns
                                installation), surgery, correction (braces) etc.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="box-img" data-aos="fade-up" data-aos-duration="3000">
                            <img src="{{asset('images/why-choose-img.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Home Why choose us -->

        <!-- Home Support -->
        <div class="support-home text-center xl-slategray">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>We provide 24/7 customer support.</h4>
                        <p>Please feel free to contact us at (254) 728 745303 for emergency case.</p>
                        <a class="btn btn-primary btn-simple btn-round" href="{{route('contact')}}">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Home Support -->

        <!-- Home Blog -->
        <div class="home-blog">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12" data-aos="fade-up">
                        <h2><span>Latest </span>From Blog</h2>
                    </div>
                </div>
                <div class="row" data-aos="flip-up">

                @foreach ($blogs as $blog)

                <div class="col-lg-4 col-md-6">
                        <div class="blog-box">
                            <div class="blog-img">
                                <img src="{{asset('images/blog-1.png')}}" alt="">
                            </div>
                            <div class="blog-cnt">
                                <h5><a href="javascript:void(0);">{{$blog->title}}</a></h5>
                                <p>{!!str_limit($blog->description, 100, '...')!!}</p>
                            </div>
                            <div class="blog-info">
                                <span class="blog-date"><i class="zmdi zmdi-calendar"></i> {{$blog->created_at}}</span>
                                <span class="blog-comment"><i class="zmdi zmdi-comments"></i> Comment ( 25 )</span>
                            </div>
                        </div>
                    </div>
                
                @endforeach
                    
                </div>
            </div>
        </div>
        <!-- Home Blog -->

    </section>

@endsection
@extends('layouts.frontend.header')

@section('content')

<!-- start hero -->
<section id="hero">
    <div class="inner-banner" style="background-image:url({{asset('images/banner-contactus.jpg')}})">
        <div class="container">
            <h3 class="title">Oreo <br><big><strong>Contact Us</strong></big></h3>
        </div>
    </div>
</section>

<!-- Content Area -->
<section class="main-section">

    <!-- Contact Section -->
    <div class="contact-section">
        <div class="container">
            <div class="row">
                <div class="section-title col-12" data-aos="fade-right">
                    <h2><span>Get Touch </span>With Us</h2>
                    <p>Description text here...</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <div class="contact-form">
                        <form action="{{route('contact.store')}}" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12 appoitntment-title">Make a Contact</div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-sm-12 textarea">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" placeholder="Your Message.."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="contact-sidebar">
                        <h4>Quick Contact</h4>
                        <p>If you have any questions simply use the following contact details.</p>
                        <ul class="list-unstyled add-grp">
                            <li>
                                <i class="zmdi zmdi-pin"></i>
                                <p>121, Park Drive, Varick Str<br>New York, NY 10012, USA</p>
                            </li>
                            <li>
                                <i class="zmdi zmdi-phone"></i>
                                <p>+ (123) 0200 12345,<br>+ 1800-45-678-9012</p>
                            </li>
                            <li>
                                <i class="zmdi zmdi-email"></i>
                                <p>Mailus@hospitalteam.com</p>
                            </li>
                        </ul>
                        <ul class="list-unstyled social-icon clearfix">
                            <li>
                                <a href="javascript:void(0);"><i class="zmdi zmdi-facebook-box"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><i class="zmdi zmdi-google-plus-box"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><i class="zmdi zmdi-linkedin-box"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><i class="zmdi zmdi-twitter-box"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><i class="zmdi zmdi-pinterest-box"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section -->

    <!-- Contact Map -->
    <div class="map-main">
        <img src="{{asset('assets/images/map.jpg')}}" alt="">
    </div>
    <!-- Contact Map -->


</section>


@endsection
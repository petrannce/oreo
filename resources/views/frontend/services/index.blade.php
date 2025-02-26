@extends('layouts.frontend.header')

@section('content')

<!-- start hero -->
<section id="hero">
    <div class="inner-banner" style="background-image:url({{asset('images/banner-service.jpg')}})">
        <div class="container">
            <h3 class="title">Services<br><big>Oreo <strong>Hospital</strong></big></h3>
        </div>
    </div>
</section>

<!-- Content Area -->
<section class="main-section">

    <!-- About Us Section -->
    <div class="service-section">
        <div class="container">
            <div class="row">
                <div class="section-title col-12" data-aos="fade-right">
                    <h2><span>Welcome </span>Oreo Hospital</h2>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-md-5 col-sm-12">
                    <div class="service-cnt">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="services-btn-grp">
                        <div class="find-doctor service-btn float-left">
                            <a href="{{route('doctors')}}" class="text-center">
                                <i class="zmdi zmdi-account-add"></i>
                                <h4><span>Find Search</span>A Doctor</h4>
                            </a>
                        </div>
                        <div class="book-appoitntment service-btn float-left">
                            <a href="{{route('home')}}" class="text-center">
                                <i class="zmdi zmdi-phone"></i>
                                <h4><span>Book Appointment</span>+ (254) 728 745303</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us Section -->

    <!-- Why choose us -->
    <div class="what-we-do">
        <div class="container">
            <div class="row">
                <div class="section-title col-12" data-aos="fade-right">
                    <h2><span>Why </span>Choose Us</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="what-we-box" data-aos="fade-right" data-aos-duration="5000">
                        <i class="zmdi zmdi-account-add"></i>
                        <h6>Qualified Doctors</h6>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="what-we-box" data-aos="fade-right" data-aos-duration="5000">
                        <i class="zmdi zmdi-collection-add"></i>
                        <h6>Blood Bank</h6>
                        <p>It is a long established fact that a reader will be distracted by the readable content of
                            a page when looking at</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="what-we-box" data-aos="fade-right" data-aos-duration="5000">
                        <i class="zmdi zmdi-hospital-alt"></i>
                        <h6>Modren Clinic</h6>
                        <p>How all this mistaken idea denoucing pleasure and praisings pain was born complete
                            account expound.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="what-we-box" data-aos="fade-right" data-aos-duration="5000">
                        <i class="zmdi zmdi-thumb-up"></i>
                        <h6>Emergency</h6>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                            piece of classical</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="what-we-box" data-aos="fade-right" data-aos-duration="5000">
                        <i class="zmdi zmdi-headset-mic"></i>
                        <h6>24x7 Service</h6>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="what-we-box" data-aos="fade-right" data-aos-duration="5000">
                        <i class="zmdi zmdi-shield-check"></i>
                        <h6>Health Care</h6>
                        <p>How all this mistaken idea denoucing pleasure and praisings pain was born complete
                            account expound.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Why choose us -->

    <!-- Fun Fact -->
    <div class="support-home enquiry-section xl-slategray">
        <div class="container">
            <div class="row">
                <div class="col-md-10 text-sm-center">
                    <h4>Your First Step towards Oral Health Life starts here</h4>
                </div>
                <div class="col-md-2 text-md-right text-sm-center">
                    <a class="btn btn-primary btn-round" href="{{route('contact')}}" data-aos="flip-up">Enquiry</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Fun Fact -->

    <!-- Services List -->
    <div class="department-list services-list">
        <div class="container">
            <div class="row">
                <div class="section-title col-12" data-aos="fade-right">
                    <h2><span>Most </span>Popular Services</h2>
                </div>
            </div>
            <div class="row" data-aos="flip-up">
                @foreach ($services as $service)
                    <div class="col-md-4 col-sm-6">
                        <div class="department-box box-img-cnt">
                            <div class="box-img"><img src="{{ asset('public/services/' . $service->image) }}" alt=""></div>
                            <div class="box-cnt">
                                <h4>{{$service->name}}</h4>
                                <p>{!!str_limit($service->description, 100, '...')!!}</p>
                                <a class="btn btn-primary btn-simple btn-round" href="{{route('serviceDetails', $service->id)}}">View More</a>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
    <!-- Services List -->

</section>


@endsection
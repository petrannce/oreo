@extends('layouts.frontend.header')

@section('content')

    <!-- start hero -->
    <section id="hero">
        <div class="inner-banner" style="background-image:url({{asset('images/banner-department.jpg')}})">
            <div class="container">
                <h3 class="title">Oreo Hospital<br><big><strong>Departments</strong></big></h3>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <section class="main-section">

        <!-- Departments List -->
        <div class="department-list">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="department-box box-img-cnt" data-aos="fade-up" data-aos-duration="6000">
                            <div class="box-img"><img src="assets/images/department-1.jpg" alt=""></div>
                            <div class="box-cnt">
                                <h4>CARDIOLOGY</h4>
                                <p>How all this mistaken al idea of denouncing pleasure praisings pain [...]</p>
                                <a class="btn btn-primary btn-simple btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="department-box box-img-cnt" data-aos="fade-up" data-aos-duration="5000">
                            <div class="box-img"><img src="assets/images/department-2.jpg" alt=""></div>
                            <div class="box-cnt">
                                <h4>PULMONOLOGY</h4>
                                <p>How all this mistaken al idea of denouncing pleasure praisings pain [...]</p>
                                <a class="btn btn-primary btn-simple btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="department-box box-img-cnt" data-aos="fade-up" data-aos-duration="3000">
                            <div class="box-img"><img src="assets/images/department-3.jpg" alt=""></div>
                            <div class="box-cnt">
                                <h4>GYNECOLOGY</h4>
                                <p>How all this mistaken al idea of denouncing pleasure praisings pain [...]</p>
                                <a class="btn btn-primary btn-simple btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="department-box box-img-cnt" data-aos="fade-up" data-aos-duration="4000">
                            <div class="box-img"><img src="assets/images/department-4.jpg" alt=""></div>
                            <div class="box-cnt">
                                <h4>NEUROLOGY</h4>
                                <p>How all this mistaken al idea of denouncing pleasure praisings pain [...]</p>
                                <a class="btn btn-primary btn-simple btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="department-box box-img-cnt" data-aos="fade-up" data-aos-duration="4000">
                            <div class="box-img"><img src="assets/images/department-5.jpg" alt=""></div>
                            <div class="box-cnt">
                                <h4>UROLOGY</h4>
                                <p>How all this mistaken al idea of denouncing pleasure praisings pain [...]</p>
                                <a class="btn btn-primary btn-simple btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="department-box box-img-cnt" data-aos="fade-up" data-aos-duration="3000">
                            <div class="box-img"><img src="assets/images/department-6.jpg" alt=""></div>
                            <div class="box-cnt">
                                <h4>Detal</h4>
                                <p>How all this mistaken al idea of denouncing pleasure praisings pain [...]</p>
                                <a class="btn btn-primary btn-simple btn-round" href="javascript:void(0);">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Departments List -->

        <!-- Home Why choose us -->
        <div class="why-choose-us">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12" data-aos="fade-right">
                        <h2><span>Why </span>Choose Us</h2>
                        <p>Description text here...</p>
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
                            <p>
                                <a class="btn btn-primary btn-round" data-aos="flip-up">More about practice</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="box-img" data-aos="fade-left" data-aos-duration="3000">
                            <img src="assets/images/why-choose-img.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Home Why choose us -->

        <!-- Blog -->
        <div class="home-blog">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12" data-aos="fade-right">
                        <h2><span>Latest </span>From Blog</h2>
                        <p>Description text here...</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-box">
                            <div class="blog-img">
                                <img src="assets/images/blog-1.png" alt="">
                            </div>
                            <div class="blog-cnt">
                                <h5><a href="javascript:void(0);">How to handle your kids’ from Lorem ipsum dolor sit amet</a></h5>
                                <p>The great explorer of the truth, master builder of human happiness one rejects,
                                    dislikes[...]</p>
                            </div>
                            <div class="blog-info">
                                <span class="blog-date"><i class="zmdi zmdi-calendar"></i> 02 Feb 2018</span>
                                <span class="blog-comment"><i class="zmdi zmdi-comments"></i> Comment ( 25 )</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-box">
                            <div class="blog-img">
                                <img src="assets/images/blog-2.png" alt="">
                            </div>
                            <div class="blog-cnt">
                                <h5><a href="javascript:void(0);">How to handle your kids’ from Lorem ipsum dolor sit amet</a></h5>
                                <p>The great explorer of the truth, master builder of human happiness one rejects,
                                    dislikes[...]</p>
                            </div>
                            <div class="blog-info">
                                <span class="blog-date"><i class="zmdi zmdi-calendar"></i> 02 Feb 2018</span>
                                <span class="blog-comment"><i class="zmdi zmdi-comments"></i> Comment ( 25 )</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-box">
                            <div class="blog-img">
                                <img src="assets/images/blog-3.png" alt="">
                            </div>
                            <div class="blog-cnt">
                                <h5><a href="javascript:void(0);">How to handle your kids’ from Lorem ipsum dolor sit amet</a></h5>
                                <p>The great explorer of the truth, master builder of human happiness one rejects,
                                    dislikes[...]</p>
                            </div>
                            <div class="blog-info">
                                <span class="blog-date"><i class="zmdi zmdi-calendar"></i> 02 Feb 2018</span>
                                <span class="blog-comment"><i class="zmdi zmdi-comments"></i> Comment ( 25 )</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog -->

    </section>


@endsection
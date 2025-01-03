@extends('layouts.frontend.header')

@section('content')

<!-- start hero -->
<section id="hero">
    <div class="inner-banner" style="background-image:url({{asset('images/banner-blog.jpg')}})">
        <div class="container">
            <h3 class="title">Our <br><big><strong>Blog</strong></big></h3>
        </div>
    </div>
</section>

<!-- Content Area -->
<section class="main-section blog-page">

    <!-- Blog -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 left-box">

                @foreach ($blogs as $blog)

                    <div class="card single_post" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                        <div class="body">
                            <h3 class="m-t-0 m-b-5"><a href="blog-detail.html">{{$blog->title}}</a></h3>
                            <ul class="meta">
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-account col-blue"></i>Posted By: John
                                        Smith</a></li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-label col-red"></i>{{$blog->tag}}</a>
                                </li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-comment-text col-blue"></i>Comments:
                                        3</a></li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="img-post m-b-15">
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" role="listbox">
                                        <div class="carousel-item active">
                                            <img class="d-block img-fluid" src="assets/images/blog/blog-page-1.jpg"
                                                alt="First slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block img-fluid" src="assets/images/blog/blog-page-2.jpg"
                                                alt="Second slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block img-fluid" src="assets/images/blog/blog-page-3.jpg"
                                                alt="Third slide">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                <div class="social_share">
                                    <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i
                                            class="zmdi zmdi-facebook"></i></button>
                                    <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i
                                            class="zmdi zmdi-twitter"></i></button>
                                    <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i
                                            class="zmdi zmdi-instagram"></i></button>
                                </div>
                            </div>
                            <p>{{str_limit($blog->description, 100, '...')}}</p>
                            <a href="blog-detail.html" title="read more" class="btn btn-round btn-info">Read More</a>
                        </div>
                    </div>

                @endforeach

                <ul class="pagination pagination-primary" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                    <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-12 right-box">
                <div class="card">
                    <div class="body search">
                        <div class="input-group m-b-0">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card" data-aos="fade-left" data-aos-offset="200" data-aos-duration="2000">
                    <div class="header">
                        <h2><strong>Popular</strong> Posts</h2>
                    </div>
                    <div class="body widget popular-post">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="border single_post">
                                    <div class="img-post m-b-5">
                                        <img src="assets/images/blog/blog-page-2.jpg" alt="Awesome Image">
                                    </div>
                                    <p class="m-b-0">Apple Introduces Search Ads Basic</p>
                                    <small>Dec 20, 2017</small>
                                </div>
                                <div class="border single_post m-t-20">
                                    <div class="img-post m-b-5">
                                        <img src="assets/images/blog/blog-page-3.jpg" alt="Awesome Image">
                                    </div>
                                    <p class="m-b-0">new rules, more cars, more races</p>
                                    <small>Dec 20, 2017</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" data-aos="fade-left" data-aos-offset="200" data-aos-duration="2000">
                    <div class="header">
                        <h2><strong>Tag</strong> Clouds</h2>
                    </div>
                    <div class="body widget tag-clouds">
                        <ul class="list-unstyled m-b-0">
                            <li><a href="javascript:void(0);" class="tag badge badge-default">Cardio Monitoring</a></li>
                            <li><a href="javascript:void(0);" class="tag badge badge-success">Traumatology</a></li>
                            <li><a href="javascript:void(0);" class="tag badge badge-info">Creative UX</a></li>
                            <li><a href="javascript:void(0);" class="tag badge badge-success">Pulmonary</a></li>
                            <li><a href="javascript:void(0);" class="tag badge badge-warning">Cardiology</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card" data-aos="fade-left" data-aos-offset="200" data-aos-duration="2000">
                    <div class="header">
                        <h2><strong>Instagram</strong> Post</h2>
                    </div>
                    <div class="body widget">
                        <ul class="list-unstyled instagram-plugin m-b-0">
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/05-img.jpg"
                                        alt="image description"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/06-img.jpg"
                                        alt="image description"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/07-img.jpg"
                                        alt="image description"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/08-img.jpg"
                                        alt="image description"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/09-img.jpg"
                                        alt="image description"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/10-img.jpg"
                                        alt="image description"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/11-img.jpg"
                                        alt="image description"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/12-img.jpg"
                                        alt="image description"></a></li>
                            <li><a href="javascript:void(0);"><img src="assets/images/blog/13-img.jpg"
                                        alt="image description"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card" data-aos="fade-left" data-aos-offset="200" data-aos-duration="2000">
                    <div class="header">
                        <h2><strong>Email</strong> Newsletter <small>Get our products/news earlier than others, let’s
                                get in touch.</small></h2>
                    </div>
                    <div class="body widget newsletter">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter Email">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-mail-send"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog -->

</section>


@endsection
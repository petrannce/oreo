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
                <div class="col-lg-8 col-md-12">
                    <div class="card single_post">
                        <div class="body">
                            <h3 class="m-t-0 m-b-5">{{ $blog->title }}</h3>
                            <ul class="meta">
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-account col-blue"></i>Posted By: John Smith</a></li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-label col-red"></i>Photography</a></li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-comment-text col-blue"></i>Comments: 3</a></li>
                            </ul>
                        </div>                    
                        <div class="body">
                            <div class="img-post m-b-15">
                                <img src="{{ asset('public/blogs/' . $blog->image) }}" alt="Awesome Image">
                            </div>
                            <p>{{ $blog->description }}</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2><strong>Comments</strong> 3</h2>
                        </div>
                        <div class="body">
                            <ul class="comment-reply list-unstyled">
                                <li class="row" data-aos="fade-left" data-aos-offset="100" data-aos-duration="2000">
                                    <div class="icon-box col-md-2 col-4"><img class="img-fluid img-thumbnail" src="assets/images/sm/avatar2.jpg" alt="Awesome Image"></div>
                                    <div class="text-box col-md-10 col-8 p-l-0">
                                        <h6>Gigi Hadid </h6>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
                                        <ul class="list-inline">
                                            <li><a href="javascript:void(0);">{{$blog->created_at}}</a></li>
                                            <li><a href="javascript:void(0);">Reply</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="row" data-aos="fade-left" data-aos-offset="100" data-aos-duration="2000">
                                    <div class="icon-box col-md-2 col-4"><img class="img-fluid img-thumbnail" src="assets/images/sm/avatar3.jpg" alt="Awesome Image"></div>
                                    <div class="text-box col-md-10 col-8 p-l-0">
                                        <h6>Christian Louboutin</h6>
                                        <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scramble</p>
                                        <ul class="list-inline">
                                            <li><a href="javascript:void(0);">Jan 12 2018</a></li>
                                            <li><a href="javascript:void(0);">Reply</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="row" data-aos="fade-left" data-aos-offset="100" data-aos-duration="2000">
                                    <div class="icon-box col-md-2 col-4"><img class="img-fluid img-thumbnail" src="assets/images/sm/avatar4.jpg" alt="Awesome Image"></div>
                                    <div class="text-box col-md-10 col-8 p-l-0">
                                        <h6>Kendall Jenner</h6>
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour</p>
                                        <ul class="list-inline">
                                            <li><a href="javascript:void(0);">Jan 20 2018</a></li>
                                            <li><a href="javascript:void(0);">Reply</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>                                        
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-offset="100" data-aos-duration="2000">
                        <div class="header">
                            <h2><strong>Leave</strong> a reply <small>Your email address will not be published. Required fields are marked*</small></h2>
                        </div>
                        <div class="body">
                            <div class="comment-form">
                                <form class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn btn-primary btn-round">SUBMIT</button>
                                    </div>                                
                                </form>
                            </div>
                        </div>
                    </div>
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

                                    @foreach ($blogs as $blog)

                                    <div class="border single_post">                                    
                                        <div class="img-post m-b-5">
                                            <img src="{{ asset('public/blogs/' . $blog->image) }}" alt="Awesome Image">                                        
                                        </div>
                                        <p class="m-b-0">{{ $blog->title }}</p>
                                        <small>{{ $blog->created_at}}</small>
                                    </div>
                                    
                                    @endforeach

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
                                @foreach ($tags as $tag)
                                    <li>
                                        <a href="javascript:void(0);" class="tag badge badge-default">{{$tag->name}}</a>
                                    </li>
                                
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog -->

    </section>


@endsection
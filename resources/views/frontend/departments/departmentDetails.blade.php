@extends('layouts.frontend.header')

@section('content')

    <!-- start hero -->
    <section id="hero">
        <div class="inner-banner" style="background-image:url({{asset('images/banner-blog.jpg')}})">
            <div class="container">
                <h3 class="title">Our <br><big><strong>Department</strong></big></h3>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <section class="main-section blog-page">

        <!-- department -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card single_post">
                        <div class="body">
                            <h3 class="m-t-0 m-b-5"><a href="{{route('departmentDetails', ['id' => $department->id ])}}">{{ $department->name }}</a></h3>
                            <ul class="meta">
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-account col-blue"></i>Posted By: John Smith</a></li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-label col-red"></i>Photography</a></li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-comment-text col-blue"></i>Comments: 3</a></li>
                            </ul>
                        </div>                    
                        <div class="body">
                            <div class="img-post m-b-15">
                                <img src="{{ asset('public/departments/' . $department->image) }}" alt="Awesome Image">
                                <div class="social_share">                            
                                    <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-facebook"></i></button>
                                    <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-twitter"></i></button>
                                    <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-instagram"></i></button>
                                </div>
                            </div>
                            <p>{{ $department->description }}</p>
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
                                    @foreach ($departments as $department)
                                    <div class="border single_post">                                    
                                        <div class="img-post m-b-5">
                                            <img src="{{ asset('public/departments/' . $department->image) }}" alt="Awesome Image">                                        
                                        </div>
                                        <p class="m-b-0">{{ $department->name }}</p>
                                        <small>{{ $department->created_at }}</small>
                                    </div>
                                    
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog -->

    </section>


@endsection
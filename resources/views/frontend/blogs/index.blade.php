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
                            <h3 class="m-t-0 m-b-5"><a href="{{route('blogDetails', $blog->id)}}">{{$blog->title}}</a></h3>
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
                                            <img class="d-block img-fluid" src="{{ asset('public/blogs/' . $blog->image) }}"
                                                alt="First slide">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>{{str_limit($blog->description, 100, '...')}}</p>
                            <a href="{{route('blogDetails', $blog->id)}}" title="read more" class="btn btn-round btn-info">Read More</a>
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

                            @foreach ($tags as $tag)
                                <li>
                                    <a href="javascript:void(0);" class="tag badge badge-default">{{$tag->name}}</a>
                                </li>

                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="card" data-aos="fade-left" data-aos-offset="200" data-aos-duration="2000">
                    <div class="header">
                        <h2><strong>Instagram</strong> Post</h2>
                    </div>
                    <div class="body widget">
                        <ul class="list-unstyled instagram-plugin m-b-0">

                        @foreach ($galleries as $gallery)

                        <li><a href="javascript:void(0);"><img src="{{asset('images/gallery/'.$gallery->image)}}"
                                        alt="image description"></a>
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
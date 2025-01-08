@extends('layouts.frontend.header')

@section('content')

<section id="hero">
        <div class="inner-banner" style="background-image:url({{asset('images/banner-gallery.jpg')}})">
            <div class="container">
                <h3 class="title">Oreo<br><strong>Gallery</strong></h3>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <section class="main-section">

        <!-- FAQs -->
        <div class="img-gallery">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12" data-aos="fade-right">
                        <h2><span>View</span> our best Gallery</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($galleries as $gallery)

                    <div class="col-lg-4 col-md-12">
                        <div class="popup-gallery"> <a class="popup2" href="{{asset('uploads/gallery/'.$gallery->image)}}"> <img src="{{asset('upload/gallery/'.$gallery->image)}}" alt="pic"><span class="eye-wrapper"><i class="zmdi zmdi-eye"></i></span></a> </div>
                    </div>
                    
                    @endforeach
                    
                </div>
            </div>
        </div>
        <!-- FAQs -->

    </section>


@endsection
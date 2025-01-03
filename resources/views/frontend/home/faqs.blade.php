@extends('layouts.frontend.header')

@section('content')

   <!-- start hero -->
   <section id="hero">
        <div class="inner-banner" style="background-image:url({{asset('images/banner-faqs.jpg')}})">
            <div class="container">
                <h3 class="title">Oreo<br><strong>FAQs</strong></h3>
            </div>
        </div>
    </section>

    <!-- Content Area -->
    <section class="main-section">

        <!-- FAQs -->
        <div class="faqs">
            <div class="container">
                <div class="row">
                    <div class="section-title col-12" data-aos="fade-right">
                        <h2><span>FAQs </span></h2>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12 col-lg-12">
                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                            @foreach ($faqs as $faq)

                            <div class="panel panel-primary" data-aos="fade-up" data-aos-duration="5000">
                                <div class="panel-heading" role="tab" id="headingOne_1">
                                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1"> {{$faq->question}}</a> </h4>
                                </div>
                                <div id="collapseOne_1" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne_1">
                                    <div class="panel-body">{!! $faq->answer !!}</div>
                                </div>
                            </div>
                            
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FAQs -->

    </section>


@endsection
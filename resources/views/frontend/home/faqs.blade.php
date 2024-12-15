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
                        <p>Description text here...</p>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-md-12 col-lg-12">
                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary" data-aos="fade-up" data-aos-duration="5000">
                                <div class="panel-heading" role="tab" id="headingOne_1">
                                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1"> Using This Dedicated Purpose Theme?</a> </h4>
                                </div>
                                <div id="collapseOne_1" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne_1">
                                    <div class="panel-body">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
                                </div>
                            </div>
                            <div class="panel panel-primary" data-aos="fade-up" data-aos-duration="5000">
                                <div class="panel-heading" role="tab" id="headingTwo_1">
                                    <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseTwo_1" aria-expanded="false"
                                            aria-controls="collapseTwo_1">Do You Examine Children At Your Clinic?</a> </h4>
                                </div>
                                <div id="collapseTwo_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_1">
                                    <div class="panel-body">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                        <img src="assets/images/banner-doctors-detail.jpg" class="m-t-10" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary" data-aos="fade-up" data-aos-duration="4000">
                                <div class="panel-heading" role="tab" id="headingThree_1">
                                    <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseThree_1" aria-expanded="false" aria-controls="collapseThree_1">Do You Have Imaging (X-Rays, Ultrasonography, CT-Scan) Facilities?</a> </h4>
                                </div>
                                <div id="collapseThree_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_1">
                                    <div class="panel-body">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.
                                        <blockquote>
                                            <p class="blockquote blockquote-primary m-t-15">
                                                "I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus. I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at."
                                                <br>
                                                <br>
                                                <small>
                                                    - Oreo
                                                </small>
                                            </p>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary" data-aos="fade-up" data-aos-duration="3000">
                                <div class="panel-heading" role="tab" id="headingfour_1">
                                    <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapsefour_1" aria-expanded="false" aria-controls="collapsefour_1">Do You Examine Children At Your Clinic?</a></h4>
                                </div>
                                <div id="collapsefour_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour_1">
                                    <div class="panel-body">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                        <img src="assets/images/doctor-detail-map.png" class="m-t-10" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FAQs -->

    </section>


@endsection
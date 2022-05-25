<html  >
<head>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.1/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <style >
        .shadow-effect {
            background: #fff;
            padding: 20px;
            border-radius: 4px;
            text-align: center;
            border:1px solid #ECECEC;
            box-shadow: 0 19px 38px rgba(0,0,0,0.10), 0 15px 12px rgba(0,0,0,0.02);
        }
        #customers-testimonials .shadow-effect p {
            font-family: inherit;
            font-size: 17px;
            line-height: 1.5;
            margin: 0 0 17px 0;
            font-weight: 300;
        }
        .testimonial-name {
            margin: -17px auto 0;
            display: table;
            width: auto;
            background: #e4002b;
            padding: 9px 35px;
            border-radius: 12px;
            text-align: center;
            color: #fff;
            box-shadow: 0 9px 18px rgba(0,0,0,0.12), 0 5px 7px rgba(0,0,0,0.05);
        }
        #customers-testimonials .item {
            text-align: center;
            padding: 50px;
            margin-bottom:80px;
            opacity: .2;
            -webkit-transform: scale3d(0.8, 0.8, 1);
            transform: scale3d(0.8, 0.8, 1);
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }
        #customers-testimonials .owl-item.active.center .item {
            opacity: 1;
            -webkit-transform: scale3d(1.0, 1.0, 1);
            transform: scale3d(1.0, 1.0, 1);
        }
        .owl-carousel .owl-item img {
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
            /*max-width: 90px;
            margin: 0 auto 17px;*/
        }
        #customers-testimonials.owl-carousel .owl-dots .owl-dot.active span,
        #customers-testimonials.owl-carousel .owl-dots .owl-dot:hover span {
            background: #e4002b80;
            -webkit-transform: translate3d(0px, -50%, 0px) scale(0.7);
            transform: translate3d(0px, -50%, 0px) scale(0.7);
        }
        #customers-testimonials.owl-carousel .owl-dots{
            display: inline-block;
            width: 100%;
            text-align: center;
        }
        #customers-testimonials.owl-carousel .owl-dots .owl-dot{
            display: inline-block;
        }
        #customers-testimonials.owl-carousel .owl-dots .owl-dot span {
            background: #e4002b;
            display: inline-block;
            height: 20px;
            margin: 0 2px 5px;
            -webkit-transform: translate3d(0px, -50%, 0px) scale(0.3);
            transform: translate3d(0px, -50%, 0px) scale(0.3);
            -webkit-transform-origin: 50% 50% 0;
            transform-origin: 50% 50% 0;
            -webkit-transition: all 250ms ease-out 0s;
            transition: all 250ms ease-out 0s;
            width: 20px;
        }
    </style>

</head>
<body data-gr-c-s-loaded="true">
<!-- TESTIMONIALS -->


        <div class="testimonials" style="width: 98% ">
            <div class="">

                <div class="">
                    <div class="">
                        <div id="customers-testimonials" class="owl-carousel">

                            <!--TESTIMONIAL 1 -->
                            @if(count($properties)>0)

                                @foreach($properties as $p)

                                    <div class="item" style=" ">
                                        <div class="shadow-effect">
                                            @if(count($p->images)>0)
                                                @foreach($p->images as $image)
                                                    <a
                                                        href="/properties/{{$p->id}}">
                                                        @if(pathinfo($image->url, PATHINFO_EXTENSION) ==='mp4')
                                                            <video class="d-block w-100" alt="No Image"  style="height: 200px; width: 200px;object-fit: cover;" autoplay muted
                                                                   controls>
                                                                <source
                                                                    src="{{url('/storage/properties_images/' . $image->url)}}"
                                                                    type="video/mp4">

                                                            </video>
                                                        @else
                                                            <img class="d-block w-100" style="height: 200px; width: 200px;object-fit: cover;"
                                                                 src="{{url('/storage/properties_images/' . $image->url)}}"
                                                                 alt="No Image">
                                                        @endif                                                </a>
                                                @endforeach
                                            @else

                                                <a
                                                    href="/properties/{{$p->id}}">
                                                    <img class="d-block w-100"
                                                         src="{{url('/storage/properties_images/unavailable.jpg')}}"
                                                         alt="No Image">
                                                </a>
                                            @endif
                                            <p class="price">{{ $p->locationDescription }}</p>
                                        </div>
                                        <div class="testimonial-name">
                                            @if($p->categoryId == 1)
                                                <p class="price">For Sale
                                                </p>
                                            @else
                                                <p class="price">
                                                    For Lease/Share
                                                </p>
                                            @endif
                                            {{--
                                            @if($p->showPrice == 1)
                                                <p class="price">
                                                    <i class="fa fa-usd" aria-hidden="true"></i>
                                                    {{$p->price}}
                                                </p>
                                            @else
                                                <p class="price">
                                                    Contact the agent
                                                </p>
                                            @endif
                                            --}}
                                        </div>
                                    </div>

                                @endforeach

                            @endif
                            <!--END OF TESTIMONIAL 1 -->

                        </div>
                    </div>
                </div>
            </div>
        </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.1/owl.carousel.min.js"></script>
<script >
    jQuery(document).ready(function ($) {
        "use strict";
        //  TESTIMONIALS CAROUSEL HOOK
        $('#customers-testimonials').owlCarousel({
            loop: true,
            center: true,
            items: 3,
            margin: 0,
            autoplay: true,
            dots: true,
            autoplayTimeout: 4000,
            smartSpeed: 450,
            responsive: {
                0: {
                    items: 1 },

                768: {
                    items: 2 },

                1170: {
                    items: 3 } } });



    });
    //# sourceURL=pen.js
</script>

</body></html>

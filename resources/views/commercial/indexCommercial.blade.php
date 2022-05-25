@extends('layouts.app')

@section('content')
    <div class="hero" style="height: 600px; background-image: url({{asset('/images1/buy.jpg')}});
    ">

        <div class="inner" style="color: #0a0807; text-shadow:0px 0px 10px #e4002b">

            <div class="  " style=" ">
                <div class=" ">
                    <div class="search-bar ">
                        <div class="search-form-container">
                            <form class="form" action="/search-commercials" method="GET">
                                <div class="search-bar-section">
                                    <h1>Search for a commercial user</h1>
                                </div>

                                <div class="search-bar-section">


                                    <div class="search-bar-nav ">

                                        <label for="buy"
                                               id="buy-label">Buy</label>
                                        <input type="radio" class="search-bar-nav-remove" name="category"
                                                   value="1" id="buy"
                                                   onclick="buy_clicked();" checked  >
                                    </div>
                                    <div class="search-bar-nav ">
                                            <label for="rent"
                                                   id="rent-label">Lease</label>
                                            <input type="radio" class="search-bar-nav-remove" name="category"
                                                   value="2" id="rent"
                                                   onclick="rent_clicked();">
                                    </div>
                                    <div class="search-bar-nav ">
                                            <label for="share"
                                                   id="share-label">Invest</label>
                                            <input type="radio" class="search-bar-nav-remove" name="category"
                                                   value="3" id="share"
                                                   onclick="share_clicked();"  >

                                    </div>
                                    <input type="hidden" name="category" id="categ" value="-1">



                                </div>

                                <div class="search-bar-section">

                                    <input class="location1" type="search" placeholder="Filter by Location"
                                           name="location"
                                           onFocus="initializeAutocomplete()" id="locality">


                                    <button type="submit" Class="submit btn-primary1">Search
                                    </button>
                                </div>

                                <div class="search-bar-section" style="text-align: left">
                                    <div>

                                        <select name="type">
                                            <option class="option" name="type" value=-1>Commercial Property type
                                            </option>
                                            @foreach($types as $type)
                                                <option class="option" name="type" value="{{ $type->id }}"
                                                        id="{{ $type->id }}">{{ $type->title }}</option>
                                            @endforeach
                                        </select>

                                        <select id="min-price" name="minPrice">
                                            <option class='option' name='100' value='0'>Price (min)</option>
                                            <option class='option' name='100' value='100000'>$100,000</option>
                                            <option class='option' name='100' value='150000'>$ 150,000</option>
                                            <option class='option' name='100' value='200000'>$ 200,000</option>
                                            <option class='option' name='100' value='500000'>$ 500,000</option>
                                            <option class='option' name='100' value='1000000'>$ 1,000,000</option>

                                        </select>
                                        <select id="max-price" name="maxPrice" >
                                            <option class='option' name='100' value='1000000000'>Price (max)</option>
                                            <option class='option' name='100' value='200000'>$ 200,000</option>
                                            <option class='option' name='100' value='500000'>$ 500,000</option>
                                            <option class='option' name='100' value='1000000'>$ 1,000,000</option>
                                            <option class='option' name='100' value='2500000'>$ 2,500,000</option>
                                            <option class='option' name='100' value='5000000'>$ 5,000,000</option>

                                        </select>
                                        {{--floor--}}

                                        <select id="min-floor" name="minFloor">
                                            <option class='option' name="100" value="0">Min Floor
                                            </option>
                                            <option class='option' name="100" value="50"> 50 m²
                                            </option>
                                            <option class='option' name="100" value="100"> 100 m²
                                            </option>
                                            <option class='option' name="100" value="200"> 200 m²
                                            </option>
                                            <option class='option' name="100" value="500"> 500 m²
                                            </option>
                                            <option class='option' name="100" value="1000"> 1,000 m²
                                            </option>

                                        </select>

                                        <select id="max-floor" name="maxFloor">
                                            <option class='option' name="100" value="1000000000">Max Floor
                                            </option>
                                            <option class='option' name="100" value="2000"> 2,000 m²
                                            </option>
                                            <option class='option' name="100" value="5000"> 5,000 m²
                                            </option>
                                            <option class='option' name="100" value="10000"> 10,000 m²
                                            </option>
                                            <option class='option' name="100" value="15000"> 15,000 m²
                                            </option>
                                            <option class='option' name="100" value="20000"> 20,000 m²
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="search-bar-section">

                                    <select id="sort" name="sort" style=" background-color:#e4002b;">
                                        <option value="-1">Sort By</option>
                                        <option value="updated_at">Last Updated</option>
                                        <option value="priceHighToLow">Price high to low</option>
                                        <option value="priceLowToHigh">Price low to high</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <br/>

                        <div class="container justify-content-center" style="background-color: transparent">
                            @if(!(\Illuminate\Support\Facades\Auth::guest() ))
                            <a class="btn-primary1 float-left" style="margin: 5px" href="/myCommercial">
                                My Commercial Properties
                            </a>
                            <a class="btn-primary1 new-com "  style="margin: 5px"  href="/createCommercial">
                                Add New Commercial Property
                            </a>
                        @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </div>

    <div class="main-content">

        <div class="main2">
            <div class="m-5">

                <div class="row">
                    @if(count($commercials) > 0)
                        @foreach($commercials as $com)

                            <div class="post my-5">
                                @if($com->created_at > \Carbon\Carbon::now()->subDays(14))
                                    <div class="new-prop">
                                        <img src="{{asset('/images1/flag.svg')}}"
                                             style="border: none">
                                    </div>
                                @endif
                                <div id="carouselEx" class="carousel slide carousel-fade " data-ride="carousel">
                                    <div class="carousel-inner">
                                        {{--> 0--}}
                                        @if(count($com->images)>0)
                                            @foreach($com->images as $image)
                                                <div class="carousel-item @if($loop->first) active @endif" >
                                                    @if(pathinfo($image->url, PATHINFO_EXTENSION) ==='mp4')
                                                        <video style="height: 50vw;  width: 800px;object-fit: cover;" alt="No Image"  controls>
                                                            <source
                                                                src="{{url('/storage/commercials_images/' . $image->url)}}"
                                                                type="video/mp4">

                                                        </video>
                                                    @else
                                                        <img class="d-block w-100" style="height: 50vw; width: 800px;object-fit: cover;"
                                                             src="{{url('/storage/commercials_images/' . $image->url)}}"
                                                             alt="No Image">
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <img class="d-block w-100" style="height: 125px; width: 200px;object-fit: cover;"
                                                 src="{{url('/storage/commercials_images/unavailable.jpg')}}"
                                                 alt="No Image">
                                        @endif

                                    </div>
                                    <a class="carousel-control-prev" href="#carouselEx" role="button"
                                       data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true">
                                            <i class="fa fa-chevron-left" style="color: #df0505" aria-hidden="true"></i>
                                        </span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselEx" role="button"
                                       data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true">
                                            <i class="fa fa-chevron-right" style="color: #df0505"
                                               aria-hidden="true"></i>
                                        </span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                                <a style="text-decoration: none" href="/commercial/{{$com->id}}">
                                    <div class="post-details">

                                        <p class="price">{{ $com->location}} </p>

                                        @if($com->showPrice == 1)
                                            <p class="price">
                                                <i class="fa fa-usd" aria-hidden="true"></i>
                                                {{$com->price}}
                                            </p>
                                        @else
                                            <p class="price">
                                                Contact the agent for price
                                            </p>
                                        @endif


                                        <p style="color: #0a0807;padding-left: 0.5rem;">
                                            <i class="fas fa-ruler-combined"></i> {{$com->floor}}m<sup>2</sup>
                                            | {{ \App\Models\commTypes::findOrFail($com->type)->title }}

                                        </p>

                                        {{--<a class="special-link" style="color: #0a0807;padding-left: -0.5rem;"
                                           href="/properties/{{$user->id}}">View details</a>--}}
                                    </div>
                                </a>
                            </div>

                        @endforeach

                    @else
                        <p>No commercials yet</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="main3">
            <div class="container">


            </div>

        </div>

    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
    <script>
            @if ( isset( $maxPrice ) )
        var select = document.getElementById('max-price');
        var option;
        for (var i = 0; i < select.options.length; i++) {
            option = select.options[i];
            if (option.value == "{{$maxPrice}}") {
                option.setAttribute('selected', true);
            }
        }
            @endif

            @if (isset($minPrice))
        var minSelect = document.getElementById('min-price');
        var opt;
        for (var x = 0; x < minSelect.options.length; x++) {
            opt = minSelect.options[x];
            if (opt.value == "{{$minPrice}}") {
                opt.setAttribute('selected', true);
            }
        }
        @endif

        @if (isset($minFloor))
            var minSelect = document.getElementById('min-floor');
            var opt;
            for (var x = 0; x < minSelect.options.length; x++) {
                opt = minSelect.options[x];
                if (opt.value == "{{$minFloor}}") {
                    opt.setAttribute('selected', true);
                }
            }
        @endif

        @if (isset($maxFloor))
        var minSelect = document.getElementById('max-floor');
        var opt;
        for (var x = 0; x < minSelect.options.length; x++) {
            opt = minSelect.options[x];
            if (opt.value == "{{$maxFloor}}") {
                opt.setAttribute('selected', true);
            }
        }
        @endif

        @if(isset($searched))
        document.getElementById('locality').value = "{{$searched}}";

        @endif

        $(document).ready(function () {
            $("#sort").on("change", function () {
                this.form.submit();
            });
        });

    </script>

    {{--search bar script--}}

    <script>
        @if (isset($category))
        document.getElementById("categ").value = {{$category}};
        @if($category == 1)
        buy_clicked();
            @elseif ($category == 2)
                rent_clicked();
            @else
                share_clicked();
            @endif

        @endif

        function buy_clicked(){
            document.getElementById("buy-label").style.background="#e4002b";
            document.getElementById("rent-label").style.background="#91969c";
            document.getElementById("share-label").style.background="#91969c";

            document.getElementById("min-price").style.display = "inline-block" ;
            document.getElementById("max-price").style.display = "inline-block" ;

            document.getElementById("min-price").innerHTML = "<option class='option' name='100' value='0'>Price (min)</option><option class='option' name='100' value='100000'>$100,000</option><option class='option' name='100' value='150000'>$ 150,000</option><option class='option' name='100' value='200000'>$ 200,000</option><option class='option' name='100' value='500000'>$ 500,000</option><option class='option' name='100' value='1000000'>$ 1,000,000</option>";
            document.getElementById("max-price").innerHTML = "<option class='option' name='100' value='1000000000'>Price (max)</option><option class='option' name='100' value='200000'>$ 200,000</option><option class='option' name='100' value='500000'>$ 500,000</option><option class='option' name='100' value='1000000'>$ 1,000,000</option><option class='option' name='100' value='2500000'>$ 2,500,000</option><option class='option' name='100' value='5000000'>$ 5,000,000</option>";

            document.getElementById("categ").value = 1;
        }
        function rent_clicked(){
            document.getElementById("buy-label").style.background="#91969c";
            document.getElementById("rent-label").style.background="#e4002b";
            document.getElementById("share-label").style.background="#91969c";

            document.getElementById("min-price").style.display = "inline-block" ;
            document.getElementById("max-price").style.display = "inline-block" ;
            document.getElementById("min-price").innerHTML = "<option class='option' name='100' value='0'>Price p.a. (min)</option><option class='option' name='100' value='5000'>$5,000 p.a.</option> <option class='option' name='100' value='10000'>$10,000 p.a.</option> <option class='option' name='100' value='20000'>$20,000 p.a.</option> <option class='option' name='100' value='25000'>$25,000 p.a.</option> <option class='option' name='100' value='30000'>$30,000 p.a.</option> <option class='option' name='100' value='35000'>$35,000 p.a.</option> <option class='option' name='100' value='40000'>$40,000 p.a.</option> <option class='option' name='100' value='45000'>$45,000 p.a.</option> <option class='option' name='100' value='50000'>$50,000 p.a.</option> <option class='option' name='100' value='60000'>$60,000 p.a.</option> <option class='option' name='100' value='70000'>$70,000 p.a.</option> <option class='option' name='100' value='80000'>$80,000 p.a.</option> <option class='option' name='100' value='90000'>$90,000 p.a.</option> <option class='option' name='100' value='100000'> $100,000 p.a.</option> <option class='option' name='100' value='150000'> $150,000 p.a.</option> <option class='option' name='100' value='200000'> $200,000 p.a.</option> <option class='option' name='100' value='250000'> $250,000 p.a.</option> <option class='option' name='100' value='500000'> $500,000 p.a.</option> <option class='option' name='100' value='1000000'>$1,000,000 p.a.</option> <option class='option' name='100' value='2000000'> $2,000,000 p.a.</option>";
            document.getElementById("max-price").innerHTML = "<option class='option' name='100' value='1000000000'>Price p.a. (max)</option><option class='option' name='100' value='5000'>$5,000 p.a.</option> <option class='option' name='100' value='10000'>$10,000 p.a.</option> <option class='option' name='100' value='20000'>$20,000 p.a.</option> <option class='option' name='100' value='25000'>$25,000 p.a.</option> <option class='option' name='100' value='30000'>$30,000 p.a.</option> <option class='option' name='100' value='35000'>$35,000 p.a.</option> <option class='option' name='100' value='40000'>$40,000 p.a.</option> <option class='option' name='100' value='45000'>$45,000 p.a.</option> <option class='option' name='100' value='50000'>$50,000 p.a.</option> <option class='option' name='100' value='60000'>$60,000 p.a.</option> <option class='option' name='100' value='70000'>$70,000 p.a.</option> <option class='option' name='100' value='80000'>$80,000 p.a.</option> <option class='option' name='100' value='90000'>$90,000 p.a.</option> <option class='option' name='100' value='100000'> $100,000 p.a.</option> <option class='option' name='100' value='150000'> $150,000 p.a.</option> <option class='option' name='100' value='200000'> $200,000 p.a.</option> <option class='option' name='100' value='250000'> $250,000 p.a.</option> <option class='option' name='100' value='500000'> $500,000 p.a.</option> <option class='option' name='100' value='1000000'>$1,000,000 p.a.</option> <option class='option' name='100' value='2000000'> $2,000,000 p.a.</option>";

            document.getElementById("categ").value = 2;

        }
        function share_clicked(){
            document.getElementById("buy-label").style.background="#91969c";

            document.getElementById("rent-label").style.background="#91969c";
            document.getElementById("share-label").style.background="#e4002b";
            document.getElementById("min-price").style.display = "none" ;
            document.getElementById("max-price").style.display = "none" ;
            document.getElementById("categ").value = 3;
        }
    </script>

    {{--scripts for google locations--}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1CbPQ2HCLV38r9m68B8VCv51JBVke5TM&callback=initAutocomplete&libraries=places&v=weekly"
        defer
    ></script>
    <script type="text/javascript">
        function initializeAutocomplete() {
            var input = document.getElementById('locality');
            // var options = {
            //   types: ['(regions)'],
            //   componentRestrictions: {country: "IN"}
            // };
            var options = {}

            var autocomplete = new google.maps.places.Autocomplete(input, options);

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                var placeId = place.place_id;
                // to set city name, using the locality param
                var componentForm = {
                    locality: 'short_name',
                };
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById("city").value = val;
                    }
                }
            });
        }
    </script>
@endsection

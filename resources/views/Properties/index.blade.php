@extends('layouts.app')

@section('content')
    <div class="hero" style=" background-image: url({{asset('/images1/buy.jpg')}});
        ">
        <div class="inner">

            <div class="search-bar ">
                <div class="search-form-container">
                    <form class="form " action="/search-properties" method="GET">
                        <div class="search-bar-section">
                            <h1>Search for a property</h1>

                        </div>

                        <div class="search-bar-section">

                            @foreach($categories as $c)
                                <div class="search-bar-nav ">
                                    {{--                                                        @if($c->id == $category)<script> {{  Str::lower($c->title) }}_clicked(); </script> @endif--}}
                                    {{--                                                        @if($c->id == $category)<script> share_clicked(); </script> @endif--}}
                                    <label for="{{ $c->id }}"
                                           id="{{  Str::lower($c->title) }}-label">{{ $c->title }}</label>
                                    <input type="radio" class="search-bar-nav-remove"
                                           name="category" value="{{$c->id}}" id="{{ $c->id }}"
                                           onclick="{{  Str::lower($c->title) }}_clicked();">

                                </div>
                            @endforeach
                            {{--                            <div class="search-bar-nav ">--}}

                            {{--                                <label for="1" id="buy-label"> Buy</label>--}}
                            {{--                                <input type="radio" class="search-bar-nav-remove" name="category" value="1" id="1"   onclick="buy_clicked();" checked >--}}

                            {{--                            </div>--}}
                            {{--                            <div class="search-bar-nav ">--}}

                            {{--                                <label for="2" id="rent-label"> Rent</label>--}}
                            {{--                                <input type="radio" class="search-bar-nav-remove" name="category" value="2"  id="2" onclick="rent_clicked();"  >--}}

                            {{--                            </div>--}}
                            {{--                            <div class="search-bar-nav ">--}}

                            {{--                                <label for="3" id="share-label"> Share</label>--}}
                            {{--                                <input type="radio" class="search-bar-nav-remove" name="category" value="3"  id="3" onclick="share_clicked();"  >--}}

                            {{--                            </div>--}}

                        </div>

                        <div class="search-bar-section">
                            {{--<input class="location1" type="search" name="location"
                                    hint="Search by location" placeholder="Search by location">--}}
                            <input class="location1" type="search" placeholder="Filter by Location"
                                   {{--name="address"--}} name="location"
                                   onFocus="initializeAutocomplete()" id="locality">


                            <button type="submit" class="submit btn-primary1">Search
                            </button>
                        </div>

                        <div class="search-bar-section">
                            <div>

                                <select name="type">
                                    <option class="option" name="type" value=-1>Property type</option>
                                    @foreach($types as $type)
                                        <option class="option" name="type" value="{{ $type->id }}"
                                                id="{{ $type->id }}">{{ $type->title }}</option>

                                    @endforeach
                                </select>


                                <select name="bedroomsNumber" id="bedroomsSelect">
                                    <option class="option" value="-1">Beds</option>
                                    <option class="option" value="1">1</option>
                                    <option class="option" value="2">2</option>
                                    <option class="option" value="3">3</option>
                                    <option class="option" value="4">4</option>
                                    <option class="option" value="5">5+</option>
                                </select>
                                <select id="min-price" name="minPrice">

                                    <option class="option" name="100" value="0">Price (min)</option>
                                    <option class="option" name="100" value="50000">$50,000</option>
                                    <option class="option" name="100" value="100000">$ 100,000</option>
                                    <option class="option" name="100" value="200000">$ 200,000</option>
                                    <option class="option" name="100" value="300000">$ 300,000</option>
                                    <option class="option" name="100" value="400000">$ 400,000</option>
                                    <option class="option" name="100" value="500000">$ 500,000</option>
                                    <option class="option" name="100" value="600000">$ 600,000</option>
                                    <option class="option" name="100" value="700000">$ 700,000</option>
                                    <option class="option" name="100" value="800000">$ 800,000</option>
                                    <option class="option" name="100" value="900000">$ 900,000</option>
                                    <option class="option" name="100" value="1000000">$ 1,000,000</option>
                                    <option class="option" name="100" value="1100000">$ 1,100,000</option>
                                    <option class="option" name="100" value="1200000">$ 1,200,000</option>
                                    <option class="option" name="100" value="1300000">$ 1,300,000</option>
                                    <option class="option" name="100" value="1400000">$ 1,400,000</option>
                                    <option class="option" name="100" value="1500000">$ 1,500,000</option>
                                    <option class="option" name="100" value="1600000">$ 1,600,000</option>
                                    <option class="option" name="100" value="1700000">$ 1,700,000</option>
                                    <option class="option" name="100" value="1800000">$ 1,800,000</option>
                                    <option class="option" name="100" value="1900000">$ 1,900,000</option>
                                    <option class="option" name="100" value="2000000">$ 2,000,000</option>

                                </select>
                                <select id="max-price" name="maxPrice">
                                    <option class='option' name="100" value="1000000000">Price (max)
                                    </option>
                                    <option class='option' name="100" value="100000">$ 100,000 </option>
                                    <option class='option' name="100" value="200000">$ 200,000 </option>
                                    <option class='option' name="100" value="300000">$ 300,000 </option>
                                    <option class='option' name="100" value="400000">$ 400,000 </option>
                                    <option class='option' name="100" value="500000">$ 500,000 </option>
                                    <option class='option' name="100" value="600000">$ 600,000 </option>
                                    <option class='option' name="100" value="700000">$ 700,000 </option>
                                    <option class='option' name="100" value="800000">$ 800,000 </option>
                                    <option class='option' name="100" value="900000">$ 900,000 </option>
                                    <option class='option' name="100" value="1000000">$ 1,000,000 </option>
                                    <option class="option" name="100" value="1100000">$ 1,100,000</option>
                                    <option class="option" name="100" value="1200000">$ 1,200,000</option>
                                    <option class="option" name="100" value="1300000">$ 1,300,000</option>
                                    <option class="option" name="100" value="1400000">$ 1,400,000</option>
                                    <option class="option" name="100" value="1500000">$ 1,500,000</option>
                                    <option class="option" name="100" value="1600000">$ 1,600,000</option>
                                    <option class="option" name="100" value="1700000">$ 1,700,000</option>
                                    <option class="option" name="100" value="1800000">$ 1,800,000</option>
                                    <option class="option" name="100" value="1900000">$ 1,900,000</option>
                                    <option class="option" name="100" value="2000000">$ 2,000,000</option>
                                    <option class="option" name="100" value="2100000">$ 2,100,000</option>
                                    <option class="option" name="100" value="2200000">$ 2,200,000</option>
                                    <option class="option" name="100" value="2300000">$ 2,300,000</option>
                                    <option class="option" name="100" value="2400000">$ 2,400,000</option>
                                    <option class="option" name="100" value="2500000">$ 2,500,000</option>
                                    <option class="option" name="100" value="2600000">$ 2,600,000</option>
                                    <option class="option" name="100" value="2700000">$ 2,700,000</option>
                                    <option class="option" name="100" value="2800000">$ 2,800,000</option>
                                    <option class="option" name="100" value="2900000">$ 2,900,000</option>
                                    <option class="option" name="100" value="3000000">$ 3,000,000</option>
                                    <option class="option" name="100" value="3100000">$ 3,100,000</option>
                                    <option class="option" name="100" value="3200000">$ 3,200,000</option>
                                    <option class="option" name="100" value="3300000">$ 3,300,000</option>
                                    <option class="option" name="100" value="3400000">$ 3,400,000</option>
                                    <option class="option" name="100" value="3500000">$ 3,500,000</option>
                                    <option class="option" name="100" value="3600000">$ 3,600,000</option>
                                    <option class="option" name="100" value="3700000">$ 3,700,000</option>
                                    <option class="option" name="100" value="3800000">$ 3,800,000</option>
                                    <option class="option" name="100" value="3900000">$ 3,900,000</option>
                                    <option class="option" name="100" value="4000000">$ 4,000,000</option>
                                    <option class="option" name="100" value="4100000">$ 4,100,000</option>
                                    <option class="option" name="100" value="4200000">$ 4,200,000</option>
                                    <option class="option" name="100" value="4300000">$ 4,300,000</option>
                                    <option class="option" name="100" value="4400000">$ 4,400,000</option>
                                    <option class="option" name="100" value="4500000">$ 4,500,000</option>
                                    <option class="option" name="100" value="4600000">$ 4,600,000</option>
                                    <option class="option" name="100" value="4700000">$ 4,700,000</option>
                                    <option class="option" name="100" value="4800000">$ 4,800,000</option>
                                    <option class="option" name="100" value="4900000">$ 4,900,000</option>
                                    <option class='option' name="100" value="5000000">$ 5,000,000 </option>

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

            </div>


        </div>
    </div>

    <div class="main-content">

        <div class="main2">
            <div class="m-5">

                @if(count($properties)>0)
                    @if (Request::is('properties/rent'))
                        <h2>Properties for rent</h2>
                        <form action="/properties/rent">
                            <div class="search-bar-section">

                                <select id="sort" name="sort" style=" background-color:#e4002b;">
                                    <option value="-1">Sort By</option>
                                    <option value="updated_at">Last Updated</option>
                                    <option value="priceHighToLow">Price high to low</option>
                                    <option value="priceLowToHigh">Price low to high</option>
                                </select>
                            </div>
                        </form>
                    @endif
                    @if (Request::is('properties/buy'))
                        <h2>Properties for sale</h2>
                        <form action="/properties/buy">
                            <div class="search-bar-section">

                                <select id="sort" name="sort" style=" background-color:#e4002b;">
                                    <option value="-1">Sort By</option>
                                    <option value="updated_at">Last Updated</option>
                                    <option value="priceHighToLow">Price high to low</option>
                                    <option value="priceLowToHigh">Price low to high</option>
                                </select>
                            </div>
                        </form>
                    @endif
                    @if (isset($type))
                        @if($type == "properties")

                            <div class="m-2 p-2">
                                <H3>Results for '{{ $searched ?? '' }}':</H3>
                                <h4>{{ count($properties) }} results found !</h4>
                            </div>
                        @endif
                    @endif




                    @foreach($properties as $property)
                        <div class="post my-5">
                            @if($property->created_at > \Carbon\Carbon::now()->subDays(14))
                                <div class="new-prop">
                                    <img src="{{asset('/images1/flag.svg')}}"
                                         style="border: none">
                                </div>
                            @endif
                            <div id="carouselEx" class="carousel slide carousel-fade " data-ride="carousel">
                                <div class="carousel-inner">
                                    @if(count($property->images)>0)
                                        @foreach($property->images as $image)
                                            <div class="carousel-item @if($loop->first) active @endif">
                                                @if(pathinfo($image->url, PATHINFO_EXTENSION) ==='mp4')
                                                    <video class="d-block w-100"
                                                           style="height: 50vw; width: 800px;object-fit: cover;"
                                                           alt="No Image" controls>
                                                        <source
                                                            src="{{url('/storage/properties_images/' . $image->url)}}"
                                                            type="video/mp4">

                                                    </video>
                                                @else
                                                    <img class="d-block w-100"
                                                         style="height: 50vw; width: 800px;object-fit: cover;"
                                                         src="{{url('/storage/properties_images/' . $image->url)}}"
                                                         alt="No Image">
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <img class="d-block w-100" style="height: 50vw; width: 800px;object-fit: cover;"
                                             src="{{url('/storage/properties_images/unavailable.jpg')}}"
                                             alt="No Image">
                                    @endif
                                    @if($property->sold == 1 )<p class="sold">SOLD</p>@endif
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
                                <i class="fa fa-chevron-right" style="color: #df0505" aria-hidden="true"></i>
                            </span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                            <a style="text-decoration: none" href="/properties/{{$property->id}}">
                                <div class="post-details">

                                    <p class="price">{{ $property->locationDescription }} </p>

                                    @if($property->showPrice == 1)
                                        <p class="price">
                                            <i class="fa fa-usd" aria-hidden="true"></i>
                                            {{$property->price}}
                                        </p>
                                    @else
                                        <p class="price">
                                            Contact the agent for price
                                        </p>
                                    @endif


                                    <p style="color: #0a0807;padding-left: 0.5rem;">
                                        {{$property->bedroomsNumber}} <i class="fa fa-bed" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
                                        {{$property->bathroomsNumber}} <i class="fa fa-bath" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
                                        {{$property->parkingNumber}} <i class="fa fa-car" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
                                        | {{ \App\Models\PropertyType::findOrFail($property->typeId)->title }}
                                    </p>

                                    {{--<a class="special-link" style="color: #0a0807;padding-left: -0.5rem;"
                                       href="/properties/{{$property->id}}">View details</a>--}}
                                </div>
                            </a>
                        </div>

                    @endforeach
                @else
                    @if (Request::is('properties/rent'))
                        <h3 class="bg-white p-3">No properties found!</h3>
                    @else
                        <h3 class="bg-white p-3">No properties found!</h3>
                    @endif
                @endif
            </div>

        </div>

        <div class="main3">
            <div class="container">


            </div>

        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
    <script>
        {{--$("#{{ $maxPrice }}").addClass("selected");--}}
        {{--        $('#maxPriceSelect').val({{$maxPrice}})--}}
        {{--document.getElementById('location').value = '{{ $searched ?? '' }}';--}}

        @if(isset($categories))
        @foreach($categories as $c)
        @if(isset($category))
        @if($category == $c->id) {{Str::lower($c->title)}}_clicked();
        @endif
        @endif
        @endforeach
        @endif
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
        @if (isset(  $bedroomsNumber  ))
        var bedroomsSelect = document.getElementById('bedroomsSelect');
        var num;
        for (var i = 0; i < bedroomsSelect.options.length; i++) {
            num = bedroomsSelect.options[i];
            if (num.value == "{{ $bedroomsNumber }}") {
                num.setAttribute('selected', true);
            }
        }

        @endif

        @if(isset($searched))
            document.getElementById('locality').value = "{{$searched}}";
        @endif


        function buy_clicked() {
            document.getElementById("buy-label").style.background = "#e4002b";
            document.getElementById("rent-label").style.background = "#91969c";
            document.getElementById("share-label").style.background = "#91969c";
            document.getElementById(1).checked = true;
            document.getElementById("min-price").innerHTML = "<option class='option' name='100' value='0'>Price (min)</option><option class='option' name='100' value='50000'>$50,000</option> <option class='option' name='100' value='100000'>$ 100,000</option> <option class='option' name='100' value='200000'>$ 200,000</option><option class='option' name='100' value='300000'>$ 300,000</option> <option class='option' name='100' value='400000'>$ 400,000</option><option class='option' name='100' value='500000'>$ 500,000</option> <option class='option' name='100' value='600000'>$ 600,000</option><option class='option' name='100' value='700000'>$ 700,000</option><option class='option' name='100' value='800000'>$ 800,000</option><option class='option' name='100' value='900000'>$ 900,000</option><option class='option' name='100' value='1000000'>$ 1,000,000</option><option class='option' name='100' value='1100000'>$ 1,100,000</option><option class='option' name='100' value='1200000'>$ 1,200,000</option><option class='option' name='100' value='1300000'>$ 1,300,000</option><option class='option' name='100' value='1400000'>$ 1,400,000</option><option class='option' name='100' value='1500000'>$ 1,500,000</option><option class='option' name='100' value='1600000'>$ 1,600,000</option><option class='option' name='100' value='1700000'>$ 1,700,000</option><option class='option' name='100' value='1800000'>$ 1,800,000</option><option class='option' name='100' value='1900000'>$ 1,900,000</option><option class='option' name='100' value='2000000'>$ 2,000,000</option>";
            document.getElementById("max-price").innerHTML = "<option class='option' name='100' value='1000000000'>Price (max)</option><option class='option' name='100' value='100000'>$ 100,000 </option> <option class='option' name='100' value='200000'>$ 200,000 </option><option class='option' name='100' value='300000'>$ 300,000 </option> <option class='option' name='100' value='400000'>$ 400,000 </option><option class='option' name='100' value='500000'>$ 500,000 </option> <option class='option' name='100' value='600000'>$ 600,000 </option><option class='option' name='100' value='700000'>$ 700,000 </option><option class='option' name='100' value='800000'>$ 800,000 </option><option class='option' name='100' value='900000'>$ 900,000 </option><option class='option' name='100' value='1000000'>$ 1,000,000 </option><option class='option' name='100' value='1100000'>$ 1,100,000</option><option class='option' name='100' value='1200000'>$ 1,200,000</option><option class='option' name='100' value='1300000'>$ 1,300,000</option><option class='option' name='100' value='1400000'>$ 1,400,000</option><option class='option' name='100' value='1500000'>$ 1,500,000</option><option class='option' name='100' value='1600000'>$ 1,600,000</option><option class='option' name='100' value='1700000'>$ 1,700,000</option><option class='option' name='100' value='1800000'>$ 1,800,000</option><option class='option' name='100' value='1900000'>$ 1,900,000</option><option class='option' name='100' value='2000000'>$ 2,000,000</option><option class='option' name='100' value='2100000'>$ 2,100,000</option><option class='option' name='100' value='2200000'>$ 2,200,000</option><option class='option' name='100' value='2300000'>$ 2,300,000</option><option class='option' name='100' value='2400000'>$ 2,400,000</option><option class='option' name='100' value='2500000'>$ 2,500,000</option><option class='option' name='100' value='2600000'>$ 2,600,000</option><option class='option' name='100' value='2700000'>$ 2,700,000</option><option class='option' name='100' value='2800000'>$ 2,800,000</option><option class='option' name='100' value='2900000'>$ 2,900,000</option><option class='option' name='100' value='3000000'>$ 3,000,000</option><option class='option' name='100' value='3100000'>$ 3,100,000</option><option class='option' name='100' value='3200000'>$ 3,200,000</option><option class='option' name='100' value='3300000'>$ 3,300,000</option><option class='option' name='100' value='3400000'>$ 3,400,000</option><option class='option' name='100' value='3500000'>$ 3,500,000</option><option class='option' name='100' value='3600000'>$ 3,600,000</option><option class='option' name='100' value='3700000'>$ 3,700,000</option><option class='option' name='100' value='3800000'>$ 3,800,000</option><option class='option' name='100' value='3900000'>$ 3,900,000</option><option class='option' name='100' value='4000000'>$ 4,000,000</option><option class='option' name='100' value='4100000'>$ 4,100,000</option><option class='option' name='100' value='4200000'>$ 4,200,000</option><option class='option' name='100' value='4300000'>$ 4,300,000</option><option class='option' name='100' value='4400000'>$ 4,400,000</option><option class='option' name='100' value='4500000'>$ 4,500,000</option><option class='option' name='100' value='4600000'>$ 4,600,000</option><option class='option' name='100' value='4700000'>$ 4,700,000</option><option class='option' name='100' value='4800000'>$ 4,800,000</option><option class='option' name='100' value='4900000'>$ 4,900,000</option><option class='option' name='100' value='5000000'>$ 5,000,000 </option>";
        }

        function rent_clicked() {
            document.getElementById("buy-label").style.background = "#91969c";
            document.getElementById("rent-label").style.background = "#e4002b";
            document.getElementById("share-label").style.background = "#91969c";
            document.getElementById("min-price").innerHTML = "<option class='option' name='100' value='0'>Price pw (min)</option><option class='option' name='100' value='50'>$50pw</option></option><option class='option' name='100' value='75'>$75pw</option></option><option class='option' name='100' value='100'>$100pw</option><option class='option' name='100' value='125'>$125pw</option><option class='option' name='100' value='150'>$150pw</option><option class='option' name='100' value='175'>$175pw</option><option class='option' name='100' value='200'>$200pw</option><option class='option' name='100' value='225'>$225pw</option><option class='option' name='100' value='250'>$250pw</option><option class='option' name='100' value='275'>$275pw</option><option class='option' name='100' value='300'>$300pw</option><option class='option' name='100' value='325'>$325pw</option><option class='option' name='100' value='350'>$350pw</option><option class='option' name='100' value='375'>$375pw</option><option class='option' name='100' value='400'>$400pw</option><option class='option' name='100' value='425'>$425pw</option><option class='option' name='100' value='450'>$450pw</option><option class='option' name='100' value='475'>$475pw</option><option class='option' name='100' value='500'>$500pw</option><option class='option' name='100' value='525'>$525pw</option><option class='option' name='100' value='550'>$550pw</option><option class='option' name='100' value='575'>$575pw</option><option class='option' name='100' value='600'>$600pw</option><option class='option' name='100' value='625'>$625pw</option><option class='option' name='100' value='650'>$650pw</option><option class='option' name='100' value='675'>$675pw</option><option class='option' name='100' value='700'>$700pw</option><option class='option' name='100' value='725'>$725pw</option><option class='option' name='100' value='750'>$750pw</option><option class='option' name='100' value='800'>$800pw</option><option class='option' name='100' value=''>$<option class='option' name='100' value=''>$<option class='option' name='100' value='950'>$950pw</option><option class='option' name='100' value='1000'>$1,000pw</option><option class='option' name='100' value='1100'>$1,100pw</option><option class='option' name='100' value='1200'>$1,200pw</option><option class='option' name='100' value='1300'>$1,300pw</option><option class='option' name='100' value='1400'>$1,400pw</option><option class='option' name='100' value='1500'>$1,500pw</option><option class='option' name='100' value='1600'>$1,600pw</option><option class='option' name='100' value='1700'>$1,700pw</option><option class='option' name='100' value='1800'>$1,800pw</option><option class='option' name='100' value='1900'>$1,900pw</option><option class='option' name='100' value='2000'>$2,000pw</option><option class='option' name='100' value='2500'>$2,500pw</option><option class='option' name='100' value='3000'>$3,000pw</option><option class='option' name='100' value='3500'>$3,500pw</option><option class='option' name='100' value='4000'>$4,000pw</option><option class='option' name='100' value='4500'>$4,500pw</option><option class='option' name='100' value='5000'>$5,000pw</option>";
            document.getElementById("max-price").innerHTML = "<option class='option' name='100' value='1000000000'>Price pw (max)</option><option class='option' name='100' value='50'>$50pw</option></option><option class='option' name='100' value='75'>$75pw</option></option><option class='option' name='100' value='100'>$100pw</option><option class='option' name='100' value='125'>$125pw</option><option class='option' name='100' value='150'>$150pw</option><option class='option' name='100' value='175'>$175pw</option><option class='option' name='100' value='200'>$200pw</option><option class='option' name='100' value='225'>$225pw</option><option class='option' name='100' value='250'>$250pw</option><option class='option' name='100' value='275'>$275pw</option><option class='option' name='100' value='300'>$300pw</option><option class='option' name='100' value='325'>$325pw</option><option class='option' name='100' value='350'>$350pw</option><option class='option' name='100' value='375'>$375pw</option><option class='option' name='100' value='400'>$400pw</option><option class='option' name='100' value='425'>$425pw</option><option class='option' name='100' value='450'>$450pw</option><option class='option' name='100' value='475'>$475pw</option><option class='option' name='100' value='500'>$500pw</option><option class='option' name='100' value='525'>$525pw</option><option class='option' name='100' value='550'>$550pw</option><option class='option' name='100' value='575'>$575pw</option><option class='option' name='100' value='600'>$600pw</option><option class='option' name='100' value='625'>$625pw</option><option class='option' name='100' value='650'>$650pw</option><option class='option' name='100' value='675'>$675pw</option><option class='option' name='100' value='700'>$700pw</option><option class='option' name='100' value='725'>$725pw</option><option class='option' name='100' value='750'>$750pw</option><option class='option' name='100' value='800'>$800pw</option><option class='option' name='100' value=''>$<option class='option' name='100' value=''>$<option class='option' name='100' value='950'>$950pw</option><option class='option' name='100' value='1000'>$1,000pw</option><option class='option' name='100' value='1100'>$1,100pw</option><option class='option' name='100' value='1200'>$1,200pw</option><option class='option' name='100' value='1300'>$1,300pw</option><option class='option' name='100' value='1400'>$1,400pw</option><option class='option' name='100' value='1500'>$1,500pw</option><option class='option' name='100' value='1600'>$1,600pw</option><option class='option' name='100' value='1700'>$1,700pw</option><option class='option' name='100' value='1800'>$1,800pw</option><option class='option' name='100' value='1900'>$1,900pw</option><option class='option' name='100' value='2000'>$2,000pw</option><option class='option' name='100' value='2500'>$2,500pw</option><option class='option' name='100' value='3000'>$3,000pw</option><option class='option' name='100' value='3500'>$3,500pw</option><option class='option' name='100' value='4000'>$4,000pw</option><option class='option' name='100' value='4500'>$4,500pw</option><option class='option' name='100' value='5000'>$5,000pw</option>";
            document.getElementById(2).checked = true;
        }

        function share_clicked() {
            document.getElementById("buy-label").style.background = "#91969c";
            document.getElementById("rent-label").style.background = "#91969c";
            document.getElementById("share-label").style.background = "#e4002b";
            document.getElementById("min-price").innerHTML = "<option class='option' name='100' value='0'>Price pw (min)</option><option class='option' name='100' value='50'>$50pw</option></option><option class='option' name='100' value='75'>$75pw</option></option><option class='option' name='100' value='100'>$100pw</option><option class='option' name='100' value='125'>$125pw</option><option class='option' name='100' value='150'>$150pw</option><option class='option' name='100' value='175'>$175pw</option><option class='option' name='100' value='200'>$200pw</option><option class='option' name='100' value='225'>$225pw</option><option class='option' name='100' value='250'>$250pw</option><option class='option' name='100' value='275'>$275pw</option><option class='option' name='100' value='300'>$300pw</option><option class='option' name='100' value='325'>$325pw</option><option class='option' name='100' value='350'>$350pw</option><option class='option' name='100' value='375'>$375pw</option><option class='option' name='100' value='400'>$400pw</option><option class='option' name='100' value='425'>$425pw</option><option class='option' name='100' value='450'>$450pw</option><option class='option' name='100' value='475'>$475pw</option><option class='option' name='100' value='500'>$500pw</option><option class='option' name='100' value='525'>$525pw</option><option class='option' name='100' value='550'>$550pw</option><option class='option' name='100' value='575'>$575pw</option><option class='option' name='100' value='600'>$600pw</option><option class='option' name='100' value='625'>$625pw</option><option class='option' name='100' value='650'>$650pw</option><option class='option' name='100' value='675'>$675pw</option><option class='option' name='100' value='700'>$700pw</option><option class='option' name='100' value='725'>$725pw</option><option class='option' name='100' value='750'>$750pw</option><option class='option' name='100' value='800'>$800pw</option><option class='option' name='100' value=''>$<option class='option' name='100' value=''>$<option class='option' name='100' value='950'>$950pw</option><option class='option' name='100' value='1000'>$1,000pw</option><option class='option' name='100' value='1100'>$1,100pw</option><option class='option' name='100' value='1200'>$1,200pw</option><option class='option' name='100' value='1300'>$1,300pw</option><option class='option' name='100' value='1400'>$1,400pw</option><option class='option' name='100' value='1500'>$1,500pw</option><option class='option' name='100' value='1600'>$1,600pw</option><option class='option' name='100' value='1700'>$1,700pw</option><option class='option' name='100' value='1800'>$1,800pw</option><option class='option' name='100' value='1900'>$1,900pw</option><option class='option' name='100' value='2000'>$2,000pw</option><option class='option' name='100' value='2500'>$2,500pw</option><option class='option' name='100' value='3000'>$3,000pw</option><option class='option' name='100' value='3500'>$3,500pw</option><option class='option' name='100' value='4000'>$4,000pw</option><option class='option' name='100' value='4500'>$4,500pw</option><option class='option' name='100' value='5000'>$5,000pw</option>";
            document.getElementById("max-price").innerHTML = "<option class='option' name='100' value='1000000000'>Price pw (max)</option><option class='option' name='100' value='50'>$50pw</option></option><option class='option' name='100' value='75'>$75pw</option></option><option class='option' name='100' value='100'>$100pw</option><option class='option' name='100' value='125'>$125pw</option><option class='option' name='100' value='150'>$150pw</option><option class='option' name='100' value='175'>$175pw</option><option class='option' name='100' value='200'>$200pw</option><option class='option' name='100' value='225'>$225pw</option><option class='option' name='100' value='250'>$250pw</option><option class='option' name='100' value='275'>$275pw</option><option class='option' name='100' value='300'>$300pw</option><option class='option' name='100' value='325'>$325pw</option><option class='option' name='100' value='350'>$350pw</option><option class='option' name='100' value='375'>$375pw</option><option class='option' name='100' value='400'>$400pw</option><option class='option' name='100' value='425'>$425pw</option><option class='option' name='100' value='450'>$450pw</option><option class='option' name='100' value='475'>$475pw</option><option class='option' name='100' value='500'>$500pw</option><option class='option' name='100' value='525'>$525pw</option><option class='option' name='100' value='550'>$550pw</option><option class='option' name='100' value='575'>$575pw</option><option class='option' name='100' value='600'>$600pw</option><option class='option' name='100' value='625'>$625pw</option><option class='option' name='100' value='650'>$650pw</option><option class='option' name='100' value='675'>$675pw</option><option class='option' name='100' value='700'>$700pw</option><option class='option' name='100' value='725'>$725pw</option><option class='option' name='100' value='750'>$750pw</option><option class='option' name='100' value='800'>$800pw</option><option class='option' name='100' value=''>$<option class='option' name='100' value=''>$<option class='option' name='100' value='950'>$950pw</option><option class='option' name='100' value='1000'>$1,000pw</option><option class='option' name='100' value='1100'>$1,100pw</option><option class='option' name='100' value='1200'>$1,200pw</option><option class='option' name='100' value='1300'>$1,300pw</option><option class='option' name='100' value='1400'>$1,400pw</option><option class='option' name='100' value='1500'>$1,500pw</option><option class='option' name='100' value='1600'>$1,600pw</option><option class='option' name='100' value='1700'>$1,700pw</option><option class='option' name='100' value='1800'>$1,800pw</option><option class='option' name='100' value='1900'>$1,900pw</option><option class='option' name='100' value='2000'>$2,000pw</option><option class='option' name='100' value='2500'>$2,500pw</option><option class='option' name='100' value='3000'>$3,000pw</option><option class='option' name='100' value='3500'>$3,500pw</option><option class='option' name='100' value='4000'>$4,000pw</option><option class='option' name='100' value='4500'>$4,500pw</option><option class='option' name='100' value='5000'>$5,000pw</option>";
            document.getElementById(3).checked = true;
        }

        var e = document.getElementById("sort");
        $(document).ready(function () {
            $("#sort").on("change", function () {
                this.form.submit();
            });
        });
    </script>



    {{--scripts for google locations--}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1CbPQ2HCLV38r9m68B8VCv51JBVke5TM&callback=initAutocomplete&libraries=places&v=weekly"
        defer
    ></script>
    <script type="text/javascript">

        function initializeAutocomplete() {

            var input = document.getElementById('locality');
            @if(isset($searched))
                input.value = {{$searched}}+"";
            console.log("isset");
            @endif
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

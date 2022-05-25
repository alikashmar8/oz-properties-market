@extends('layouts.app')

@section('content')

    @if(\Illuminate\Support\Facades\Auth::guest() || (!\Illuminate\Support\Facades\Auth::guest() && \Illuminate\Support\Facades\Auth::user()->role != 0))
        {{--        if user guest or not admin --}}
        <div class="hero"
             style=" height: 600px; background-image: url({{asset('images1/home.jpg')}}); background-position: 50% 40%;">


            <div class="inner " style="text-align: left;">


                <div class="search-form-container">
                    <form class="form " action="/search-properties" method="GET">
                        <div class="search-bar-section">
                            <h1>Search for a user</h1>

                        </div>

                        <div class="search-bar-section">

                            @foreach($categories as $category)
                                <div class="search-bar-nav ">

                                    <label for="{{ $category->id }}"
                                           id="{{  Str::lower($category->title) }}-label">{{ $category->title }}</label>
                                    <input type="radio" class="search-bar-nav-remove" name="category"
                                           value="{{$category->id}}" id="{{ $category->id }}"
                                           onclick="{{  Str::lower($category->title) }}_clicked();"
                                           @if($category->id == 1) checked @endif >

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

                            <input class="location1" type="search" placeholder="Search by Location" {{--name="address"--}} name="location"
                                   onFocus="initializeAutocomplete()" id="locality" >


                            <button type="submit"   class="btn-primary1 submit">Search
                            </button>




                        </div>

                        <div class="search-bar-section">
                            <div style="width: 100%">
                            <select name="type">
                                <option class="option" name="type" value=-1>Property type</option>
                                @foreach($types as $type)
                                    <option class="option" name="type" value="{{ $type->id }}"
                                            id="{{ $type->id }}">{{ $type->title }}</option>

                                @endforeach
                            </select>


                            <select name="bedroomsNumber">
                                <option class="option" value="-1">Beds</option>
                                <option class="option" value="1">1</option>
                                <option class="option" value="2">2</option>
                                <option class="option" value="3">3</option>
                                <option class="option" value="4">4</option>
                                <option class="option" value="5">5+</option>
                            </select>
                            <select id="min-price" name="minPrice">

                                <option class='option' name='100' value='0'>Price (min)</option>
                                <option class='option' name='100' value='50000'>$50,000</option>
                                <option class='option' name='100' value='100000'>$ 100,000</option>
                                <option class='option' name='100' value='200000'>$ 200,000</option>
                                <option class='option' name='100' value='300000'>$ 300,000</option>
                                <option class='option' name='100' value='400000'>$ 400,000</option>
                                <option class='option' name='100' value='500000'>$ 500,000</option>
                                <option class='option' name='100' value='600000'>$ 600,000</option><option class='option' name='100' value='700000'>$ 700,000</option><option class='option' name='100' value='800000'>$ 800,000</option><option class='option' name='100' value='900000'>$ 900,000</option><option class='option' name='100' value='1000000'>$ 1,000,000</option><option class='option' name='100' value='1100000'>$ 1,100,000</option><option class='option' name='100' value='1200000'>$ 1,200,000</option><option class='option' name='100' value='1300000'>$ 1,300,000</option><option class='option' name='100' value='1400000'>$ 1,400,000</option><option class='option' name='100' value='1500000'>$ 1,500,000</option><option class='option' name='100' value='1600000'>$ 1,600,000</option><option class='option' name='100' value='1700000'>$ 1,700,000</option><option class='option' name='100' value='1800000'>$ 1,800,000</option><option class='option' name='100' value='1900000'>$ 1,900,000</option>
                                <option class='option' name='100' value='2000000'>$ 2,000,000</option>


                            </select>
                            <select id="max-price" name="maxPrice">
                                <option class='option' name='100' value='1000000000'>Price (max)</option>
                                <option class='option' name='100' value='100000'>$ 100,000 </option>
                                <option class='option' name='100' value='200000'>$ 200,000 </option>
                                <option class='option' name='100' value='300000'>$ 300,000 </option>
                                <option class='option' name='100' value='400000'>$ 400,000 </option>
                                <option class='option' name='100' value='500000'>$ 500,000 </option>
                                <option class='option' name='100' value='600000'>$ 600,000 </option>
                                <option class='option' name='100' value='700000'>$ 700,000 </option>
                                <option class='option' name='100' value='800000'>$ 800,000 </option>
                                <option class='option' name='100' value='900000'>$ 900,000 </option>
                                <option class='option' name='100' value='1000000'>$ 1,000,000 </option>
                                <option class='option' name='100' value='1100000'>$ 1,100,000</option>
                                <option class='option' name='100' value='1200000'>$ 1,200,000</option>
                                <option class='option' name='100' value='1300000'>$ 1,300,000</option>
                                <option class='option' name='100' value='1400000'>$ 1,400,000</option>
                                <option class='option' name='100' value='1500000'>$ 1,500,000</option>
                                <option class='option' name='100' value='1600000'>$ 1,600,000</option>
                                <option class='option' name='100' value='1700000'>$ 1,700,000</option>
                                <option class='option' name='100' value='1800000'>$ 1,800,000</option>
                                <option class='option' name='100' value='1900000'>$ 1,900,000</option>
                                <option class='option' name='100' value='2000000'>$ 2,000,000</option>
                                <option class='option' name='100' value='2100000'>$ 2,100,000</option>
                                <option class='option' name='100' value='2200000'>$ 2,200,000</option>
                                <option class='option' name='100' value='2300000'>$ 2,300,000</option>
                                <option class='option' name='100' value='2400000'>$ 2,400,000</option>
                                <option class='option' name='100' value='2500000'>$ 2,500,000</option>
                                <option class='option' name='100' value='2600000'>$ 2,600,000</option>
                                <option class='option' name='100' value='2700000'>$ 2,700,000</option>
                                <option class='option' name='100' value='2800000'>$ 2,800,000</option>
                                <option class='option' name='100' value='2900000'>$ 2,900,000</option>
                                <option class='option' name='100' value='3000000'>$ 3,000,000</option><option class='option' name='100' value='3100000'>$ 3,100,000</option><option class='option' name='100' value='3200000'>$ 3,200,000</option><option class='option' name='100' value='3300000'>$ 3,300,000</option><option class='option' name='100' value='3400000'>$ 3,400,000</option><option class='option' name='100' value='3500000'>$ 3,500,000</option><option class='option' name='100' value='3600000'>$ 3,600,000</option><option class='option' name='100' value='3700000'>$ 3,700,000</option><option class='option' name='100' value='3800000'>$ 3,800,000</option><option class='option' name='100' value='3900000'>$ 3,900,000</option><option class='option' name='100' value='4000000'>$ 4,000,000</option><option class='option' name='100' value='4100000'>$ 4,100,000</option><option class='option' name='100' value='4200000'>$ 4,200,000</option><option class='option' name='100' value='4300000'>$ 4,300,000</option><option class='option' name='100' value='4400000'>$ 4,400,000</option><option class='option' name='100' value='4500000'>$ 4,500,000</option><option class='option' name='100' value='4600000'>$ 4,600,000</option><option class='option' name='100' value='4700000'>$ 4,700,000</option><option class='option' name='100' value='4800000'>$ 4,800,000</option><option class='option' name='100' value='4900000'>$ 4,900,000</option>
                                <option class='option' name='100' value='5000000'>$ 5,000,000 </option>

                            </select>
                            </div>
                        </div>

                    </form>



                </div>


            </div>
        </div>

        <div class="main1">


            <div>
                <h1>
                    <i class="fas fa-laptop-house"></i>
                </h1>
                <p>
                    Get an online access to buy, sell, and rent user

                </p>
            </div>
            <div>
                <h1>
                    <i class="fas fa-money-check-alt"></i>
                </h1>
                <p>
                    Save money and time in achieving your goals
                </p>
            </div>
            <div>
                <h1>
                    <i class="fas fa-house-user"></i>
                </h1>
                <p>
                    Track your user to monitor local sales
                </p>
            </div>

        </div>

        @include('layouts.slider')

        <div class="main-content">

            <div class="main2">
                <div class="container p-4">
                    <h1>
                        Welcome to OZ Property Market
                    </h1>
                    <p>

                        <BR/>Want to sell your user without wasting $$$ on agents?
                        <BR/>Oz Property Market the Agent will enable you to do just that. Simply sign up, list your
                        user and connect with buyers directly yourself. With our one-off fixed price packages, you can
                        customise and pay for the package that you want!
                        <BR/>Get listed on the sites you need to be on, including <a href="http://realestate.com.au/"
                                                                                     target="_blank"
                                                                                     class="special-link"
                                                                                     style="color: #e4002b ; padding: 0">realestate.com.au</a>
                        & <a href="http://domain.com.au/" target="_blank" class="special-link"
                             style="color: #e4002b ; padding: 0"> domain.com.au</a>. There are no hidden charges,
                        management fees or additional costs. Save on agent’s commission by selling your own user!

                    </p>
                </div>
                <BR/> <BR/> <BR/>
                <div class="container p-4">
                    <h1>
                        About Oz Property Market
                    </h1>
                    <p>

                        <BR/>Oz Property Market the Agent lists you on all the user websites you need to be on,<a
                            href="http://realestate.com.au/" target="_blank" class="special-link"
                            style="color: #e4002b ; padding: 0">realestate.com.au</a>, <a href="http://domain.com.au/"
                                                                                          target="_blank"
                                                                                          class="special-link"
                                                                                          style="color: #e4002b ; padding: 0">
                            domain.com.au</a>, <a href="http://realcommercial.com.au/" target="_blank"
                                                  class="special-link" style="color: #e4002b ; padding: 0">
                            realcommercial.com.au</a> & many more. Best part is it all comes with no hidden costs or
                        commissions.
                        <BR/>At Oz Property Market we believe that ownership is associated with freedom of choice. It’s
                        your user – so you choose. You retain complete control over your listing, enabling you to
                        accurately represent it how you desire, lend a personal touch to your user description and
                        adjust your price according to what you want. What’s more, with our all inclusive and straight
                        to the point packages you decide for yourself which services you need and pay only for those
                        services.
                        <BR/>Our selection of packages aims to give you the most essential tools for the best and
                        quickest outcome for your user. Most importantly, we have the means to ensure your user is
                        listed on Australia’s highest-traffic and most-trusted real estate listing websites. These sites
                        are not otherwise directly accessible for user owners acting without an agent, making OPM the
                        route to getting listed without paying the commission fee’s. Other services include “For Sale
                        boards”, marketing brochures, user market reports and professional advice for user-owners.
                        <BR/>And perhaps most significantly, we offer you these services completely commission-free.
                        That’s the way it should be. By retaining ultimate control over and responsibility for your user
                        listing, you’ve essentially become your own real estate agent! With 88% of user buyers and
                        renters turning to the internet for research purposes, our internet-focused publicity strategy
                        offers maximum visibility at minimum cost. So grab your real estate agent toolbox from Oz
                        Property Market the Agent and get to work.

                    </p>
                </div>


            </div>
            <div class="main3">

            </div>
        </div>
    @else

    @if(\Illuminate\Support\Facades\Auth::user()->role == 0)
                    {{--            admin home page--}}

        <div class="hero" style=" height: 600px; background-image: url({{asset('images1/home.jpg')}}); background-position: 50% 40%;">

        </div>
                    <div class="row container py-0" style="margin: auto">

                        <div class="col-md-1 ">  </div>

                        <div class="col-md-5 bg-white p-2 my-3">
                            <h2>All Properies = {{ count($allProperties) }}</h2>
                            <a href="/acceptedProperties" style="color: #e4002b">Check Now</a>
                        </div>

                        <div class="col-md-1">  </div>

                        <div class="col-md-5 bg-white p-2 my-3">
                            <h2>Properies waiting for confirmation = {{ count($notAcceptedProperties) }}</h2>
                            <a href="/acceptProperties" style="color: #e4002b">Check Now</a>
                        </div>

                        <div class="col-md-1">  </div>

                        <div class="col-md-5 bg-white p-2 my-3">
                            <h2>All Commercials = {{ count($allCommercials) }}</h2>
                            <a href="/allCommercials" style="color: #e4002b">Check Now</a>
                        </div>

                        <div class="col-md-1">  </div>

                        <div class="col-md-5 bg-white p-2 my-3">
                            <h2>Commercials waiting for confirmation = {{ count($notAcceptedCommercials) }}</h2>
                            <a href="/acceptCommercials" style="color: #e4002b">Check Now</a>
                        </div>


                        <div class="col-md-1"></div>

                        <div class="col-md-5 bg-white p-2  my-3">
                            <h2>All Users: {{ count($allUsers) }}</h2>
                            <a href="/users" style="color: #e4002b">See Users</a>

                        </div>

                        <div class="col-md-1"></div>

                        <div class="col-md-5 bg-white p-2  my-3">
                            <h2>New User in the last 24 hrs: {{ count($recentUsers) }}</h2>
                            <a href="/users" style="color: #e4002b">See Users</a>

                        </div>


                        <div class="col-md-1"></div>

                        <div class="col-md-5 bg-white p-2  my-3">
                            <h2>All Payments: {{ count($allPayments) }}</h2>
                            <a href="/adminPayments" style="color: #e4002b">See Payments</a>

                        </div>

                        <div class="col-md-1"></div>

                        <div class="col-md-5 bg-white p-2  my-3">
                            <h2> New Payments in the last 24 hrs: {{ count($allEarnings) }}</h2>
                            <a href="/adminPayments" style="color: #e4002b">See Payments</a>

                        </div>


                    </div>
                @endif

            @endif

    <script>
        function buy_clicked(){
            document.getElementById("buy-label").style.background="#e4002b";
            document.getElementById("rent-label").style.background="#91969c";
            document.getElementById("share-label").style.background="#91969c";


            document.getElementById("min-price").innerHTML = "<option class='option' name='100' value='0'>Price (min)</option><option class='option' name='100' value='50000'>$50,000</option> <option class='option' name='100' value='100000'>$ 100,000</option> <option class='option' name='100' value='200000'>$ 200,000</option><option class='option' name='100' value='300000'>$ 300,000</option> <option class='option' name='100' value='400000'>$ 400,000</option><option class='option' name='100' value='500000'>$ 500,000</option> <option class='option' name='100' value='600000'>$ 600,000</option><option class='option' name='100' value='700000'>$ 700,000</option><option class='option' name='100' value='800000'>$ 800,000</option><option class='option' name='100' value='900000'>$ 900,000</option><option class='option' name='100' value='1000000'>$ 1,000,000</option><option class='option' name='100' value='1100000'>$ 1,100,000</option><option class='option' name='100' value='1200000'>$ 1,200,000</option><option class='option' name='100' value='1300000'>$ 1,300,000</option><option class='option' name='100' value='1400000'>$ 1,400,000</option><option class='option' name='100' value='1500000'>$ 1,500,000</option><option class='option' name='100' value='1600000'>$ 1,600,000</option><option class='option' name='100' value='1700000'>$ 1,700,000</option><option class='option' name='100' value='1800000'>$ 1,800,000</option><option class='option' name='100' value='1900000'>$ 1,900,000</option><option class='option' name='100' value='2000000'>$ 2,000,000</option>";
            document.getElementById("max-price").innerHTML = "<option class='option' name='100' value='1000000000'>Price (max)</option><option class='option' name='100' value='100000'>$ 100,000 </option> <option class='option' name='100' value='200000'>$ 200,000 </option><option class='option' name='100' value='300000'>$ 300,000 </option> <option class='option' name='100' value='400000'>$ 400,000 </option><option class='option' name='100' value='500000'>$ 500,000 </option> <option class='option' name='100' value='600000'>$ 600,000 </option><option class='option' name='100' value='700000'>$ 700,000 </option><option class='option' name='100' value='800000'>$ 800,000 </option><option class='option' name='100' value='900000'>$ 900,000 </option><option class='option' name='100' value='1000000'>$ 1,000,000 </option><option class='option' name='100' value='1100000'>$ 1,100,000</option><option class='option' name='100' value='1200000'>$ 1,200,000</option><option class='option' name='100' value='1300000'>$ 1,300,000</option><option class='option' name='100' value='1400000'>$ 1,400,000</option><option class='option' name='100' value='1500000'>$ 1,500,000</option><option class='option' name='100' value='1600000'>$ 1,600,000</option><option class='option' name='100' value='1700000'>$ 1,700,000</option><option class='option' name='100' value='1800000'>$ 1,800,000</option><option class='option' name='100' value='1900000'>$ 1,900,000</option><option class='option' name='100' value='2000000'>$ 2,000,000</option><option class='option' name='100' value='2100000'>$ 2,100,000</option><option class='option' name='100' value='2200000'>$ 2,200,000</option><option class='option' name='100' value='2300000'>$ 2,300,000</option><option class='option' name='100' value='2400000'>$ 2,400,000</option><option class='option' name='100' value='2500000'>$ 2,500,000</option><option class='option' name='100' value='2600000'>$ 2,600,000</option><option class='option' name='100' value='2700000'>$ 2,700,000</option><option class='option' name='100' value='2800000'>$ 2,800,000</option><option class='option' name='100' value='2900000'>$ 2,900,000</option><option class='option' name='100' value='3000000'>$ 3,000,000</option><option class='option' name='100' value='3100000'>$ 3,100,000</option><option class='option' name='100' value='3200000'>$ 3,200,000</option><option class='option' name='100' value='3300000'>$ 3,300,000</option><option class='option' name='100' value='3400000'>$ 3,400,000</option><option class='option' name='100' value='3500000'>$ 3,500,000</option><option class='option' name='100' value='3600000'>$ 3,600,000</option><option class='option' name='100' value='3700000'>$ 3,700,000</option><option class='option' name='100' value='3800000'>$ 3,800,000</option><option class='option' name='100' value='3900000'>$ 3,900,000</option><option class='option' name='100' value='4000000'>$ 4,000,000</option><option class='option' name='100' value='4100000'>$ 4,100,000</option><option class='option' name='100' value='4200000'>$ 4,200,000</option><option class='option' name='100' value='4300000'>$ 4,300,000</option><option class='option' name='100' value='4400000'>$ 4,400,000</option><option class='option' name='100' value='4500000'>$ 4,500,000</option><option class='option' name='100' value='4600000'>$ 4,600,000</option><option class='option' name='100' value='4700000'>$ 4,700,000</option><option class='option' name='100' value='4800000'>$ 4,800,000</option><option class='option' name='100' value='4900000'>$ 4,900,000</option><option class='option' name='100' value='5000000'>$ 5,000,000 </option>";

        }
        function rent_clicked(){
            document.getElementById("buy-label").style.background="#91969c";
            document.getElementById("rent-label").style.background="#e4002b";
            document.getElementById("share-label").style.background="#91969c";
            document.getElementById("min-price").innerHTML = "<option class='option' name='100' value='0'>Price pw (min)</option><option class='option' name='100' value='50'>$50pw</option></option><option class='option' name='100' value='75'>$75pw</option></option><option class='option' name='100' value='100'>$100pw</option><option class='option' name='100' value='125'>$125pw</option><option class='option' name='100' value='150'>$150pw</option><option class='option' name='100' value='175'>$175pw</option><option class='option' name='100' value='200'>$200pw</option><option class='option' name='100' value='225'>$225pw</option><option class='option' name='100' value='250'>$250pw</option><option class='option' name='100' value='275'>$275pw</option><option class='option' name='100' value='300'>$300pw</option><option class='option' name='100' value='325'>$325pw</option><option class='option' name='100' value='350'>$350pw</option><option class='option' name='100' value='375'>$375pw</option><option class='option' name='100' value='400'>$400pw</option><option class='option' name='100' value='425'>$425pw</option><option class='option' name='100' value='450'>$450pw</option><option class='option' name='100' value='475'>$475pw</option><option class='option' name='100' value='500'>$500pw</option><option class='option' name='100' value='525'>$525pw</option><option class='option' name='100' value='550'>$550pw</option><option class='option' name='100' value='575'>$575pw</option><option class='option' name='100' value='600'>$600pw</option><option class='option' name='100' value='625'>$625pw</option><option class='option' name='100' value='650'>$650pw</option><option class='option' name='100' value='675'>$675pw</option><option class='option' name='100' value='700'>$700pw</option><option class='option' name='100' value='725'>$725pw</option><option class='option' name='100' value='750'>$750pw</option><option class='option' name='100' value='800'>$800pw</option><option class='option' name='100' value=''>$<option class='option' name='100' value=''>$<option class='option' name='100' value='950'>$950pw</option><option class='option' name='100' value='1000'>$1,000pw</option><option class='option' name='100' value='1100'>$1,100pw</option><option class='option' name='100' value='1200'>$1,200pw</option><option class='option' name='100' value='1300'>$1,300pw</option><option class='option' name='100' value='1400'>$1,400pw</option><option class='option' name='100' value='1500'>$1,500pw</option><option class='option' name='100' value='1600'>$1,600pw</option><option class='option' name='100' value='1700'>$1,700pw</option><option class='option' name='100' value='1800'>$1,800pw</option><option class='option' name='100' value='1900'>$1,900pw</option><option class='option' name='100' value='2000'>$2,000pw</option><option class='option' name='100' value='2500'>$2,500pw</option><option class='option' name='100' value='3000'>$3,000pw</option><option class='option' name='100' value='3500'>$3,500pw</option><option class='option' name='100' value='4000'>$4,000pw</option><option class='option' name='100' value='4500'>$4,500pw</option><option class='option' name='100' value='5000'>$5,000pw</option>";
            document.getElementById("max-price").innerHTML = "<option class='option' name='100' value='1000000000'>Price pw (max)</option><option class='option' name='100' value='50'>$50pw</option></option><option class='option' name='100' value='75'>$75pw</option></option><option class='option' name='100' value='100'>$100pw</option><option class='option' name='100' value='125'>$125pw</option><option class='option' name='100' value='150'>$150pw</option><option class='option' name='100' value='175'>$175pw</option><option class='option' name='100' value='200'>$200pw</option><option class='option' name='100' value='225'>$225pw</option><option class='option' name='100' value='250'>$250pw</option><option class='option' name='100' value='275'>$275pw</option><option class='option' name='100' value='300'>$300pw</option><option class='option' name='100' value='325'>$325pw</option><option class='option' name='100' value='350'>$350pw</option><option class='option' name='100' value='375'>$375pw</option><option class='option' name='100' value='400'>$400pw</option><option class='option' name='100' value='425'>$425pw</option><option class='option' name='100' value='450'>$450pw</option><option class='option' name='100' value='475'>$475pw</option><option class='option' name='100' value='500'>$500pw</option><option class='option' name='100' value='525'>$525pw</option><option class='option' name='100' value='550'>$550pw</option><option class='option' name='100' value='575'>$575pw</option><option class='option' name='100' value='600'>$600pw</option><option class='option' name='100' value='625'>$625pw</option><option class='option' name='100' value='650'>$650pw</option><option class='option' name='100' value='675'>$675pw</option><option class='option' name='100' value='700'>$700pw</option><option class='option' name='100' value='725'>$725pw</option><option class='option' name='100' value='750'>$750pw</option><option class='option' name='100' value='800'>$800pw</option><option class='option' name='100' value=''>$<option class='option' name='100' value=''>$<option class='option' name='100' value='950'>$950pw</option><option class='option' name='100' value='1000'>$1,000pw</option><option class='option' name='100' value='1100'>$1,100pw</option><option class='option' name='100' value='1200'>$1,200pw</option><option class='option' name='100' value='1300'>$1,300pw</option><option class='option' name='100' value='1400'>$1,400pw</option><option class='option' name='100' value='1500'>$1,500pw</option><option class='option' name='100' value='1600'>$1,600pw</option><option class='option' name='100' value='1700'>$1,700pw</option><option class='option' name='100' value='1800'>$1,800pw</option><option class='option' name='100' value='1900'>$1,900pw</option><option class='option' name='100' value='2000'>$2,000pw</option><option class='option' name='100' value='2500'>$2,500pw</option><option class='option' name='100' value='3000'>$3,000pw</option><option class='option' name='100' value='3500'>$3,500pw</option><option class='option' name='100' value='4000'>$4,000pw</option><option class='option' name='100' value='4500'>$4,500pw</option><option class='option' name='100' value='5000'>$5,000pw</option>";


        }
        function share_clicked(){
            document.getElementById("buy-label").style.background="#91969c";

            document.getElementById("rent-label").style.background="#91969c";
            document.getElementById("share-label").style.background="#e4002b";
            document.getElementById("min-price").innerHTML = "<option class='option' name='100' value='0'>Price pw (min)</option><option class='option' name='100' value='50'>$50pw</option></option><option class='option' name='100' value='75'>$75pw</option></option><option class='option' name='100' value='100'>$100pw</option><option class='option' name='100' value='125'>$125pw</option><option class='option' name='100' value='150'>$150pw</option><option class='option' name='100' value='175'>$175pw</option><option class='option' name='100' value='200'>$200pw</option><option class='option' name='100' value='225'>$225pw</option><option class='option' name='100' value='250'>$250pw</option><option class='option' name='100' value='275'>$275pw</option><option class='option' name='100' value='300'>$300pw</option><option class='option' name='100' value='325'>$325pw</option><option class='option' name='100' value='350'>$350pw</option><option class='option' name='100' value='375'>$375pw</option><option class='option' name='100' value='400'>$400pw</option><option class='option' name='100' value='425'>$425pw</option><option class='option' name='100' value='450'>$450pw</option><option class='option' name='100' value='475'>$475pw</option><option class='option' name='100' value='500'>$500pw</option><option class='option' name='100' value='525'>$525pw</option><option class='option' name='100' value='550'>$550pw</option><option class='option' name='100' value='575'>$575pw</option><option class='option' name='100' value='600'>$600pw</option><option class='option' name='100' value='625'>$625pw</option><option class='option' name='100' value='650'>$650pw</option><option class='option' name='100' value='675'>$675pw</option><option class='option' name='100' value='700'>$700pw</option><option class='option' name='100' value='725'>$725pw</option><option class='option' name='100' value='750'>$750pw</option><option class='option' name='100' value='800'>$800pw</option><option class='option' name='100' value=''>$<option class='option' name='100' value=''>$<option class='option' name='100' value='950'>$950pw</option><option class='option' name='100' value='1000'>$1,000pw</option><option class='option' name='100' value='1100'>$1,100pw</option><option class='option' name='100' value='1200'>$1,200pw</option><option class='option' name='100' value='1300'>$1,300pw</option><option class='option' name='100' value='1400'>$1,400pw</option><option class='option' name='100' value='1500'>$1,500pw</option><option class='option' name='100' value='1600'>$1,600pw</option><option class='option' name='100' value='1700'>$1,700pw</option><option class='option' name='100' value='1800'>$1,800pw</option><option class='option' name='100' value='1900'>$1,900pw</option><option class='option' name='100' value='2000'>$2,000pw</option><option class='option' name='100' value='2500'>$2,500pw</option><option class='option' name='100' value='3000'>$3,000pw</option><option class='option' name='100' value='3500'>$3,500pw</option><option class='option' name='100' value='4000'>$4,000pw</option><option class='option' name='100' value='4500'>$4,500pw</option><option class='option' name='100' value='5000'>$5,000pw</option>";
            document.getElementById("max-price").innerHTML = "<option class='option' name='100' value='1000000000'>Price pw (max)</option><option class='option' name='100' value='50'>$50pw</option></option><option class='option' name='100' value='75'>$75pw</option></option><option class='option' name='100' value='100'>$100pw</option><option class='option' name='100' value='125'>$125pw</option><option class='option' name='100' value='150'>$150pw</option><option class='option' name='100' value='175'>$175pw</option><option class='option' name='100' value='200'>$200pw</option><option class='option' name='100' value='225'>$225pw</option><option class='option' name='100' value='250'>$250pw</option><option class='option' name='100' value='275'>$275pw</option><option class='option' name='100' value='300'>$300pw</option><option class='option' name='100' value='325'>$325pw</option><option class='option' name='100' value='350'>$350pw</option><option class='option' name='100' value='375'>$375pw</option><option class='option' name='100' value='400'>$400pw</option><option class='option' name='100' value='425'>$425pw</option><option class='option' name='100' value='450'>$450pw</option><option class='option' name='100' value='475'>$475pw</option><option class='option' name='100' value='500'>$500pw</option><option class='option' name='100' value='525'>$525pw</option><option class='option' name='100' value='550'>$550pw</option><option class='option' name='100' value='575'>$575pw</option><option class='option' name='100' value='600'>$600pw</option><option class='option' name='100' value='625'>$625pw</option><option class='option' name='100' value='650'>$650pw</option><option class='option' name='100' value='675'>$675pw</option><option class='option' name='100' value='700'>$700pw</option><option class='option' name='100' value='725'>$725pw</option><option class='option' name='100' value='750'>$750pw</option><option class='option' name='100' value='800'>$800pw</option><option class='option' name='100' value=''>$<option class='option' name='100' value=''>$<option class='option' name='100' value='950'>$950pw</option><option class='option' name='100' value='1000'>$1,000pw</option><option class='option' name='100' value='1100'>$1,100pw</option><option class='option' name='100' value='1200'>$1,200pw</option><option class='option' name='100' value='1300'>$1,300pw</option><option class='option' name='100' value='1400'>$1,400pw</option><option class='option' name='100' value='1500'>$1,500pw</option><option class='option' name='100' value='1600'>$1,600pw</option><option class='option' name='100' value='1700'>$1,700pw</option><option class='option' name='100' value='1800'>$1,800pw</option><option class='option' name='100' value='1900'>$1,900pw</option><option class='option' name='100' value='2000'>$2,000pw</option><option class='option' name='100' value='2500'>$2,500pw</option><option class='option' name='100' value='3000'>$3,000pw</option><option class='option' name='100' value='3500'>$3,500pw</option><option class='option' name='100' value='4000'>$4,000pw</option><option class='option' name='100' value='4500'>$4,500pw</option><option class='option' name='100' value='5000'>$5,000pw</option>";


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

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
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

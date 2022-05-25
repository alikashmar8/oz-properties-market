@extends('layouts.app')

@section('content')

    <div class="hero" style=" height: 500px; background-image: url({{asset('/images1/agent.jpg')}});
    ">

        <div class="inner">


            <div class="search-form-container">

                <form action="/findAgents" method="GET" class="form-inline my-2 my-lg-0">
                    <div class="search-bar-section">
                        <h1>Search for an agent</h1>

                    </div>
                    <div class=" search-bar-section ">
                        <input type="hidden" name="type" class="location1" value="agents">
                        <input class="location1" type="search" name="name" placeholder="Search">
                        <button class=" btn-primary1 submit" type="submit">Search</button>
                    </div>

                    <div class="search-bar-section ">

                    <!--p style="margin: 20px;  color: white;">Search By:</p-->
                    <select name="searchBy" style="display: inline-block">
                        <option value="name">Agent Name</option>
                        <option value="companyName">Company Name</option>
                        {{--
                        <option value="location">Location</option>
                        --}}
                    </select>

                </div>
            </form>

    </div>


        </div>
    </div>

{{--add a list of agents here --}}
    @include('searchResults')
@endsection

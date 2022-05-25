@extends('layouts.app')

@section('content')

    <div class="hero" style=" background-image: url({{asset('/images1/log.jpg')}});
    " >

        <div class="inner">
            <h1></h1>
        </div>
    </div>
    <BR><br>

    <div class="info1">

        <div class="top">
            <div id="private" class="decor" onclick="select_private()"><a>Private</a></div>
            <div id="agent" class="decor" onclick="select_agent()"><a>Agent</a></div>
        </div>

        <div class="details" id="d3">
            <div id="private-det">
                <div class="card-header "><h5 class="card-title text-center">Private {{ __('Register') }}</h5></div>
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <input id="role" type="hidden" name="role" value=2>


                    <div class="form-label-group">

                        <label for="name">{{ __('Name') }}*</label>


                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror


                    </div>

                    <div class="form-label-group" style="display: none;">

                        <label for="bio">Bio</label>
                        <textarea id="bio" type="text" class="form-control @error('bio') is-invalid @enderror"
                                  name="bio" value="{{ old('bio') }}" autocomplete="bio" autofocus  ></textarea>
                        @error('bio')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-label-group">
                        <label for="email">{{ __('E-Mail Address') }}*</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>


                    <div class="form-label-group">
                        <label for="phoneNumber">Phone Number*</label>
                        <select id="phoneNumberCode" name="phoneNumberCode" style="cursor:no-drop; display: none"
                                class="form-control mx-3 mb-2">

                            @foreach(\App\Models\CountryCode::orderBy('phonecode')->get() as $countryCode)
                                <option value="{{$countryCode->iso}}" style="display:none;"
                                        @if($countryCode->iso == 'AU') selected @else disabled @endif>
                                    +{{ $countryCode->phonecode }} - {{ $countryCode->iso }}</option>
                            @endforeach

                        </select>
                        <input id="phoneNumber" type="number"
                               class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber"
                               value="{{ old('phoneNumber') }}" required autocomplete="phoneNumber" autofocus>
                        @error('phoneNumber')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>


                    <div class="form-label-group" style="display: none;">
                        <label for="profileImg">Profile Image</label>
                        <input id="profileImg" type="file" class="@error('profileImg') is-invalid @enderror "
                               name="profileImg" value="{{ old('profileImg') }}" autocomplete="profileImg" autofocus>
                    </div>


                    <div class="form-label-group">
                        <label for="password">{{ __('Password') }}*</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>



                    <div class="form-label-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}*</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required autocomplete="new-password">
                    </div>
                    <br>
                    <div class="form-group  mb-0">
                        <div class="col-md-6  ">
                            <button type="submit" class=" btn-primary1">
                                {{ __('Register') }}
                            </button>
                        </div>
                        <BR/>
                    </div>

                </form>

            </div>


            <div id="agent-det">
                <div class="card-header"><h5 class="card-title text-center">Agent {{ __('Register') }}</h5></div>
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="agentForm">
                    @csrf

                    <input id="role" type="hidden" name="role" value=1>

                    <div class="form-label-group">
                        <label for="name">{{ __('Name') }}*</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>


                    <div class="form-label-group">
                        <label for="licenseNumber">License Number*</label>
                        <input id="licenseNumber" type="number"
                               class="form-control @error('licenseNumber') is-invalid @enderror"
                               name="licenseNumber" value="{{ old('licenseNumber') }}" required
                               autocomplete="licenseNumber" autofocus>
                        @error('licenseNumber')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror


                    </div>

                    <div class="form-label-group">

                        <label for="comp_name">Company Name*</label>
                        <input id="comp_name" type="text" class="form-control @error('comp_name') is-invalid @enderror"
                               name="comp_name" value="{{ old('comp_name') }}" required autocomplete="comp_name"
                               autofocus>
                        @error('comp_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

                    </div>



                    <div class="form-label-group">
                        <label for="email">{{ __('E-Mail Address') }}*</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

                    </div>


                    <div class="form-label-group">
                        <label for="phoneNumber">Phone Number*</label>
                        <select id="phoneNumberCode" name="phoneNumberCode" style="cursor:no-drop; display: none"
                                class="form-control mx-3 mb-2" readonly="readonly">
                            @foreach(\App\Models\CountryCode::orderBy('phonecode')->get() as $countryCode)
                                <option value="{{$countryCode->iso}}" style="display:none;"
                                        @if($countryCode->iso == 'AU') selected @else disabled @endif>
                                    +{{ $countryCode->phonecode }} - {{ $countryCode->iso }}</option>
                            @endforeach

                        </select>
                        <input id="phoneNumber" type="number"
                               class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber"
                               value="{{ old('phoneNumber') }}" required autocomplete="phoneNumber" autofocus>
                        @error('phoneNumber')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-label-group" style="display: none;">
                        <label for="profileImg">Profile Image</label>
                        <input id="profileImg" type="file" class="@error('profileImg') is-invalid @enderror "
                               name="profileImg" value="{{ old('profileImg') }}" autocomplete="profileImg" autofocus>

                    </div>

                    <div class="form-label-group">
                        <label for="password">{{ __('Password') }}*</label>

                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

                    </div>



                    <div class="form-label-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}*</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required autocomplete="new-password">
                    </div>


                    <div class="form-group  mb-0">
                        <div class="col-md-6 ">
                            <button type="submit" class=" btn-primary1">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>


            </div>


        </div>
    </div>

    <script>

        const loc = document.querySelector('#private-det');
        const con = document.querySelector('#agent-det');


        function select_private() {
            document.getElementById("private").style.background = "#e4002b";
            document.getElementById("private").style.color = "#ffffff";
            document.getElementById("agent").style.background = "#ffffff";
            document.getElementById("agent").style.color = "#e4002b";
            document.getElementById("d3").style.height = "650px";

            const t = new TimelineMax();
            t.fromTo(loc, 1.5, {height: "0%;"}, {height: "100%"})
                .fromTo(con, 1.5, {height: "100%;"}, {height: "0%"}, "-=1");

            document.getElementById("private-det").style.display = "block";
            document.getElementById("agent-det").style.display = "none";


        }

        function select_agent() {
            document.getElementById("private").style.background = "#ffffff";
            document.getElementById("private").style.color = "#e4002b";
            document.getElementById("agent").style.background = "#e4002b";
            document.getElementById("agent").style.color = "#ffffff";
            document.getElementById("d3").style.height = "800px";

            const t = new TimelineMax();
            t.fromTo(loc, 1, {height: "100%;"}, {height: "0%"})
                .fromTo(con, 1, {height: "0%;"}, {height: "100%"}, "-=1");


            document.getElementById("private-det").style.display = "none";
            document.getElementById("agent-det").style.display = "block";


        }


    </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"
                integrity="sha512-DkPsH9LzNzZaZjCszwKrooKwgjArJDiEjA5tTgr3YX4E6TYv93ICS8T41yFHJnnSmGpnf0Mvb5NhScYbwvhn2w=="
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TimelineMax.min.js"
                integrity="sha512-0xrMWUXzEAc+VY7k48pWd5YT6ig03p4KARKxs4Bqxb9atrcn2fV41fWs+YXTKb8lD2sbPAmZMjKENiyzM/Gagw=="
                crossorigin="anonymous"></script>



@endsection

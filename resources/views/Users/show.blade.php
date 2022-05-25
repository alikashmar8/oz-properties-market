@extends('layouts.app')


@section('content')

    <div class="hero" style=" background-image: url({{asset('/images1/profile.jpg')}});
    ">
        <div
            style="position: absolute; width:100%;top: 0;height: 20px; background-image: linear-gradient(#df0505, transparent); ">

        </div>
        <div class="inner">
            <h1>Profile</h1>
        </div>
    </div>

    @if(!\Illuminate\Support\Facades\Auth::guest())
        {{--        user loggedin--}}
        @if(\Illuminate\Support\Facades\Auth::user()->role == 0)
            {{--            admin viewing some user--}}
            <div class=" profile">
                <div class="num1">
                    <img class=" img-thumbnail"
                         src="{{url('/user_profile_images/' . $user->profileImg)}}"
                         alt="Profile Image">
                    <p> ID: {{$user->id}}</p>

                </div>
                <div class="num2">

                    <h2>{{$user->name}}</h2>
                    @if($user->role == 1)
                        <p> <a style="font-weight: bold">Company name:</a> {{$user->company->name}}</p>
                        <p><a style="font-weight: bold"> Licence number:</a> {{$user->company->liceneceNumber}}</p>
                    @endif
                    <p> <a style="font-weight: bold">Phone number:</a> +{{$user->phoneNumberCode}}-{{$user->phoneNumber}}</p>
                    <p><a style="font-weight: bold">Email:</a> {{$user->email}}</p>
                    <br/>
                    <p style="white-space: pre-line"><a style="font-weight: bold">Bio:</a> {{$user->bio}}</p>
                    <br/>

                    <button class="btn-primary1" data-toggle="modal" data-target="#exampleModal"
                            @if(!\Illuminate\Support\Facades\Auth::user()->hasVerifiedEmail())disabled @endIf>Edit
                        Profile
                    </button>
                </div>
            </div>
        @else
            @if(\Illuminate\Support\Facades\Auth::id() == $user->id)
                {{--                user viewing his profile                --}}
                <div class=" profile">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="num1">
                        <img class=" img-thumbnail"
                             src="{{url('/storage/user_profile_images/' . $user->profileImg)}}"
                             alt="Profile Image">
                        <p> ID: {{$user->id}}</p>
                    </div>
                    <div class="num2">

                        <h2>{{$user->name}}</h2>
                        @if($user->role == 1)
                            <p><a style="font-weight: bold"> Company name:</a> {{$user->company->name}}</p>
                            <p><a style="font-weight: bold"> Licence number:</a> {{$user->company->licenseNumber}}</p>
                        @endif
                        <p> <a style="font-weight: bold">Phone number:</a> +{{$user->phoneNumberCode}}-{{$user->phoneNumber}}</p>
                        <p><a style="font-weight: bold">Email: </a>{{$user->email}}</p>
                        @if(!\Illuminate\Support\Facades\Auth::user()->hasVerifiedEmail())
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </div>
                            @endif
                            <p class="alert alert-danger">Your email is not verified yet !</p>

                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                Before proceeding, please check your email for a verification link.
                                If you did not receive a varification email, click here to
                                            <button type="submit"
                                                    class="btn special-link p-1  m-2  " style="color: #e4002b">{{ __('request another one') }}</button>
                                .
                            </form>
                        @endif

                        <br/>
                        <p style="white-space: pre-line"><a style="font-weight: bold">Bio:</a> {{$user->bio}}</p>

                        <br/>
                        <button class="btn-primary1" data-toggle="modal" data-target="#exampleModal"
                                @if(!\Illuminate\Support\Facades\Auth::user()->hasVerifiedEmail())disabled @endIf>Edit
                            Profile
                        </button>
                    </div>
                </div>
                <div class="profile">
                    <div class="container">
                        MemeberShip(s):<br/>
                        @if(count($membership) >0)
                            @foreach($membership as $mem)
                                <ul class="accordion">
                                    <li>
                                        {{$mem -> package}}
                                    </li>
                                </ul>
                            @endforeach
                        @endif
                        <br/>
                        <table>
                            <tr>
                                <td>
                                    <a href="/packages" class="btn-primary1" style="display: inline-block;margin: 5px"> Register in new package</a>
                                 <a href="/userPayments" class="btn-primary1" style="display: inline-block;margin: 5px;"> Payment History </a> </td>
                            </tr>
                        </table>
                    </div>
                </div>
            @else
                {{--                ristricted area--}}
                <script type="text/javascript">
                    window.location = "/";
                </script>
            @endif

        @endif

    @endif


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-warning">Please note changing your email address needs new email confirmation
                    process
                </div>
                {{--                <form action="/users/edit" method="post" id="editForm">--}}
                {{ Form::open(['action' => ['App\Http\Controllers\UsersController@update',$user->id],'method'=>'PUT','files' => true]) }}

                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group form-label-group">
                        <input type="hidden" value="{{ $user->id }}" name="id">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                               value="{{ $user->name }}" required>
                    </div>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="form-group form-label-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email"
                               value="{{ $user->email }}" required>
                    </div>

                    {{--for agent only--}}
                    @if($user->role == 1)


                        <div class="form-label-group">
                            <label for="license">License Number*</label>
                            <input id="license" type="number" class="form-control @error('license') is-invalid @enderror"
                                   name="license" value="{{$user->company->licenseNumber}}" required autocomplete="license" autofocus>
                            @error('license')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror


                        </div>

                        <div class="form-label-group">

                            <label for="comp_name">Company Name*</label>
                            <input id="comp_name" type="text" class="form-control @error('comp_name') is-invalid @enderror"
                                   name="comp_name" value="{{$user->company->name}}" required autocomplete="comp_name"
                                   autofocus>
                            @error('comp_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>

                    @endif

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <div class="form-group form-label-group">
                        <div class="form-label-group">
                            <label for="phoneNumber">Phone Number*</label>
                            <select id="phoneNumberCode" name="phoneNumberCode" class="form-control" style="display: none">
                                @foreach(\App\Models\CountryCode::orderBy('nicename')->get() as $countryCode)
                                    <option value="{{$countryCode->iso}}"
                                            @if($countryCode->phonecode == $user->phoneNumberCode) selected @endif>
                                        +{{ $countryCode->phonecode }}</option>
                                @endforeach

                            </select>
                            <input id="phoneNumber" type="number"
                                   class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber"
                                   value="{{ $user->phoneNumber }}" required
                                   autocomplete="phoneNumber" autofocus>
                            @error('phoneNumber')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group form-label-group">
                        <label for="bio" class="col-form-label">Bio:</label>
                        <textarea   type="text" class="form-control  @error('bio') is-invalid @enderror" name="bio"
                                  maxlength="180" >{{ $user->bio }}</textarea>




                    </div>

                    @error('bio')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror

                    <div class="form-group form-label-group">
                        <label for="profileImg">Profile Image:</label>
                        <input id="profileImg" type="file" class="@error('profileImg') is-invalid @enderror " accept=".png, .jpg"
                               name="profileImg" value="{{ old('profileImg') }}" autocomplete="profileImg" autofocus>
                    </div>
                    @error('profileImg')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-primary2" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success btn-primary2" value="edit">
                </div>
                {{--                </form>--}}
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

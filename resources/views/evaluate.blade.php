@extends('layouts.app')

@section('content')

    <div class="hero" style=" background-image: url({{asset('/images1/eval.jpg')}});
    " >

        <div class="inner">
            <h1>Evaluate</h1>
        </div>
    </div>

    <Br><BR><BR>
                <div class="container p-5  bg-white">
                    <div class="card-header  ">

                        <h5 class="card-title text-center">Evaluation Form</h5>
                    </div>
                    <form method="GET" action="/submitEvaluation" enctype="multipart/form-data">
                        @csrf

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
                            <select id="phoneNumberCode" name="phoneNumberCode" class="form-control"
                                    style="display: none;">
                                @foreach(\App\Models\CountryCode::orderBy('phonecode')->get() as $countryCode)
                                    <option value="{{$countryCode->iso}}"
                                            @if($countryCode->phonecode == 61) selected @endif>
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


                        <div class="form-label-group">

                <label for="location">Location</label>


                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror"
                       name="location" value="{{ old('location') }}" required autocomplete="location" autofocus>
                @error('location')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror


            </div>
            <div class="form-label-group">

                <label for="description">Description</label>


                <textarea id="description" oninput="fun()" type="text" class="form-control @error('description') is-invalid @enderror"
                          name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

                {{--<p  style="display: none"></p>

                <script>
                    function fun (){

                        var i=document.getElementById("txt").value;
                        i = i.replace(/(\r\n|\n|\r)/gm, '<br />');
                        document.getElementById("description").innerHTML = i;
                    }
                </script>*/--}}


            </div>




            <div class="form-label-group">
                <label for="num_bed">Number of bedrooms</label>

                <input id="num_bed" type="number"
                       class="form-control @error('num_bed') is-invalid @enderror" name="num_bed"
                       value="{{ old('num_bed') }}" required autocomplete="num_bed" autofocus>
                @error('num_bed')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>


                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" name="owner"
                                   id="owner" onclick="validate()">
                            <label class="custom-control-label"
                                   for="owner">&nbsp;&nbsp;&nbsp;&nbsp; I am the owner of this user </label>
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" name="check2"
                                   id="check2" onclick="validate()">
                            <label class="custom-control-label"
                                   for="check2">&nbsp;&nbsp;&nbsp;&nbsp; Note that the price will be given based on
                                research, area, and landsize </label>
                        </div>


                        <div class="form-group row mb-0">
                <div class="col-md-6 ">
                    <button type="submit" class=" btn-primary1" id="myBtn" disabled>
                        &nbsp;&nbsp;Send&nbsp;&nbsp;
                    </button>
                </div>
            </div>
        </form>

    </div>
                <script type=text/javascript>
                    function validate(){
                        if (owner.checked == 1 && check2.checked == 1 ){
                            document.getElementById("myBtn").disabled = false;
                        }
                        else{
                            document.getElementById("myBtn").disabled = true;
                        }
                    }
                </script>

@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="p-2"></div>
        <div class="post p-4 my-5">
            <h1>Edit Property:</h1>
            <div class="alert alert-warning">Editing your user will need admin confirmation to get listed again!
            </div>

            {{ Form::open(['action' => ['App\Http\Controllers\PropertiesController@update',$user->id],'method'=>'PUT','files' => true]) }}
            <div class=" creat_app">
                <div class=" ">
                    <div class=" form-group form-label-group special ">
                        {{ Form::label('price','Price:') }}
                        {{ Form::number('price',$user->price,['min' => '0','class' => 'form-control','placeholder'=>'Price']) }}
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class=" form-group form-label-group special ">
                        @if($user->showPrice == 0)
                            {{ Form::checkbox('showPrice',0, false) }}
                        @else
                            {{ Form::checkbox('showPrice',1, true) }}
                        @endif
                        {{ Form::label('showPrice','Show Price') }}
                    </div>
                    <div class="form-group form-label-group">
                        {{ Form::label('bedroomsNumber','Number Of Bedrooms:') }}
                        {{ Form::select('bedroomsNumber',array(0=> 0,1,2,3,4,5=>'5+'),$user->bedroomsNumber,['class' => 'form-control']) }}
                    </div>

                    <div class="form-group form-label-group">
                        {{ Form::label('bathroomsNumber','Number Of Bathrooms:') }}
                        {{ Form::select('bathroomsNumber',array(0=> 0,1,2,3,4=>'4+'),$user->bathroomsNumber,['class' => 'form-control']) }}
                    </div>
                    <div class="form-group form-label-group">
                        {{ Form::label('parkingNumber','Number Of Parking:') }}
                        {{ Form::select('parkingNumber',array(0=> 0,1,2,3,4=>'4+'),$user->parkingNumber,['class' => 'form-control']) }}
                    </div>
                    <div class="form-group form-label-group">
                        {{ Form::label('category','Listing Type:') }}
                        <select name="category">
                            @foreach(\App\Models\Category::all() as $type)
                                <option value="{{$type->id}}"
                                        @if($type->id == $user->categoryId) selected @endIf >{{ $type->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-label-group">
                        {{ Form::label('type','Property Type:') }}
                        <select name="type">
                            @foreach(\App\Models\PropertyType::all() as $type)
                                <option value="{{$type->id}}"
                                        @if($type->id == $user->typeId) selected @endIf>{{ $type->title }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-label-group special">
                        {{ Form::label('description','Description:') }}
                        {{ Form::textarea('description',$user->description,['class' => 'form-control','placeholder'=>'Description']) }}
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group form-label-group special">
                        <input type="checkbox" name="changeImages" onclick="imgs2()"> Change images
                    </div>

                    <div class="form-group form-label-group special" id="imgs" style="display: none">
                        {{ Form::label('images','Images:') }}
                        <div class="form-group form-label-group">
                            <input type="file" name="images[]" id="file" accept=".png, .jpg, .mp4" multiple>
                            <script>
                                var uploadField = document.getElementById("file");

                                uploadField.onchange = function () {
                                    var i = 0;
                                    var space = 0;
                                    for (i = 0; i < this.files.length; i++) {
                                        space += this.files[i].size

                                    }
                                    if (space > 150000000) {
                                        alert("Files are too big!");
                                        this.value = "";
                                    }
                                    ;
                                };
                            </script>
                            @error('images')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-label-group">
                {{ Form::submit('Edit',['class'=>'btn btn-primary1']) }}
            </div>
            {{ Form::close() }}
        </div>
        <div class="p-3"></div>
    </div>

    <script>
        var imgs1= 0;
        function imgs2(){
            if (imgs1 == 0){
                document.getElementById("imgs").style.display = "block";
                imgs1=1;
            }
            else {
                document.getElementById("imgs").style.display = "none";
                imgs1=0;
            }
        }

    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="p-2"></div>
        <div class="post p-4 m-5">
            <h1>Edit Commertcial Property:</h1>
            <div class="alert alert-warning">Editing your user will need admin confirmation to get listed again!
            </div>


            {{-- Form::open(['action' => ['App\Http\Controllers\PropertiesController@update',$com->id],'method'=>'PUT','files' => true]) --}}
            <div class=" creat_app">

                <form action="{{ route('updateCommercial') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="">
                        <div class="raw ">

                            <input type="hidden" name="id" value="{{$com->id}}">

                            <div class="  form-label-group">
                                <label for="price" >Price: </label>
                                <input type="number" id="price" name="price" min="0" class="" value="{{$com->price}}"  placeholder ="Price" required="">
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div><BR/>

                            <div class="  form-label-group special">

                                <input type="checkbox" name="showPrice"  checked>
                                <label for="showPrice">Show Price</label>
                            </div><BR/>
                            <div class="  form-label-group">
                                <label for="category">Listing Type:</label>

                                <select name="category">
                                    <option value="1"   >Sell</option>
                                    <option value="2" >Lease</option>
                                    <option value="3"  >Invest</option>
                                </select>
                            </div><BR/>
                            <div class="  form-label-group">
                                <label for="type">Property Type:</label>

                                <select name="type">

                                    @foreach(\App\Models\commTypes::all() as $type)
                                        <option value="{{$type->id}}"   >{{ $type->title }} </option>
                                    @endforeach
                                </select>
                            </div><BR/>



                            <div class="  form-label-group">
                                <label for="floor">Floor: </label>
                                <input type="number" name="floor" id="floor" value="{{$com->floor}}" class="" placeholder="Floor" required="">
                            </div><BR/>



                            <div class="  form-label-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="" placeholder="Description" required="" >{{$com->description}}</textarea>
                                @error('description')
                                <span class="alert-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                @enderror
                            </div><BR/>


                            <div class="form-group form-label-group special">
                                <input type="checkbox" name="changeImages" onclick="imgs2()"> Change images
                            </div>

                            <div class="form-group form-label-group special" id="imgs" style="display: none">
                                <label for="images" >Images</label>
                                <input type="file" name="images[]" id="file" accept=".png, .jpg, .mp4" multiple>
                                <i class='far fa-question-circle' data-toggle="tooltip" data-placement="top"
                                   title="Supported file types are (mp4/jpg/png)"></i>
                                <br>
                                <small class="ml-3">Total max size = 100M</small>


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

                                    }
                                </script>
                                @error('images')
                                <span class="alert-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                @enderror
                            </div><BR/>


                        </div>
                    </div>




                    <input type="submit" name="submit" id="submit" class="btn-primary1">


                </form>



        </div>
        <div class="p-3"></div>
    </div>
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

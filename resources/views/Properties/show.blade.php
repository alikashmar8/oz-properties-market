@extends('layouts.app')

@section('content')

    <div class="main-content">
        <div class="main2">
            <div class="container  ">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if(!\Illuminate\Support\Facades\Auth::guest())
                    @if(\Illuminate\Support\Facades\Auth::user()->id == $user->userId)
                        {{--                        Owner section--}}
                        <div class=" ">

                            @if($user->accepted == 0)
                                @if($user->contactInfo != null)
                                    <div class="alert alert-danger">
                                        Your user is hidden currently, press show to make it visible!
                                        <a class="btn btn-success " href="/userShowProperty?id={{$user->id}}">Show</a>
                                    </div>

                                @else
                                    <div class="alert alert-danger">
                                        Your property is not accepted yet! Kindly wait admin confirmation.
                                    </div>

                                @endif
                            @else
                                <div class="alert alert-info"> Your user listed successfully.
                                    Press 'hide' button to hide it temporarily.
                                    <a class="btn btn-danger " href="/userHideProperty?id={{$user->id}}">Hide</a>
                                </div>

                            @endif

                            @if($user->contactInfo != null)
                                @if($user->accepted == 0)

                                @else

                                @endif

                            @endif

                        </div>
                    @endif
                @endif
                <div class="post ">
                    @if(!\Illuminate\Support\Facades\Auth::guest() && \Illuminate\Support\Facades\Auth::user()->role == 0 )
                        @if($user->packageId == 4 || $user->packageId == 5 )
                        This property is registered in 'Professional Photography', you can edit it:
                            <a class="btn-primary1 m-3 p-2 " style="color: white" href="/properties/{{$user->id}}/edit">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                Edit
                            </a>
                         @endif
                        <br/>
                    @endif


                    <div id="carouselEx" class="carousel slide carousel-fade " data-ride="carousel">
                        <div class="carousel-inner">
                            @if(count($user->images)>0)
                                @foreach($user->images as $image)
                                    <div class="carousel-item @if($loop->first) active @endif"
                                         style="position: relative; z-index :1;top :0;left :0;width :100%;height :50vw;overflow :hidden;display: flex;">
                                        @if(pathinfo($image->url, PATHINFO_EXTENSION) ==='mp4')
                                            <video class="d-block w-100"
                                                   style="height:  100%; width: 800px;object-fit: cover;" autoplay
                                                   controls muted>
                                                <source
                                                    src="{{url('/storage/properties_images/' . $image->url)}}"
                                                    type="video/mp4">

                                            </video>
                                        @else
                                            <img class="d-block w-100"
                                                 style="height: 50vw; width: 800px;object-fit: contain;"
                                                 src="{{url('/storage/properties_images/' . $image->url)}}"
                                                 alt="No Image">
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <img class="d-block w-100"
                                     src="{{url('/storage/properties_images/unavailable.jpg')}}"
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
                        <i class="fa fa-chevron-right" style="color: #df0505" aria-hidden="true"></i>
                    </span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="dkn">

                        <div class="">
                            <hr>
                            <h3>Details:</h3>

                            <a class="btn-primary1 m-3 p-2 float-right" style="color: white" href="/brochure/{{$user->id}}"> <i class="fas fa-paste"></i> Brochure </a>


                            <div class="post-details ">

                                <p class="price">{{ $user->locationDescription }} </p>


                                <p style="font-size: 22px">
                                    {{$user->bedroomsNumber}} <i class="fa fa-bed"
                                                                 aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
                                    {{$user->bathroomsNumber}} <i class="fa fa-bath"
                                                                  aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
                                    {{$user->parkingNumber}} <i class="fa fa-car"
                                                                aria-hidden="true"></i>&nbsp;
                                    | {{ \App\Models\PropertyType::findOrFail($user->typeId)->title }}
                                </p>

                                @if($user->showPrice == 1)  <p class="price">
                                    $ {{$user->price}} </p>

                                @else
                                    <p class="price">Contact the agent for the price</p>
                                @endif


                                <div class="row"></div>
                                <p style="white-space: pre-line">
                                    <a style="font-size:25px; font-weight: 600;  ">Description:</a>
                                    {{ $user->description }}
                                </p>
                                <p><a style="font-size:25px; font-weight: 600;  ">Placed On:</a>
                                    {{ $user->created_at->toDateString() }}</p>

                                <br/>

                            </div>
                        </div>

                        <br/><br/>
                        <div class="">
                            <hr>
                            {{--      maps   --}}
                            <p id="lat" style="display: none">{{ $user->latitude }}</p>
                            <p id="lng" style="display: none">{{ $user->longitude }}</p>

                            <h3>Location</h3>
                            <br/>

                            <div id="map" style="height: 400px;  width: 100%;"></div>

                            <script>
                                var lat1 = document.getElementById('lat').innerHTML
                                var lng1 = document.getElementById('lng').innerHTML

                                function initMap() {

                                    var location = {lat: parseFloat(lat1), lng: parseFloat(lng1)};

                                    var map = new google.maps.Map(
                                        document.getElementById('map'), {zoom: 15, center: location});

                                    var marker = new google.maps.Marker({
                                        position: location,
                                        map: map   /* , icon:'pinkball.png'*/
                                    });
                                }
                            </script>

                            <script async defer
                                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1CbPQ2HCLV38r9m68B8VCv51JBVke5TM&callback=initMap"></script>


                        </div>
                        <br/>

                        <div class="">
                            <hr>
                            <h3>Inspection time:</h3>
                            @if(!\Illuminate\Support\Facades\Auth::guest() && \Illuminate\Support\Facades\Auth::id() != $user->userId)
                                <p class="date my-1 py-1 px-3 alert-warning">
                                    <small>
                                        Note that when you inspect your name and contact details will be sent to the owner via email.
                                    </small>
                                </p>
                            @endif
                            @if(!\Illuminate\Support\Facades\Auth::guest() && \Illuminate\Support\Facades\Auth::id() == $user->userId)
                                <button class="btn-primary1 float-right " data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa fa-calendar" aria-hidden="true"></i> Set Inspection Time
                                </button>

                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Inspection Time</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="alert alert-warning">
                                                Set new inspection time
                                            </div>

                                            <form action="{{route('setInspection')}}" method="post"   >

                                                @csrf

                                                <div class="modal-body">
                                                    <div class="form-group form-label-group">
                                                        <input type="hidden" value="{{ $user->id }}" name="id">
                                                        <label for="date" class="col-form-label">Date:</label>
                                                        <input type="date" class="form-control"  name="date" required>
                                                    </div>

                                                    <div class="form-group form-label-group">
                                                        <label for="startTime" class="col-form-label">Start Time:</label>
                                                        <input type="time" class="form-control "  name="startTime" required>
                                                    </div>

                                                    <div class="form-group form-label-group">
                                                        <label for="endTime" class="col-form-label">End Time:</label>
                                                        <input type="time" class="form-control "  name="endTime" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-primary2" data-dismiss="modal">Close</button>
                                                    <input type="submit" class="btn btn-success btn-primary2" value="Set">
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <div class="post-details ">
                                <br/>

                            @if( count($inspectionTime)>0  )
                                    <div>
                                @foreach($inspectionTime as $in)

                                    <div class="row" style="border-bottom: 2px solid #e4002b50; width: 100%;">

                                        <div style="display: inline-block">
                                            <p class="date my-1 py-1 px-3">{{$in->date}}: {{$in->startTime}} - {{$in->endTime}}</p>
                                        </div>
                                        <div style="display: inline-block">
                                            @if(!\Illuminate\Support\Facades\Auth::guest() && \Illuminate\Support\Facades\Auth::id() == $user->userId)
                                                <p class="date my-1 px-3 btn-primary1" >
                                                    <a href="/deleteInspection/{{$in->id}}" style="color: white">Delete</a>
                                                </p>
                                            @else
                                                @if(!\Illuminate\Support\Facades\Auth::guest())
                                                    <p class="date my-1 px-3 btn-primary1">
                                                        <a href="/inspect/{{$in->id}}" style="color: white"  id="inpect">Inpect</a>
                                                    </p>

                                                @else
                                                    <p class="date my-1 py-1 px-3 alert-warning"> Login to Inspect</p>

                                                @endif
                                            @endif


                                        </div>
                                    </div>


                                @endforeach
                                </div>

                            @else
                                <p>Contact the owner to arrange a new inspection time</p>

                            @endif





                            </div>


                        </div>
                        <br/><br/>


                        @if(\Illuminate\Support\Facades\Auth::guest())
                            <div class="">
                                <h3>Login to get the contact information</h3>
                            </div>
                        @else


                            <div class="">
                                <hr>

                                <h4>Admin Notes:</h4>
                                <p style="white-space: pre-line; border: none; border-left: 3px solid #e4002b;   padding: 20px; color: #0a0807"> {{ $user->contactInfo }}
                                </p>
                                <BR/>
                                <hr>
                                @if($user->userId != \Illuminate\Support\Facades\Auth::id())

                                    <form action="/contactForProperty" method="get">
                                        @csrf
                                        <h4>Contact the owner about this user:</h4><br/>

                                        <input type="hidden" value="{{ $user->id }}" name="id">
                                        <input type="hidden" value="{{ $user->agent->email }}"
                                               name="email1">
                                        <div class="form-label-group">
                                            <label class="form-label-group" for="message">Message:</label>
                                            <textarea name="message" class="form-control"
                                                      style="height: 300px ; margin-top: 10px;"
                                                      required>
Hi, I am interested to view your user! What is the best time to inspect?
Thanks

Hi, How much is the last price for your user?
Thanks
                                        </textarea>

                                        </div>
                                        <input type="submit" value="Send" class="btn-primary1">

                                    </form>


                                    {{--report--}}
                                    <hr>

                                    <h4>Admin Notes:</h4>
                                    <p style="white-space: pre-line; border: none; border-left: 3px solid #e4002b;   padding: 20px; color: #0a0807"> {{ $user->contactInfo }}
                                    </p>
                                    <BR/>

                                        @if($user->userId != \Illuminate\Support\Facades\Auth::id())
                                        <hr>
                                            <form action="/reportProperty" method="get">
                                                @csrf
                                                <input type="hidden" value="/properties/{{ $user->id }}" name="id">

                                                <div class="form-label-group">
                                                    <h6>Report this listing:</h6>
                                                    <label class="form-label-group" for="message">
                                                        <small>
                                                        If there is inappropriate or incorrect details please report this listing.
                                                        </small>
                                                    </label>


                                                </div>
                                                <input type="submit" value="Send" class="btn-primary1" style="font-size: 12px;padding: 3px">

                                            </form>
                                        @endif
                                @else
                                    <h4>Current Package</h4>
                                    @if($user->packageId > 0)
                                    <p>{{\App\Models\Packages::findOrFail($user->packageId)->title}}
                                        <input type="hidden" id="currentPrice" value="{{\App\Models\Packages::findOrFail($user->packageId)->price}}">
                                    </p>
                                    @else
                                        <p> Please use a package for this property to be listed </p>
                                    @endif
                                    @if($user->sold == 0 )
                                    <div class="  form-label-group">
                                        <div class="row">

                                            <form action="{{ route('upgradePackage') }}" method="post"  >
                                                @csrf
                                                <br/>
                                                <label for="newPackageId">Upgrade your current package for this property:</label>
                                                <br/>
                                                <select name="newPackageId" id="newPackageId" style="font-size: 13px">
                                                    @foreach(\App\Models\Packages::all() as $a  )
                                                        @if( $a->id  < 8 || $a->id > 13  )
                                                            @if($a->id != $user->packageId)

                                                                <option value="{{$a->id}}">{{$a->title}} </option>
                                                            @endif


                                                        @endif
                                                    @endforeach
                                                </select>

                                                <input type="hidden" name="oldPackage" value="{{$user->packageId}}">
                                                <input type="hidden" name="propertyId" value="{{$user->id}}">
                                                <input type="submit" value="Upgrade" class="btn-primary1 float-right" style="color: #fff">
                                            </form>
                                        </div>
                                    </div>
                                    @else
                                        <p class="alert-danger">Your Listing is SOLD</p>
                                    @endif



                                    @if($user->packageId == 6 ||$user->packageId == 7 ||$user->packageId == 11 || $user->packageId == 12 ||$user->packageId == 13 )
                                        <hr>
                                        <h4>PDF Application</h4>
                                        <div class="  form-label-group">
                                            <div class="row">

                                                <form action="{{ route('getPdf') }}" method="get"  >
                                                    @csrf
                                                    <br/>
                                                    <label for="state">Select the state:</label>
                                                    <br/>
                                                    <select name="state" id="state" >
                                                        <option value="WA">WA </option>
                                                        <option value="SA">SA </option>
                                                        <option value="NSW">NSW </option>
                                                        <option value="NT">NT </option>
                                                        <option value="VIC">VIC </option>
                                                        <option value="QLD">QLD </option>
                                                        <option value="ACT">ACT </option>
                                                    </select>
                                                    <input type="submit" value="Download" class="btn-primary1 float-right" style="color: #fff">
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                        {{--@if($user->sold == 0 )
                                        <hr>
                                        <h4>Mark as <b>SOLD</b></h4>
                                        <div class="  form-label-group">
                                            <div class="row">
                                                <p style="  border: none; border-left: 3px solid #e4002b;   padding: 20px; color: #0a0807">
                                                    If you sold this listing please click bellow. The listing will be marked as "SOLD"
                                                    for 2 weeks and the deleted with its package.
                                                </p>
                                                <form action="{{ route('soldProperty') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{$user->id}}" name="propertyId">
                                                    <input type="submit" value="Proceed" class="btn-primary1" style="color: #fff; ">
                                                </form>
                                            </div>
                                        </div>
                                    @endif--}}

                                @endif
                            </div>
                        @endif

                        <br><br>


                    </div>


                </div>

            </div>
        </div>
        <div class="main3">

        </div>
    </div>


@endsection


<html>

<head>
    <title></title>

    <style>
        @page { margin: 0px; }
        body{
            font-family: "Open Sans", Arial, sans-serif;
            width: 760px;
            padding: 0;
            margin: 0;

        }/*
        table, th, td {
            border: 1px solid black;
            border-spacing: 10px;
            border-collapse: separate;
            max-width: 100%;
        }
        img{
            max-width: 100%;
        }*/

    </style>

</head>
<body >

<table  style="margin: 0 ; width: 760px; ">
   <tr style="height:10%;  " >
       <td colspan="2" style="height:10%;  padding: 10px; margin: 0px; background: #e4002b; color: white; ">
           <h1 style="font-family: 'Sansita Swashed', cursive !important;">{{$property->locationDescription}}</h1>
           <p class="" style="">
               @if($property->categoryId == 1 )
                   Sale
               @elseif($property->categoryId == 2)
                   Rent
               @else
                   Share
               @endif
               | $ {{$property->price}} <small>AUD</small></p>
       </td>
   </tr>

    <tr class="my-3" style="height: 50%; ">
        <td >
            <br/><br/>
            @if(count($property->images)>0)
                <p style="display: none"> {{$i=0}}</p>
                <table>
                    @foreach($property->images as $image )
                        @if(pathinfo($image->url, PATHINFO_EXTENSION) !='mp4')
                            <p style="display: none"> {{$i++}}</p>
                            @if($i == 1)
                                <tr  >
                                    <td colspan="2" rowspan="2">
                                        <div  style="width: 500px;height: 300px ; display: block;margin-bottom: 0px ">
                                            <img class=""
                                                 style="width:auto;max-width: 500px;height:100% ;object-fit: cover; "
                                                 src="storage/properties_images/{{$image->url}}"
                                                 alt="No Image">
                                        </div>
                                    </td>
                            @elseif($i==2)
                                        <td>
                                            <div  style="width: 250px;height: 150px ; display: block; margin-top: 0px ;">
                                                <img class=""
                                                     style="width:auto;max-width: 250px;height:100% ; object-fit: cover; "
                                                     src="storage/properties_images/{{$image->url}}"
                                                     alt="No Image">
                                            </div>
                                        </td>
                                </tr>
                            @elseif($i==3)
                                <tr>
                                    <td>
                                        <div  style="width: 250px;height: 150px ; display: block; margin-top: 0px ;">
                                            <img class=""
                                                 style="width:auto;max-width: 250px;height:100% ; object-fit: cover; "
                                                 src="storage/properties_images/{{$image->url}}"
                                                 alt="No Image">
                                        </div>
                                    </td>
                                </tr>
                            @elseif($i==4)
                                <tr>
                                    <td  >
                                        <div  style="width: 250px;height: 150px ; display: block; margin-top: 0px ;">
                                            <img class=""
                                                 style="width:auto;max-width: 250px;height:100% ; object-fit: cover; "
                                                 src="storage/properties_images/{{$image->url}}"
                                                 alt="No Image">
                                        </div>
                                    </td>
                            @elseif($i==5)
                                    <td>
                                        <div  style="width: 250px;height: 150px ; display: block; margin-top: 0px ;">
                                            <img class=""
                                                 style="width:auto;max-width: 250px;height:100% ; object-fit: cover; "
                                                 src="storage/properties_images/{{$image->url}}"
                                                 alt="No Image">
                                        </div>
                                    </td>
                            @elseif($i==6)
                                    <td>
                                        <div  style="width: 250px;height: 150px ; display: block; margin-top: 0px ;">
                                            <img class=""
                                                 style="width:auto;max-width: 250px;height:100% ; object-fit: cover; "
                                                 src="storage/properties_images/{{$image->url}}"
                                                 alt="No Image">
                                        </div>
                                    </td>
                                </tr>

                            @endif
                        @endif

                    @endforeach

                </table>

            @endif
        </td>

    </tr>

    <tr style="height: 40%;">
        <td style="  ">
            <p style="white-space: pre-line">{{$property->description}}</p>

            <br/><br/>

            <p style="font-size: 22px">
                {{$property->bedroomsNumber}} <img src="logo/bed.png" style="width: 30px">&nbsp;&nbsp;&nbsp;
                {{$property->bathroomsNumber}} <img src="logo/bath.png" style="width: 30px">&nbsp;&nbsp;&nbsp;
                {{$property->parkingNumber}} <img src="logo/car.png" style="width: 30px">&nbsp;
                | {{ \App\Models\PropertyType::findOrFail($property->typeId)->title }}


                <img src="logo/logo2.png"  style="width :20%; float: right;transform: translateY(-50%);">
            </p>
        </td>
    </tr>
</table>
<br/><br/>

<p style="text-align: center; font-weight: bold;">
    Thank you for choosing Oz property market
</p>


</body>
</html>

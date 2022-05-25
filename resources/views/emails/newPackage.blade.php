{{--@component('mail::message')--}}
<body style="margin: 15px;background: #ffffff ; font-family: 'Roboto', sans-serif;">
<div style="text-align: center; width: 100%; margin: auto; ">
    <img src="{{asset('/images1/logo.png')}}" style="max-height: 150px" >
</div>
<bR/>
<div style="width: 85%; background: #fff; color: #0a0807;text-align: left;   margin: auto; padding: 20px">
    <h1> Thank you for registering in {{$target->package}} </h1>

    <p> To get your invoice please click bellow</p>

    @component('mail::button', ['url' => URL::to('/invoice/'.$target->id)])
        Check It
    @endcomponent
    <br>
    <p> You can see all your packages <a href="http://127.0.0.1:8000/userPayments" style="color: #0b0b0b" ><b>here</b></a> </p><br>

    Thank you,<br>
    <hr>
    <h2>OZ Property Market</h2>

    <p ><small >© 2020 Real Estate, all Rights Reserved. Developed by <a href="https://webside.com.au/" target="_blank" style="color: #e4002b">WebSide</a> </small></p>

</div>
</body>
{{--@endcomponent--}}



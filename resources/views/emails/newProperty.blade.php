{{--@component('mail::message')--}}
<body style="margin: 15px;background: #ffffff ; font-family: 'Roboto', sans-serif;">
    <div style="text-align: center; width: 100%; margin: auto; ">
        <img src="{{asset('/images1/logo.png')}}" style="max-height: 150px" >
    </div>
    <bR/>
    <div style="width: 85%; background: #fff; color: #0a0807;text-align: left;   margin: auto; padding: 20px">
        <h1> New Property is Added </h1>




    @component('mail::button', ['url' => URL::to('/acceptProperties')])
        Check It
    @endcomponent

    Thank you,<br>
        <hr>
        <h2>OZ Property Market</h2>

            <p ><small >© 2020 Real Estate, all Rights Reserved. Developed by <a href="https://webside.com.au/" target="_blank" style="color: #e4002b">WebSide</a> </small></p>

    </div>
</body>
{{--@endcomponent--}}



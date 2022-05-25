{{--@component('mail::message')--}}
    <body style="margin: 15px;background: #ffffff ; font-family: 'Roboto', sans-serif;">
    <div style="text-align: center; width: 100%; margin: auto; ">
        <img src="{{asset('/images1/logo.png')}}" style="max-height: 150px">
    </div>
    <bR/>
    <div style="width: 85%; background: #fff; color: #0a0807;text-align: left;   margin: auto; padding: 20px">
        <h1> Please evaluate this <b>property</b></h1>


        <h3>Contact Details:</h3>
        <p>Sender: {{ $data['name'] }}  </p>
        <p>Email: {{ $data['email'] }}</p>
        <p>Phone Number: {{ $data['phoneNumberCode'] }}-{{ $data['phoneNumber'] }}</p>

        <H3>Property Details</H3>
        <p>Location: {{ $data['location'] }}</p>
        <p style="white-space: pre-line ">Description: {{ $data['description'] }}</p>
        <p>Number Of Bedrooms: {{ $data['bedroomsNumber'] }}</p>
        <p>Owner? {{ $data['owner'] }}</p>

        Thank you,<br>
        <hr>
        <h2>OZ Property Market</h2>

        <p ><small >© 2020 Real Estate, all Rights Reserved. Developed by <a href="https://webside.com.au/" target="_blank" style="color: #e4002b">WebSide</a> </small></p>

    </div>
    </body>
    {{--@endcomponent--}}




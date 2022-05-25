{{--@component('mail::message')--}}

<body style="margin: 15px;background: #ffffff ; font-family: 'Roboto', sans-serif;">
<div style="text-align: center; width: 100%; margin: auto; ">
    <img src="{{asset('/images1/logo.png')}}" style="max-height: 150px">
</div>
<bR/>

<div style="width: 85%; background: #fff; color: #0a0807;text-align: left;   margin: auto; padding: 20px">
    <h1> A user is contacting you regarding your property</h1>


    <p>User Name: {{ $data['userName'] }} </p><br/>

    <p>User Email: {{ $data['userEmail'] }} </p><br/>

    <p>Property ID: {{ $data['propertyId'] }} </p> <br/>

    <p style="white-space: pre-line"> Message: {{ $data['message'] }} </p><br/>



    Thank you,<br>

    <hr>
    <h2>OZ Property Market</h2>

    <p ><small >© 2020 Real Estate, all Rights Reserved. Developed by <a href="https://webside.com.au/" target="_blank" style="color: #e4002b">WebSide</a> </small></p>

</div>
</body>


{{--@endcomponent--}}

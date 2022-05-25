<body style="margin: 15px;background: #ffffff ; font-family: 'Roboto', sans-serif;">
<div style="text-align: center; width: 100%; margin: auto; ">
    <img src="{{asset('/images1/logo.png')}}" style="max-height: 150px">
</div>
<bR/>
<div style="width: 85%; background: #fff; color: #0a0807;text-align: left;   margin: auto; padding: 20px">
    <h1>Reset Password</h1>
    Forgotten your password?
    <br>

    You have been sent this email because we received a request to reset the password to your account.
    <br>
    To do this, please click the button below to enter a new password of your choice.

    @component('mail::button', ['url' => URL::to('password/reset/' . $token . '?email=' . urlencode($email))])
        Click Here
    @endcomponent

    <br>
    If you have not sent a request to reset your password, please ignore this email.
    <br>
    Thank you,<br>
    <hr>
    <h2>OZ Property Market</h2>

    <p><small>© 2020 Real Estate, all Rights Reserved. Developed by <a href="https://webside.com.au/" target="_blank"
                                                                       style="color: #e4002b">WebSide</a> </small></p>

</div>
</body>





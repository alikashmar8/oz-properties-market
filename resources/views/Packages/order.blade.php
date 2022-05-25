@extends('layouts.app')

@section('content')
    <div class="container  ">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">

                    <div class="card-header">Membership Registion</div>

                    <div class="card-body">
                        <p class="card-title">{{$pack->title}}</p>
                        <table class="table">
                            <tr>
                                <td>
                                    Price
                                </td>
                                <td>
                                    <a id="price">{{$pack->amount}}</a>
                                </td>
                            </tr>
                            @if(!\Illuminate\Support\Facades\Auth::guest())
                                @if(\Illuminate\Support\Facades\Auth::user()->role < 2)
                                    @if($pack->id < 6 || ($pack->id > 7 && $pack->id < 11))
                            <tr>
                                <td colspan="2">
                                    <input id="additioanl" type="checkbox" class="icon-" onclick="additional_clicked()">
                                    <label for="additioanl">
                                        Apply 30-Days sponsorship.
                                    </label>

                                    <script>
                                        var additional = document.getElementById("additioanl");
                                        var y = 0;
                                        function additional_clicked(){
                                            if(additional.checked ){
                                                y = parseInt(document.getElementById('total').innerHTML);
                                                y += 99;
                                                y = y.toFixed(2);
                                                document.getElementById('total').innerHTML = y ;
                                                document.getElementById('amount').value = y ;
                                                document.getElementById('apply').value = 1;

                                            }else{
                                                y = parseInt(document.getElementById('total').innerHTML);
                                                y -= 99;
                                                y = y.toFixed(2);
                                                document.getElementById('total').innerHTML = y ;
                                                document.getElementById('amount').value = y ;
                                                document.getElementById('apply').value = 0;
                                            }

                                        }
                                    </script>
                                </td>

                            </tr>
                                    @endif
                                @endif
                            @endif
                            <!--tr>
                                <td>
                                    Tax
                                </td>
                                <td>
                                    0%

                                </td>
                            </tr-->
                            <tr>
                                <td>
                                    <b>Total</b>
                                </td>
                                <td>
                                    $ <b id="total"></b> AUD
                                </td>
                            </tr>

                            <form action="{{ route('storePayment') }}" method="post">
                                @csrf
                                <tr style="display: none;">
                                    <td colspan="2">

                                        <input type="radio" name="payment_method" value="paypal" id="paypal" >
                                        <label for="paypal">Paypal</label><br>
                                        <input type="radio" name="payment_method" value="stripe" id="stripe" checked>
                                        <label for="stripe">Stripe</label><br>
                                        <input type="radio" name="payment_method" value="Bank" id="Bank">
                                        <label for="Bank">Bank Account</label><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <center>

                                                <input type="hidden" value="{{$pack->title}}" name="package">

                                                <input type="hidden" name="apply" id="apply" >
                                                <input type="hidden" value="" id="amount" name="amount">
                                                <input type="submit" value="Pay now" class="btn-primary1">


                                        </center>
                                    </td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var x =  parseInt(document.getElementById('price').innerHTML);
        //x += x * 0.095;
        x = x.toFixed(2);
        document.getElementById('total').innerHTML =x;
        document.getElementById('amount').value =x;
        document.getElementById('apply').value = 0;
    </script>
@endsection

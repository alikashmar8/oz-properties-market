@extends('layouts.app')

@section('content')
    <div class="hero" style=" background-image: url({{asset('/images1/profile.jpg')}});
    ">
        <div
            style="position: absolute; width:100%;top: 0;height: 20px; background-image: linear-gradient(#df0505, transparent); ">

        </div>
        <div class="inner">
            <h1>Histories</h1>
        </div>
    </div>
    <div class="row container py-0" style="margin: auto">
        <div class="col-md-1 ">  </div>

        <div class="col-md-5 bg-white p-2 my-3">
            <a href="/histories/properties" style="color: #e4002b">
                <h3 style="display: inline-block;margin: auto; padding: 20px">Properties </h3>
            </a>
            <div class="float-right" style="opacity: 0.7;">
                <i class="fa fa-home fa-5x" aria-hidden="true"></i>
            </div>

        </div>
        <div class="col-md-1 ">  </div>

        <div class="col-md-5 bg-white p-2 my-3">
            <a href="/histories/commercials" style="color: #e4002b;">
                <h3 style="display: inline-block;margin: auto; padding: 20px">Commercials </h3>
            </a>
            <div class="float-right" style="opacity: 0.7;">
                <i class="fa fa-building fa-5x" aria-hidden="true"></i>
            </div>
        </div>
        <div class="col-md-1 ">  </div>

        <div class="col-md-5 bg-white p-2 my-3">
            <a href="/histories/users" style="color: #e4002b">
                <h3 style="display: inline-block;margin: auto; padding: 20px">Users </h3>
            </a>
            <div class="float-right" style="opacity: 0.7;">
                <i class="fa fa-user fa-5x" aria-hidden="true"></i>
            </div>
        </div>
    </div>

@endsection

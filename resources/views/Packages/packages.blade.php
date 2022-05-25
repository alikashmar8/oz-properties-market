@extends('layouts.app')

@section('content')
<div class="container">

    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
</div>

    @include('Packages.template')
@endsection

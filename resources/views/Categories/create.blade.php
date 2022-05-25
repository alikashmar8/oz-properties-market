@extends('layouts.app')

@section('content')
    <div class="container bg-light">
        <h1>Create New Category:</h1>
        <div>
            {{ Form::open(['action' => 'App\Http\Controllers\CategoriesController@store','method'=>'POST']) }}
            <div class="form-group">
                {{ Form::label('title','Title:') }}
                {{ Form::text('title','',['class' => 'form-control','placeholder'=>'title']) }}
            </div>
            <div>
                {{ Form::submit('Add',['class'=>'btn btn-primary']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection

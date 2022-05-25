@extends('layouts.app')

@section('content')
    <div class="container bg-dark">
        <div class="p-3"></div>
        <h1 class="text-white">Edit {{$category->title}}:</h1>
        <div>
            {{ Form::open(['action' => ['App\Http\Controllers\CategoriesController@update',$category->id],'method'=>'PUT']) }}
            <div class="form-group">
                {{ Form::label('title','Title:',['class' => 'text-white']) }}
                {{ Form::text('title',$category->title,['class' => 'form-control','placeholder'=>'title']) }}
            </div>
            <div>
                {{ Form::submit('Edit',['class'=>'btn btn-primary']) }}
            </div>
            {{ Form::close() }}
        </div>
        <div class="p-3"></div>
    </div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="title">{{$media->title ? $media->title : 'Untitled'}}</h2>
    <div class="columns">
        <div class="column">
        	<img src="{{$media->filename}}" alt="{{$media->description}}">
        	<p>{{$media->description}}</p>
        	<a href="{{$media->url}}" target="_blank">Source</a>
        </div>

        
    </div>

    
    </div>
</div>
@endsection

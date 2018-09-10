@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="title">Gallery</h2>
    <div class="columns is-mobile is-multiline">
        @foreach($media as $m)
        <div class="column is-half-mobile is-one-third-tablet is-one-fifth-desktop">
            <a href="{{route('gallery')}}">
                
                <div class="card">
                    <div class="card-image">
                        <figure class="image">
                            <img src="{{$m->filename}}" alt="{{$m->description}}">                        
                        </figure>
                    </div>

                    <div class="card-content is-size-7">
                        {{$m->description}}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    
    {{ $media->links('') }}
    
    </div>
</div>
@endsection

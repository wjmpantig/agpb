@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns is-mobile is-multiline">
        @foreach($profile->media as $m)
        <div class="column is-half-mobile is-one-third-tablet is-one-fifth-desktop">
            <a href="{{route('media',['id'=>$m->id])}}">
                
                <div class="card">
                    <div class="card-image">
                        <figure class="image">
                            <img src="{{$m->filename}}" alt="{{$m->description}}">                        
                        </figure>
                    </div>

                    <div class="card-content is-size-7">
                        {{$m->id}} : {{$m->description}}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection

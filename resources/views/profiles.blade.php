@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns is-mobile is-multiline">
        @foreach($profiles as $profile)
        <div class="column is-half-mobile is-one-third-tablet is-one-fifth-desktop">
            <div class="card">
                <div class="card-image">
                    
                </div>

                <div class="card-content has-text-centered">
                    {{$profile->name}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

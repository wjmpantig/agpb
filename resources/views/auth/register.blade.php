@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column">
            <div class="card">
                <div class="card-header">
                    <p class="card-header-title">{{ __('Register') }}</p>
                </div>

                <div class="card-content">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        <div class="field">
                            <label for="name" class="label">{{ __('Name') }}</label>

                            <div class="control">
                                <input id="name" type="text" class="input {{ $errors->has('name') ? ' is-danger' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <p class="help is-danger" role="alert">
                                        {{ $errors->first('name') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                            <div class="field">
                                <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <p class="invalid-feedback" role="alert">
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label for="password" class="label">{{ __('Password') }}</label>

                            <div class="field">
                                <input id="password" type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <p class="invalid-feedback" role="alert">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="input" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-info">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

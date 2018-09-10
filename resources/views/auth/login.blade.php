@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column">
            <div class="card">
                <div class="card-header">
                    <p class="card-header-title">{{ __('Login') }}</p>
                </div>

                <div class="card-content">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="field">
                            <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                            <div class="control">
                                <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <p class="help is-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <label for="password" class="label">{{ __('Password') }}</label>

                            <div class="control">
                                <input id="password" type="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <p class="help is-danger" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-info">
                                    {{ __('Login') }}
                                </button>

                                <a class="button" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column">
            <div class="card">
                <div class="card-header">
                    <p class="card-header-title">{{ __('Reset Password') }}</p>
                </div>

                <div class="card-content">
                    @if (session('status'))
                        <div class="message is-success" role="alert">
                            <div class="message-body">{{ session('status') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

                        <div class="field">
                            <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                            <div class="control">
                                <input id="email" type="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <p class="help is-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-info">
                                    {{ __('Send Password Reset Link') }}
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

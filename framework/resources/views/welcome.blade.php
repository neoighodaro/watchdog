@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="top-right links">
            <a href="https://github.com/hotelsng/watchdog" target="_blank">@lang('app.contribute')</a>
        </div>

        <div class="content">
            <div class="watchdog-logo">
                <img src="{{ asset('img/watchdog-small.png') }}">
            </div>
            <div class="title m-b-md">Watchdog!</div>
            <div class="login-form">
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="username-input">
                        <input type="email" name="email" class="login-input username" placeholder="@lang('app.email_address')" value="{{ old('email') }}" />
                    </div>
                    <div class="password-input">
                        <input type="password" name="password" class="login-input password" placeholder="@lang('app.password')" />
                    </div>
                    <div class="submit-button">
                        <button type="submit" class="submit-btn" disabled>@lang('app.login')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
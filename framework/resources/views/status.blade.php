@extends('layouts.app')

@section('content')
    <div class="contain">
        <div class="position-ref full-height">
            <div class="header">
                <div class="top-center logo">
                    <img src="{{ asset('img/watchdog-small.png') }}">
                </div>
                <div class="centered links">
                    <a href="#" title="@lang('app.manage_services')">@lang('app.manage_services')</a>
                    <a href="{{ route('logout') }}" title="@lang('app.logout')">@lang('app.logout')</a>
                </div>
            </div>

            <div class="page-status status-none">
              <span class="status font-large">
                All Systems Operational
              </span>
                <span class="last-updated-stamp  font-small">Refreshed a minute ago</span>
            </div>
        </div>
    </div>
@stop
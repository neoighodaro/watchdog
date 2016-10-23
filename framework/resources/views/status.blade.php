@extends('layouts.app')

@section('title', 'Status')

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

            @if ($pageStatus === App\Status::HEALTHY)
            <div class="page-status status-none">
              <span class="status font-large">
                All Systems Operational
              </span>
                <span class="last-updated-stamp font-small">Refreshed about a minute ago</span>
            </div>
            @endif

            <!--div class="page-status status-warning">
              <span class="status font-large">
                All Systems Operational
              </span>
                <span class="last-updated-stamp font-small">Refreshed a minute ago</span>
            </div>
            <div class="page-status status-danger">
              <span class="status font-large">
                All Systems Operational
              </span>
                <span class="last-updated-stamp font-small">Refreshed a minute ago</span>
            </div-->

            <ul class="services">
            @foreach ($services as $service)
                <li>
                    <div class="service-name">
                        {{ $service->name }}
                    </div>

                    <div class="status">
                    <!-- @todo should use icons instead... -->
                    @if ( ! $service->hasRunAtLeastOnce())
                        Not Run
                    @else
                        {{ $service->isServiceOk() ? "Cool" : "Not Cool" }}
                    @endif
                    </div>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
@stop
@extends('layouts.app')

@section('title', 'Status')

@section('content')
    <div class="contain">
        <div class="position-ref full-height">
            <div class="header">
                <div class="top-center logo">
                    <img src="{{ asset('img/watchdog-small.png') }}">
                    <h1 class="page-title">STATUS</h1>
                </div>
                {{--
                <div class="centered links">
                    <a href="#" title="@lang('app.manage_services')">@lang('app.manage_services')</a>
                    <a href="{{ route('logout') }}" title="@lang('app.logout')">@lang('app.logout')</a>
                </div>
                --}}
            </div>

            @if ($pageStatus === App\Status::HEALTHY)
            <div class="page-status status-none">
              <span class="status font-large">
                All Systems Operational
              </span>
                <span class="last-updated-stamp font-small">Last Checked {{ ucwords($summary['lastCheck']->diffForHumans()) }}</span>
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
                <li class="clearfix">
                    <div class="service-name pull-left">
                        <h3 class="title">
                            {{ $service->name }}
                            <a class="url" href="{{ $service->url }}" target="_blank">{{ $service->url }}</a>
                        </h3>
                    </div>

                    <div class="status pull-right">
                    @if ( ! $service->hasRunAtLeastOnce())
                        <span class="status unknown">Unknown</span>
                    @else
                        <span class="status {{ $service->isOk() ? 'is-' : 'not-' }}operational">
                            {{ $service->isOk() ? "Operational" : "Non-Operational" }}
                        </span>
                    @endif
                    </div>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
@stop
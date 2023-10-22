@extends('layouts.app')
@yield('main-css')
@section('content')
<link rel='stylesheet' href="{{asset('css/profile/profile-style.css')}}" media='all' />

<div id="content" class="site-content">

    <div class="container rounded bg-white mt-5 mb-5" ng-cloak class="ng-cloak">
        <div class="row">
            <div class="success-message col-md-12" style="position:relative;">

            </div>
            @include('content.menu.admin-sidebar')
            @yield('main-body')
        </div>
    </div>
</div>

@endsection

@section('javascripts')

@yield('js-controller')

@endsection
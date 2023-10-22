@extends('layouts.app')
@section('content')
<link rel='stylesheet' href="{{asset('css/find-staff/find-staff-style.css')}}" media='all' />

<div id="content" class="site-content" ng-controller='findStaffCtrl' id="findStaffCtrl" ng-init="init()" ng-cloak class="ng-cloak">

    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            @include('content.find-staff.sidebar')
            @yield('main-body')
        </div>
    </div>
</div>

@endsection

@section('javascripts')
<script src="{{ ('/app/find-staff-controller.js') }}"></script>
<script type="text/javascript">

function inArray(id) {
    var scope = angular.element(document.getElementById('findStaffCtrl')).scope();
    scope.skillvalues
    console.log(scope.skillvalues);
    return true;
}
</script>
@endsection
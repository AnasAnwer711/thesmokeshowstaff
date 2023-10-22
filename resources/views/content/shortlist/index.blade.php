@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/profile/shortlist-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='shortlistCtrl' ng-init="init();" ng-cloak class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">Shortlist Jobs</h4>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div ng-show="shortlists.length < 1" class="col-md-12 text-center p-3 bg-light">
                <h5>
                    Your shortlist is currently empty. Add [[auth_user.is_staff ? 'job' : 'a staff member']] to your
                    shortlist for easy reference later on.
                </h5>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 mb-3" ng-repeat="shortlist in shortlists"
                ng-if="shortlist.type == 'job' && auth_user.is_staff">
                @include('content.shortlist.job')
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 mb-3" ng-repeat="shortlist in shortlists"
                ng-if="shortlist.type == 'staff' && auth_user.is_host">
                @include('content.shortlist.staff')
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/shortlist-controller.js') }}"></script>
@endsection
@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />
@section('main-css')

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='staffRequestsCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Staff Requests</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="active-member">
                            <div class="table-responsive" ng-show="staffRequests.length > 0">
                                <table class="table table-xs mb-0">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>GENDER</th>
                                            <th>REGISTERED DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="sr in staffRequests">
                                            <td>[[sr.name]]</td>
                                            <td>[[sr.gender]]</td>
                                            <td>[[convertUtcToLocalDate(sr.created_at)]]</td>
                                            <td><a href="/admin/profile/[[sr.id]]" class="btn">View Application</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center" ng-show="staffRequests.length == 0">
                                <p>No staff requests yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/staff-requests-controller.js') }}"></script>
@endsection
@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />
@section('main-css')

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='usersCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Users</h4>
                    <div class="form-group p-2 mb-0">
                        <select class="form-control" ng-change="getUsers({'role':refineUserModel.role})" ng-model="refineUserModel.role">
                            <option value="" disabled>Hiring Staff</option>
                            <option value="staff">Staff</option>
                            <option value="host">Host</option>
                            <option value="both">Both</option>

                        </select>
                    </div>
                    <div class="form-group p-2 mb-0">
                        <select class="form-control" ng-change="getUsers({'job_status':refineUserModel.status})" ng-model="refineUserModel.status">
                            <option value="" disabled>Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved" selected>Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="blocked">Blocked</option>

                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="active-member">
                            <div class="table-responsive" ng-show="users.length > 0">
                                <table class="table table-xs mb-0">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>ROLE</th>
                                            <th>REGISTERED DATE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="user in users">
                                            <td>[[user.name]]</td>
                                            <td style="text-transform: uppercase;">[[user.roles[0].name]]</td>
                                            <td>[[convertUtcToLocalDate(user.created_at)]]</td>
                                            <td><a href="/admin/profile/[[user.id]]" class="btn">View Application</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center" ng-show="users.length == 0">
                                <p>No users found.</p>
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
<script src="{{ ('/app/users-controller.js') }}"></script>
@endsection